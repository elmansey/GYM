import "./bootstrap";
import Vue from "vue";

import App from "./App.vue";
import BootstrapVue from "bootstrap-vue";
import VueFeather from "vue-feather";
import router from "./router";
import { store } from "./store";

import "vue-select/dist/vue-select.css";
import vSelect from "vue-select";
Vue.component("v-select", vSelect);

import excel from "vue-excel-export";

Vue.use(excel);

//firebase confegration
import firebase from "firebase/app";
import "firebase/database";

const firebaseConfig = {
    apiKey: "AIzaSyBaIQZblT9_y0jzKbWhqfVLDZs1mFZqrHU",
    authDomain: "gymnotification-9bd6f.firebaseapp.com",
    databaseURL: "https://gymnotification-9bd6f-default-rtdb.firebaseio.com",
    projectId: "gymnotification-9bd6f",
    storageBucket: "gymnotification-9bd6f.appspot.com",
    messagingSenderId: "795536904948",
    appId: "1:795536904948:web:d2b8998605acb5d131c4a1",
    measurementId: "G-D7Q7DJ566V"
};

Vue.config.productionTip = false;
firebase.initializeApp(firebaseConfig);

window.firebase = firebase;

//firebase confegration

import Notifications from "vue-notification";
import velocity from "velocity-animate";

Vue.use(Notifications);
Vue.use(Notifications, { velocity });

import VueI18n from "vue-i18n";
// Multi Language Add
import en from "./locales/en.json";
import ar from "./locales/ar.json";
import { defaultLocale, localeOptions } from "./constants/config";
Vue.use(VueI18n);

const messages = { en: en, ar: ar };
const locale =
    localStorage.getItem("currentLanguage") &&
    localeOptions.filter(x => x.id === localStorage.getItem("currentLanguage"))
        .length > 0
        ? localStorage.getItem("currentLanguage")
        : defaultLocale;
const i18n = new VueI18n({
    locale: locale,
    fallbackLocale: "en",
    messages
});

import print from "print-js";

import Breadcrumbs from "./components/bread_crumbs";
import SmartTable from "vuejs-smart-table";
import { FormGroupPlugin } from "bootstrap-vue";
Vue.component("pulse-loader", require("vue-spinner/src/PulseLoader.vue"));

import vue2Dropzone from "vue2-dropzone";
import VueFormWizared from "vue-form-wizard";

import Vuelidate from "vuelidate";

import "./axios";

import PxCard from "./components/Pxcard.vue";
Vue.component(PxCard.name, PxCard);

import VueApexCharts from "vue-apexcharts";
import FunctionalCalendar from "vue-functional-calendar";

Vue.use(require("vue-chartist"));

Vue.component("apexchart", VueApexCharts);

Vue.use(FunctionalCalendar, {
    dayNames: ["M", "T", "W", "T", "F", "S", "S"]
});

// Import Theme scss
import "./assets/scss/app.scss";

import Swal from "sweetalert2";
window.Swal = Swal;

const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: toast => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
    }
});
window.Toast = Toast;

Vue.use(VueFeather);
Vue.use(BootstrapVue);
Vue.component("Breadcrumbs", Breadcrumbs);
Vue.use(SmartTable);
Vue.use(FormGroupPlugin);
Vue.use(vue2Dropzone);
Vue.use(VueFormWizared);
Vue.use(Vuelidate);

// global mixin
Vue.mixin({
    methods: {
        // can:(permission) => store.getters.authUserRole[].includes(permission) ? true : false,
        can: function(permission) {
            var perm = store.getters.authUserRole;

            if (perm != null) {
                var len = perm.length;
            }

            let FinalPer = [];

            for (var i = 0; i < len; i++) {
                store.getters.authUserRole[i].permission.forEach(
                    (element, index) => {
                        FinalPer.push(element["name"]);
                    }
                );
            }

            store.getters.authCustomPermission.map((v, k) => {
                FinalPer.push(v.name);
            });

            let FinalPerLen = FinalPer.length;
            for (var t = 0; t < FinalPerLen; t++) {
                if (FinalPer[t] == permission) {
                    return true;
                }
            }

            return false;
        }
    }
});

export default new Vue({
    router,
    i18n,
    store,
    render: h => h(App)
}).$mount("#app");
