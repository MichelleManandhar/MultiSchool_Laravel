import("./bootstrap");
import Vue from "vue";
import "vue-material/dist/theme/default.css";
import VueAuth from "@websanova/vue-auth";
import Routes from "@/js/routes.js"; 
import App from "@/js/views/App"; 
import auth from "./auth";
import VueAxios from "vue-axios";
import "es6-promise/auto";
import axios from "axios";
import VModal from "vue-js-modal";
import VueRouter from "vue-router";
import VueNoty from "vuejs-noty";
import VueLocalStorage from 'vue-localstorage';
import VueSession from 'vue-session';
import BootstrapVue from "bootstrap-vue";
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";
import router from "./routes";

Vue.router = router;
Vue.use(VueRouter);
Vue.use(VueAxios, axios);
Vue.use(VueAuth, auth);
Vue.use(VModal);
Vue.use(VueSession);
Vue.use(VueLocalStorage);
Vue.use(VueNoty, { timeout: 3000, progressBar: true, layout: "topRight" });
Vue.use(BootstrapVue);

axios.defaults.baseURL = `/api`;
window.eventBus = new Vue();

const app = new Vue({
    el: "#app",
    router: Routes,
    render: h => h(App)
});
export default app;
