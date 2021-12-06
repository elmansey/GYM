import Vue from "vue";
import Vuex from "vuex";
import router from "../router";
// import 'es6-promise/auto';

import layout from "./modules/layout";
import menu from "./modules/menu";
import auth from "./modules/auth";
import role from "./modules/role";
import admin from "./modules/admin";
import setting from "./modules/setting";
import notification from "./modules/notification";
import app from "../main";
Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {},
    mutations: {
        changeLang(state, payload) {
            localStorage.setItem("currentLanguage", payload.id);
            localStorage.setItem("currentLanguageIcon", payload.icon);
            window.location.reload();
        }
    },
    actions: {
        setLang({ commit }, payload) {
            commit("changeLang", payload);
        }
    },

    modules: {
        layout,
        menu,
        auth,
        role,
        admin,
        setting,
        notification,
        namespaced: true
    }
});
