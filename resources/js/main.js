import Vue from 'vue'
import App from './App.vue'
import BootstrapVue from 'bootstrap-vue'
import VueFeather from 'vue-feather';
import router from './router'
import {
    store
} from './store';

import './bootstrap' // pusher and laravel echo

import Breadcrumbs from './components/bread_crumbs'
import SmartTable from "vuejs-smart-table";
import {
    FormGroupPlugin
} from 'bootstrap-vue'
Vue.component('pulse-loader', require('vue-spinner/src/PulseLoader.vue'));

import vue2Dropzone from 'vue2-dropzone'
import VueFormWizared from 'vue-form-wizard'

import Vuelidate from 'vuelidate'

import './axios'

import PxCard from './components/Pxcard.vue'
Vue.component(PxCard.name, PxCard)


import VueApexCharts from 'vue-apexcharts';
import FunctionalCalendar from 'vue-functional-calendar';

Vue.use(require('vue-chartist'))

Vue.component('apexchart', VueApexCharts)


Vue.use(FunctionalCalendar, {
    dayNames: ['M', 'T', 'W', 'T', 'F', 'S', 'S']
});




// Import Theme scss
import './assets/scss/app.scss'


import Swal from 'sweetalert2';
window.Swal = Swal


const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});
window.Toast = Toast








Vue.use(VueFeather);
Vue.use(BootstrapVue)
Vue.component('Breadcrumbs', Breadcrumbs)
Vue.use(SmartTable);
Vue.use(FormGroupPlugin)
Vue.use(vue2Dropzone)
Vue.use(VueFormWizared)
Vue.use(Vuelidate)

// global mixin
Vue.mixin({
    methods: {

        // can:(permission) => store.getters.authUserRole[].includes(permission) ? true : false,
        can: function(permission) {
            var perm = store.getters.authUserRole
            if (perm != null) {

                var len = perm.length

            }
            let FinalPer = []


            for (var i = 0; i < len; i++) {

                store.getters.authUserRole[i].permission.forEach((element, index) => {

                    FinalPer.push(element['name'])

                })

            }

            let FinalPerLen = FinalPer.length
            for (var t = 0; t < FinalPerLen; t++) {

                if (FinalPer[t] == permission) {
                    return true
                }

            }


            return false

        }

    }
})




new Vue({
    router,
    store,
    render: h => h(App)


}).$mount('#app')
