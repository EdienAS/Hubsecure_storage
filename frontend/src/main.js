import "@babel/polyfill";
import "mutationobserver-shim";
import Raphael from "raphael/raphael";
global.Raphael = Raphael;
import Vue from "vue";
import "./plugins";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import "./directives";
import "./mixins/baseUrl";
import Axios from "axios";

import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";

Vue.use(VueSweetalert2);

Axios.defaults.baseURL = process.env.VUE_APP_BACKEND_URL;

import vClickOutside from "v-click-outside";

Vue.use(vClickOutside);

Vue.config.productionTip = false;

new Vue({
  router,
  store,
  render: (h) => h(App),
}).$mount("#app");
