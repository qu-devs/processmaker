<template>
  <div
    :id="filterTableId"
    class="pm-table-container"
  >
    <table
      class="pm-table-filter"
      aria-label="custom-pm-table"
      @mouseleave="handleRowMouseleave"
    >
      <thead>
        <tr>
          <th
            class="pm-table-border"
            :colspan="visibleHeaders.length"
          />
        </tr>
        <tr>
          <th
            v-for="(column, index) in visibleHeaders"
            :id="`${tableName}-column-${index}`"
            :key="index"
            class="pm-table-ellipsis-column"
            :class="{ 'pm-table-filter-applied': column.filterApplied }"
          >
            <div
              class="pm-table-column-header"
              :style="{ width: column.width + 'px' }"
            >
              <slot :name="column.field">
                {{ $t(column.label) }}
              </slot>
            </div>
            <div class="pm-table-filter-button">
              <slot :name="`filter-${column.field}`" />
            </div>
            <div
              v-if="index !== visibleHeaders.length - 1"
              class="pm-table-column-resizer"
              @mousedown="startResize($event, index)"
            />
            <b-tooltip
              v-if="column.tooltip"
              :target="`${tableName}-column-${index}`"
              custom-class="pm-table-tooltip-header"
              placement="bottom"
              delay="500"
            >
              {{ column.tooltip }}
            </b-tooltip>
          </th>
        </tr>
        <tr>
          <th
            class="pm-table-border"
            :colspan="visibleHeaders.length"
          />
        </tr>
      </thead>
      <tbody>
        <template v-if="!loading">
        <tr
          v-for="(row, rowIndex) in data.data"
          :key="rowIndex"
          :id="`row-${row.id}`"
          :class="{ 
              'pm-table-unread-row': isUnread(row, unread),
              'pm-table-selected-row': selectedRow !== 0 && selectedRow === row.id
          }"
          @click="handleRowClick(row, $event)"
          @mouseover="$emit('table-row-mouseover', row, rowIndex)"
          @mouseleave="$emit('table-tr-mouseleave', row, rowIndex)"
        >
          <slot :name="`row-${rowIndex}`">
            <td
              v-for="(header, index) in visibleHeaders"
              :key="index"
            >
              <template v-if="containsHTML(getNestedPropertyValue(row, header))">
                <div
                  :id="`${tableName}-element-${rowIndex}-${index}`"
                  :class="{ 'pm-table-truncate': header.truncate }"
                  :style="{ maxWidth: header.width + 'px' }"
                >
                  <div v-html="sanitize(getNestedPropertyValue(row, header))"></div>
                </div>
                <b-tooltip
                  v-if="header.truncate"
                  :target="`${tableName}-element-${rowIndex}-${index}`"
                  custom-class="pm-table-tooltip"
                  @show="checkIfTooltipIsNeeded"
                >
                  {{ sanitizeTooltip(getNestedPropertyValue(row, header)) }}
                </b-tooltip>
              </template>
              <template v-else>
                <template v-if="isComponent(row[header.field])">
                  <component
                    :is="row[header.field].component"
                    v-bind="row[header.field].props"
                  />
                </template>
                <template v-else>
                  <slot :name="'cell-' + header.field" :row="row" :header="header" :rowIndex="rowIndex">
                    <div
                      :id="`${tableName}-element-${rowIndex}-${index}`"
                      :class="{ 'pm-table-truncate': header.truncate }"
                      :style="{ maxWidth: header.width + 'px' }"
                    >
                      {{ getNestedPropertyValue(row, header) }}
                      <b-tooltip
                        v-if="header.truncate"
                        :target="`${tableName}-element-${rowIndex}-${index}`"
                        custom-class="pm-table-tooltip"
                        @show="checkIfTooltipIsNeeded"
                      >
                        {{ getNestedPropertyValue(row, header) }}
                      </b-tooltip>
                    </div>
                  </slot> 
                </template>
              </template>
            </td>
          </slot>
        </tr>
        </template>
      </tbody>
    </table>
  </div>
</template>

<script>

import moment from "moment";
import FilterTableBodyMixin from "./FilterTableBodyMixin";

export default {
  components: {
  },
  mixins: [FilterTableBodyMixin],
  props: {
    headers: {
      type: Array,
      default() {
        return [];
      },
    },
    data: [],
    unread: {
      type: String,
      default() {
        return "";
      }
    },
    loading: {
      type: Boolean,
      default() {
        return false;
      }
    },
    tableName: {
      type: String,
      default() {
        return "";
      }
    },
    selectedRow: {
      type: Number,
      default: 0,
    },
    filterTableId: {
      type: String,
      default: "table-container",
    }
  },
  data() {
    return {
      hoveredColumn: null,
      isResizing: false,
      startX: 0,
      startWidth: 0,
      resizingColumnIndex: -1,
    };
  },
  computed: {
    visibleHeaders() {
      return this.headers.filter((column) => !column.hidden);
    },
  },
  mounted() {
    this.$nextTick(() => {
      this.calculateColumnWidth();
      const ellipsisColumn = document.querySelectorAll(".pm-table-ellipsis-column");

      ellipsisColumn.forEach((column) => {
        column.addEventListener("click", this.handleEllipsisClick);
      });
      window.addEventListener("resize", this.handleWindowResize);
    });
  },
  beforeDestroy() {
    window.removeEventListener("resize", this.handleWindowResize);
  },
  methods: {
    handleWindowResize() {
      const zoomFactor = window.devicePixelRatio;
      let widthAdjust = 1;
      if (zoomFactor < 1) {
        widthAdjust = Math.min(zoomFactor, this.minZoom);
      }
      this.calculateColumnWidth(widthAdjust);
    },
    calculateColumnWidth(widthAdjust = 1) {
      this.visibleHeaders.forEach((headerColumn, index) => {
        if (this.calculateContent(index) !== 0) {
          headerColumn.width = (this.calculateContent(index) * widthAdjust) - 32;
        }
      });
    },
    startResize(event, index) {
      this.isResizing = true;
      this.calculateColumnWidth();
      this.resizingColumnIndex = index;
      this.startX = event.pageX;
      this.startWidth = this.visibleHeaders[index].width;

      document.addEventListener("mousemove", this.doResize);
      document.addEventListener("mouseup", this.stopResize);
    },
    calculateContent(index) {
      const miDiv = document.getElementById(`${this.tableName}-column-${index}`);
      return miDiv ? miDiv.scrollWidth : 80;
    },
    doResize(event) {
      if (this.isResizing) {
        const diff = event.pageX - this.startX;
        let min = 40;
        const currentWidth = Math.max(min, this.startWidth + diff);
        const contentWidth = this.calculateContent(this.resizingColumnIndex);
        if ((contentWidth - currentWidth) <= 80) {
          this.visibleHeaders[this.resizingColumnIndex].width = currentWidth;
        }
      }
    },
    stopResize() {
      if (this.isResizing) {
        document.removeEventListener("mousemove", this.doResize);
        document.removeEventListener("mouseup", this.stopResize);
        this.isResizing = false;
        this.resizingColumnIndex = -1;
      }
    },
    handleRowClick(row, event) {
      this.$emit("table-row-click", row, event);
    },
    handleRowMouseleave() {
      this.$emit("table-row-mouseleave", false);
    },
    sanitizeTooltip(html) {
      let cleanHtml = html.replace(/<script(.*?)>[\s\S]*?<\/script>/gi, "");
      cleanHtml = cleanHtml.replace(/<style(.*?)>[\s\S]*?<\/style>/gi, "");
      cleanHtml = cleanHtml.replace(/<(?!img|input|meta|time|button|select|textarea|datalist|progress|meter)[^>]*>/gi, "");
      cleanHtml = cleanHtml.replace(/\s+/g, " ");

      return cleanHtml;
    },
    isUnread(row, unreadColumnName) {
      return row[unreadColumnName] === null;
    },
  },
};
</script>

<style>
.pm-table-container {
  overflow-x: auto;
  overflow-y: auto;
  border-left: 1px solid rgba(0, 0, 0, 0.125);
  border-right: 1px solid rgba(0, 0, 0, 0.125);
  border-bottom: 1px solid rgba(0, 0, 0, 0.125);
  border-radius: 5px;
  scrollbar-width: 8px;
  scrollbar-color: #6C757D;
  max-height: calc(100vh - 150px);
}

.pm-table-container th {
  position: relative;
  max-width: 800px;
}

.pm-table-column-header {
  overflow: hidden;
  white-space: nowrap;
}

.pm-table-column-resizer {
  position: absolute;
  right: 0px;
  top: 50%;
  transform: translateY(-50%);
  height: 85%;
  width: 10px;
  cursor: col-resize;
  border-right: 1px solid rgba(0, 0, 0, 0.125);
}
.pm-table-filter {
  width: 100%;
  max-height: 400px;
  border-collapse: collapse;
  position: relative;
  color: #566877;
}
.pm-table-filter td {
  border-bottom: 1px solid rgba(0, 0, 0, 0.125);
  padding: 10px 16px;
  height: 56px;
}
.pm-table-ellipsis-column {
  padding: 10px 16px;
  height: 56px;
}
.pm-table-filter th:hover {
  background-color: #FAFBFC;
  color: #1572C2;
}
.pm-table-filter tbody tr:hover {
  background-color: #FAFBFC;
  color: #1572C2;
}
.pm-table-filter thead {
  position: sticky;
  top: 0;
  background-color: #fff;
}
.pm-table-filter .sortable-column:hover::after {
  content: '\2026';
  position: absolute;
  top: 50%;
  right: 7px;
  transform: translateY(-50%) rotate(90deg);
  font-size: 16px;
  line-height: 1;
  cursor: pointer;
}
.pm-table-border {
  height: 1px;
  padding: 0 !important;
  background-color: rgba(0, 0, 0, 0.125);
  border: 0 !important;
}
.pm-table-filter-button {
  position: absolute;
  top: 20%;
  right: 7px;
}
.pm-table-ellipsis-column .pm-table-filter-button {
  opacity: 0;
  visibility: hidden;
}
.pm-table-ellipsis-column:hover .pm-table-filter-button {
  opacity: 1;
  visibility: visible;
}
.pm-table-truncate {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.pm-table-tooltip {
  opacity: 1 !important;
}
.pm-table-tooltip .tooltip-inner {
  background-color: #F2F8FE;
  color: #6A7888;
  box-shadow: -5px 5px 5px rgba(0, 0, 0, 0.3);
  max-width: 250px;
  padding: 14px;
  border-radius: 7px;
}
.pm-table-tooltip .arrow::before {
  border-bottom-color: #F2F8FE !important;
  border-top-color: #F2F8FE !important;
}
.pm-table-tooltip-header {
  opacity: 1 !important;
}
.pm-table-tooltip-header .tooltip-inner {
  background-color: #deebff;
  color: #104a75;
  box-shadow: -5px 5px 5px rgba(0, 0, 0, 0.3);
  max-width: 250px;
  padding: 14px;
  border-radius: 7px;
}
.pm-table-tooltip-header .arrow::before {
  border-bottom-color: #deebff !important;
  border-top-color: #deebff !important;
}
.pm-table-filter-applied {
  color: #1572C2;
  background-color: #F2F8FE !important;
}
.pm-table-unread-row {
  font-weight: bold;
}
.status-success {
  background-color: rgba(78, 160, 117, 0.2);
  color: rgba(78, 160, 117, 1);
  width: 100px;
  border-radius: 5px;
}
.status-danger {
  background-color:rgba(237, 72, 88, 0.2);
  color: rgba(237, 72, 88, 1);
  width: 100px;
  border-radius: 5px;
}
.status-primary {
  background: rgba(21, 114, 194, 0.2);
  color: rgba(21, 114, 194, 1);
  width: 100px;
  border-radius: 5px;
}
@-moz-document url-prefix() {
  .pm-table-truncate {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }
}
.pm-table-container::-webkit-scrollbar {
  width: 8px;
  height: 8px;
}
.pm-table-container::-webkit-scrollbar-thumb {
  background-color: #6C757D;
  border-radius: 20px;
}
.ellipsis-dropdown-main ul.dropdown-menu.dropdown-menu-right.show {
  max-height: 250px;
  overflow-y: auto;
}
.pm-table-selected-row {
  background-color: #E8F0F9;
  color: #1572C2;
}
</style>
