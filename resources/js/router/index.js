import Vue from 'vue'
import Router from "vue-router";
import {store} from '../store'


// component

Vue.use(Router)

const routes = [
  { path: '', redirect: { name: 'login' }},
  {
    path: '/dashboard',
      name: 'dashboard',
    component: require('@/components/body').default,
      meta: {
          requiresAuth: true
      },
    children: [
    {
      path: 'Permissions',
      name: 'permissions',
      component: require('@/pages/roles/permissions').default,

    },

        {
            path: 'addRole',
            name: 'addRole',
            component: require('@/pages/roles/addRole').default,

        },

    ]
  },

  {
      path:'/login',
      name:'login',
      component:require('@/pages/login').default
  }


];



const router = new Router({
  routes,
  base: '/',
  mode: 'history',
  linkActiveClass: "active",
  scrollBehavior () {
    return { x: 0, y: 0 }
  }
});


router.beforeEach(async (to, from, next) => {

    if (!store.getters.authentication   && store.getters.AUTH_TOKEN ) {

        await store.dispatch("userInfo");

    }

    if (to.matched.some(record => record.meta.requiresAuth)) {

        if (store.getters.authentication) {
            next();

        } else {
            next({ name: "login" });
        }

    }

    next();

});




export default router
