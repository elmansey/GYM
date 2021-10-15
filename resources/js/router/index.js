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
            path: '',
            name: 'main',
            component: require('@/pages/home/home').default,

        },
        {
            path: 'error_403',
            name: 'error_403',
            component: require('@/pages/errors/error_403').default,

        },
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
            meta:{
                permission:'add-member-in-team'
            }

        },

        {
            path: 'products',
            name: 'products',
            component: require('@/pages/products/products').default,

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

    // should to through to show permition related this role should going through button
    if (to.matched.some(record => record.meta.requirIsSetData)) {

        if (store.getters.roleDataToShow) {
            next();

        } else {
            next({ name: "permissions" });
        }

    }


    let FinalPer;
    function checker(permi){

        var  perm = store.getters.authUserRole
        var len  = perm.length
         FinalPer = []


        for(var i = 0 ; i < len ; i++){

            store.getters.authUserRole[i].permission.forEach((element,index) => {

                FinalPer.push(element['name'])

            })

        }


        var res = FinalPer.includes(permi)  ? true : false

        if(res){
            return true
        }else{
            return false
        }

    }



    if (to.matched.some(record => record.meta.permission)) {

        let {meta: { permission }} = to.matched.find(record => record.meta.permission);


        if (checker(permission)) {

            next();

        } else {


            // router.back()
            window.history.back()
            next(false)

            // next({ name: "error_403" });

        }
    }


    next();

});




export default router
