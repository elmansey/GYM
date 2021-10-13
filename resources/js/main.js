import Vue from 'vue'
import App from './App.vue'
import BootstrapVue from 'bootstrap-vue'
import VueFeather from 'vue-feather';
import router from './router'
import { store } from './store';
import Breadcrumbs from './components/bread_crumbs'
import SmartTable from "vuejs-smart-table";
import { FormGroupPlugin } from 'bootstrap-vue'
Vue.component('pulse-loader', require('vue-spinner/src/PulseLoader.vue'));

import './axios'

// import PxCard  from './components/Pxcard.vue'
// Vue.component(PxCard.name, PxCard)


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

new Vue({
  router,
  store,
  render: h => h(App)


}).$mount('#app')

