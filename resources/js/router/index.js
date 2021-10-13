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
            path: 'role',
            name: 'role',
            component: require('@/pages/roles/Role').default,

        },
        {
            path: 'showRole',
            name: 'showRole',
            component: require('@/pages/roles/showRole').default,
            meta: {
                requirIsSetData: true
            },
        },
        {
            path: 'adminsList',
            name: 'adminsList',
            component: require('@/pages/admins/admins_list').default,

        },

        {
            path: 'addAdmin',
            name: 'addAdmin',
            component: require('@/pages/admins/addAdmin').default,

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
    if (to.matched.some(record => record.meta.requirIsSetData)) {

        if (store.getters.roleDataToShow) {
            next();

        } else {
            next({ name: "permissions" });
        }

    }




    next();

});




export default router
