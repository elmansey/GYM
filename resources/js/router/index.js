import Vue from 'vue'
import Router from "vue-router";
import {
    store
} from '../store'


// component

Vue.use(Router)

const routes = [{
        path: '',
        redirect: {
            name: 'login'
        }
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: require('@/components/body').default,
        meta: {
            requiresAuth: true
        },
        children: [

            {
                path: '/',
                name: 'main',
                component: require('@/pages/home/home').default,

            },
            {

                path: 'membersList',
                name: 'membersList',
                component: require('@/pages/members/membersList').default,

            },
            {

                path: 'addMember',
                name: 'addMember',
                component: require('@/pages/members/add_new_member').default,

            },
            {

                path: 'updateMember',
                name: 'updateMember',
                component: require('@/pages/members/add_new_member').default,

            },

            {
                path: 'addMembership',
                name: 'addMembership',
                component: require('@/pages/memberships/Membership').default,

            },

            {
                path: 'updateMembership/:membershipId',
                name: 'updateMembership',
                component: require('@/pages/memberships/Membership').default,

            },
            {
                path: 'memberships',
                name: 'memberships',
                component: require('@/pages/memberships/memberships').default,

            },

            {
                path: 'groups',
                name: 'groups',
                component: require('@/pages/groups/groups_list').default,

            },
            {
                path: 'addGroup',
                name: 'addGroup',
                component: require('@/pages/groups/add_group').default,

            },

            {
                path: 'updateGroup/:groupId',
                name: 'updateGroup',
                component: require('@/pages/groups/add_group').default,

            },


            {
                path: 'staff',
                name: 'staff',
                component: require('@/pages/staff/staffList').default,

            },
            {
                path: 'updateInStaff/:staffId',
                name: 'updateInStaff',
                component: require('@/pages/staff/add_person_in_staff').default,

            },
            {
                path: 'addInStaff',
                name: 'addInStaff',
                component: require('@/pages/staff/add_person_in_staff').default,

            },





            {
                path: 'classList',
                name: 'classList',
                component: require('@/pages/classSchedule/classList').default,

            },
            {
                path: 'classSchedule',
                name: 'classSchedule',
                component: require('@/pages/classSchedule/classSchedule').default,

            },
            {
                path: 'updateClassSchedule/:classScheduleId',
                name: 'updateClassSchedule',
                component: require('@/pages/classSchedule/classScheduleAddEDIT').default,

            },
            {
                path: 'addClassSchedule',
                name: 'addClassSchedule',
                component: require('@/pages/classSchedule/classScheduleAddEDIT').default,

            },






            {
                path: 'error_403',
                name: 'error_403',
                component: require('@/pages/errors/error_403').default,

            },
            {
                path: 'permissions',
                name: 'permissions',
                component: require('@/pages/roles/permissions').default,
                meta: {

                    permission: 'show-roles-list'

                },


            },

            {
                path: 'addRole',
                name: 'addRole',
                component: require('@/pages/roles/Role').default,


            },
            {
                path: 'editRole/:roleId',
                name: 'editRole',
                component: require('@/pages/roles/Role').default,


            },
            {
                path: 'showRole',
                name: 'showRole',
                component: require('@/pages/roles/showRole').default,
                meta: {
                    requirIsSetData: true,
                    permission: 'show-team-member-list'

                },
            },
            {
                path: 'adminsList',
                name: 'adminsList',
                component: require('@/pages/admins/admins_list').default,
                meta: {
                    permission: 'show-team-member-list'
                }

            },

            {
                path: 'addAdmin',
                name: 'addAdmin',
                component: require('@/pages/admins/addAdmin').default,
                meta: {
                    permission: 'add-member-in-team'
                }

            },
            {
                path: 'updateAdmin/:adminId',
                name: 'updateAdmin',
                component: require('@/pages/admins/addAdmin').default,
                meta: {
                    permission: 'add-member-in-team'
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
        path: '/login',
        name: 'login',
        component: require('@/pages/login').default
    }


];



const router = new Router({
    routes,
    base: '/',
    mode: 'history',
    linkActiveClass: "active",
    scrollBehavior() {
        return {
            x: 0,
            y: 0
        }
    }
});


router.beforeEach(async(to, from, next) => {

    if (!store.getters.authentication && store.getters.AUTH_TOKEN) {

        await store.dispatch("userInfo");


    }

    if (to.matched.some(record => record.meta.requiresAuth)) {

        if (store.getters.authentication) {
            next();

        } else {
            next({
                name: "login"
            });
        }

    }

    // should to through to show permition related this role should going through button
    if (to.matched.some(record => record.meta.requirIsSetData)) {

        if (store.getters.roleDataToShow) {
            next();

        } else {
            next({
                name: "permissions"
            });
        }

    }


    let FinalPer;

    function checker(permi) {

        var perm = store.getters.authUserRole
        var len = perm.length
        FinalPer = []


        for (var i = 0; i < len; i++) {

            store.getters.authUserRole[i].permission.forEach((element, index) => {

                FinalPer.push(element['name'])

            })

        }


        var res = FinalPer.includes(permi) ? true : false

        if (res) {
            return true
        } else {
            return false
        }

    }



    if (to.matched.some(record => record.meta.permission)) {

        let {
            meta: {
                permission
            }
        } = to.matched.find(record => record.meta.permission);


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