import Vue from "vue";
import MonacoEditor from "vue-monaco";
import debounce from "lodash/debounce";
import { VueFormRenderer } from "@processmaker/screen-builder";
import DataSummary from "./components/DataSummary.vue";
import RequestDetail from "./components/RequestDetail.vue";
import AvatarImage from "../components/AvatarImage.vue";
import RequestErrors from "./components/RequestErrors.vue";
import Timeline from "../components/Timeline.vue";
import TimelineItem from "../components/TimelineItem.vue";
import RequestScreens from "./components/RequestScreens.vue";

Vue.component("DataSummary", DataSummary);
Vue.component("RequestDetail", RequestDetail);
Vue.component("AvatarImage", AvatarImage);
Vue.component("RequestErrors", RequestErrors);
Vue.component("MonacoEditor", MonacoEditor);
Vue.component("Timeline", Timeline);
Vue.component("TimelineItem", TimelineItem);
Vue.component("RequestScreens", RequestScreens);

Vue.use("vue-form-renderer", VueFormRenderer);
window.debounce = debounce;
