<template>
  <div class="process-info-main">
    <process-collapse-info
      :process="process"
      :permission="permission"
      :current-user-id="currentUserId"
      :is-documenter-installed="isDocumenterInstalled"
      @goBackCategory="goBackCategory"
    />
    <process-tab
      :current-user="currentUser"
      :process="process"
    />
  </div>
</template>

<script>
import ProcessCollapseInfo from "./ProcessCollapseInfo.vue";
import ProcessTab from "./ProcessTab.vue";

export default {
  components: {
    ProcessCollapseInfo,
    ProcessTab,
  },
  props: ["process", "permission", "isDocumenterInstalled", "currentUserId", "currentUser"],
  data() {
    return {
      listCategories: [],
      selectCategory: 0,
      dataOptions: {},
    };
  },
  mounted() {
    this.dataOptions = {
      id: this.process.id.toString(),
      type: "Process",
    };
  },
  methods: {
    /**
     * Return a process cards
     */
    goBackCategory() {
      this.$emit("goBackCategory");
    },
  },
};
</script>

<style lang="css" scoped>
.process-info-main {
  overflow-y: auto;
}
</style>
