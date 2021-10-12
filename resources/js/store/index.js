import Vue from "vue";
import Vuex from "vuex";
import router from '../router'
// import 'es6-promise/auto';
import layout from './modules/layout'
import menu from './modules/menu'
import auth from './modules/auth'

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
    },
    mutations: {
    },
    actions: {
    },

    modules: {
      layout,
      menu,
        auth,

    }
});

