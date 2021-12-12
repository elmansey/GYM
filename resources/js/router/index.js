import Vue from 'vue'
import Router from "vue-router";
import {
    store
} from '../store'


// component

Vue.use(Router)

const routes = [

    {
        path: '',
        redirect: {
            name: 'login'
        }
    },


    {
        path: '/login',
        name: 'login',
        component: require('@/pages/authentication/login').default
    },

    // {
    //     path: '/register',
    //     name: 'register',
    //     component: require('@/pages/authentication/register').default
    // },



    {
        path: '/forgotPassword',
        name: 'forgotPassword',
        component: require('@/pages/authentication/forgotPassword').default
    },

    {
        path: '/resetPassword/:email/:token',
        name: 'resetPassword',
        component: require('@/pages/authentication/resetPassword').default
    },





    // required auth
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
                path: 'TeamChat',
                name: 'TeamChat',
                component: require('@/pages/chat/TeamChat').default,
                meta: {

                    permission: 'show-team-chat'

                },


            },

            {

                path: 'profile',
                name: 'profile',
                component: require('@/pages/details/profile').default,


            },

            {

                path: 'membersList',
                name: 'membersList',
                component: require('@/pages/members/membersList').default,
                meta: {

                    permission: 'show-Registration-member-list'

                },

            },
            {

                path: 'freezeMemberAccountList',
                name: 'freezeMemberAccountList',
                component: require('@/pages/members/freezeMemberAccountList').default,
                meta: {

                    permission: 'freezeMemberAccountList'

                },
            },

            {

                path: 'addMember',
                name: 'addMember',
                component: require('@/pages/members/add_new_member').default,
                meta: {

                    permission: 'add-member-in-gym'

                },
            },
            {

                path: 'editMember/:memberId',
                name: 'editMember',
                component: require('@/pages/members/add_new_member').default,

                meta: {

                    permission: 'edit-member-in-gym'

                },

            },

            {

                path: 'showMemberDetails/:memberBaseId',
                name: 'showMemberDetails',
                component: require('@/pages/members/showMemberDetails').default,
                meta: {

                    permission: 'show-member-details'

                },
            },



            {

                path: 'staffList',
                name: 'staffList',
                component: require('@/pages/staff/staffList').default,
                meta: {

                    permission: 'show-staff-list'

                },

            },
            {

                path: 'addPersonInStaff',
                name: 'addPersonInStaff',
                component: require('@/pages/staff/staff_option').default,
                meta: {

                    permission: 'add-person-in-staff'

                },


            },

            {

                path: 'editPersonInStaff/:staffPersonId',
                name: 'editPersonInStaff',
                component: require('@/pages/staff/staff_option').default,
                meta: {

                    permission: 'edit-person-in-staff'

                },
            },








            {

                path: 'product_store',
                name: 'product_store',
                component: require('@/pages/store/product_store').default,
                meta: {

                    permission: 'add-sales-invoices'

                },
            },



            {

                path: 'sales_records',
                name: 'sales_records',
                component: require('@/pages/store/sales_records').default,
                meta: {

                    permission: 'show-sales_invoices'

                },
            },



            {

                path: 'invoiceDetails/:invoiceId',
                name: 'invoiceDetails',
                component: require('@/pages/store/invoiceDetails').default,

            },

            {

                path: 'invoiceArchive',
                name: 'invoiceArchive',
                component: require('@/pages/store/invoiceArchive').default,
                meta: {

                    permission: 'show-Archive'

                },


            },










            {

                path: 'attendance',
                name: 'attendance',
                component: require('@/pages/attendance/attendance').default,
                meta: {

                    permission: 'show-attendance-table'

                },

            },

            {

                path: 'tackAttendance',
                name: 'tackAttendance',
                component: require('@/pages/attendance/take_attendance').default,
                meta: {

                    permission: 'take-attendance'

                },
            },



            {

                path: 'notification/:notificationId?',
                name: 'notification',
                component: require('@/pages/notification/notification').default,

            },

            {

                path: 'history',
                name: 'history',
                component: require('@/pages/history/activity_logs').default,
                meta: {

                    permission: 'show-history'

                },
            },









            {

                path: 'products',
                name: 'products',
                component: require('@/pages/products/products').default,
                meta: {

                    permission: 'show-products'

                },

            },
            {

                path: 'addProduct',
                name: 'addProduct',
                component: require('@/pages/products/addProduct').default,
                meta: {

                    permission: 'add-products-in-store'

                },



            },
            {

                path: 'updateProduct/:productId',
                name: 'updateProduct',
                component: require('@/pages/products/addProduct').default,
                meta: {

                    permission: 'edit-product'

                },



            },












            {
                path: 'addMembership',
                name: 'addMembership',
                component: require('@/pages/memberships/Membership').default,
                meta: {
                    permission: 'add-membership'
                },

            },

            {
                path: 'updateMembership/:membershipId',
                name: 'updateMembership',
                component: require('@/pages/memberships/Membership').default,

                meta: {
                    permission: 'edit-membership'
                },


            },
            {
                path: 'memberships',
                name: 'memberships',
                component: require('@/pages/memberships/memberships').default,
                meta: {
                    permission: 'show-memberships'
                },

            },

            {
                path: 'groups',
                name: 'groups',
                component: require('@/pages/groups/groups_list').default,
                meta: {

                    permission: 'show-groups-list'
                },


            },
            {
                path: 'addGroup',
                name: 'addGroup',
                component: require('@/pages/groups/add_group').default,
                meta: {

                    permission: 'add-group'
                },



            },

            {
                path: 'updateGroup/:groupId',
                name: 'updateGroup',
                component: require('@/pages/groups/add_group').default,
                meta: {

                    permission: 'edit-group'
                },
            },





            {
                path: 'classList',
                name: 'classList',
                component: require('@/pages/classSchedule/classList').default,
                meta: {
                    permission: 'show-class_schedule-list'
                },
            },
            {
                path: 'classSchedule',
                name: 'classSchedule',
                component: require('@/pages/classSchedule/classSchedule').default,
                meta: {
                    permission: 'show-class_schedule'


                },
            },
            {
                path: 'updateClassSchedule/:classScheduleId',
                name: 'updateClassSchedule',
                component: require('@/pages/classSchedule/classScheduleAddEDIT').default,
                meta: {

                    permission: 'edit-class-schedule'
                },
            },
            {
                path: 'addClassSchedule',
                name: 'addClassSchedule',
                component: require('@/pages/classSchedule/classScheduleAddEDIT').default,
                meta: {

                    permission: 'add-class-schedule'
                },
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
                path: 'customPermissions',
                name: 'customPermissions',
                component: require('@/pages/roles/customPermissions').default,
                meta: {
                    permission: 'show-customPermissions'
                },
            },

            {
                path: 'addRole',
                name: 'addRole',
                component: require('@/pages/roles/Role').default,
                meta: {

                    permission: 'add-role'
                },



            },
            {
                path: 'editRole/:roleId',
                name: 'editRole',
                component: require('@/pages/roles/Role').default,
                meta: {

                    permission: 'edit-role'
                },
            },
            {
                path: 'showRole',
                name: 'showRole',
                component: require('@/pages/roles/showRole').default,
                meta: {
                    requirIsSetData: true,
                    permission: 'show-roles-list'
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
                    permission: 'edit-member-from-team'
                }

            },



            {
                path: 'setting',
                name: 'setting',
                component: require('@/pages/setting/setting').default,
                meta: {
                    permission: 'show-setting'
                }
            },



















        ]
    },





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
        if (perm != null) {

            var len = perm.length

        }
        FinalPer = []


        for (var i = 0; i < len; i++) {

            store.getters.authUserRole[i].permission.forEach((element, index) => {

                FinalPer.push(element['name'])

            })

        }

        store.getters.authCustomPermission.map((v, k) => {
            FinalPer.push(v.name)
        })


        var res = FinalPer.includes(permi) ? true : false

        if (res) {
            return true
        } else {
            return false
        }

    }



    if (to.matched.some(record => record.meta.permission)) {

        let { meta: { permission } } = to.matched.find(record => record.meta.permission);


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