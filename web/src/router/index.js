import {
    createRouter,
    createWebHistory
} from "vue-router"
import {
    useStore
} from "vuex";
import Body from '../components/body';
import Default from '../pages/dashboard/defaultPage.vue';
/* Auth */
import Login from '../pages/auth/login';
import RegisterWorker from '../pages/auth/register_worker';
import RegisterClient from '../pages/auth/register_client';
import AdminDashboard from '../pages/dashboard/admin';
import ClientDashboard from '../pages/dashboard/client';
import WorkerDashboard from '../pages/dashboard/worker';
import AdminConfiguration from '@/pages/admin/configuration';
import MyActivity from "@/pages/myActivity.vue";
import AdminRoles from "@/pages/admin/roles";
import AdminPriority from "@/pages/admin/priority";
import AdminStatus from "@/pages/admin/status";
import AdminTypes from "@/pages/admin/types";
import AllActivities from "@/pages/admin/activities";
import AdminUsers from "@/pages/admin/users";

const routes = [
    /* Auth */
    {
        path: '/',
        component: Login,
        name: 'login',
        meta: {
            title: ' Login ',
        },
    },
    {
        path: '/register/health-care-worker',
        name: 'register',
        component: RegisterWorker,
        meta: {
            title: ' Register ',
        }
    },

    // register for client
    {
        path: '/register/client',
        name: 'registerClient',
        component: RegisterClient,
        meta: {
            title: ' Register ',
        }
    },


    /* Admin */
    {
        path: '/admin',
        component: Body,
        meta: {
            auth: true,
        },
        children: [
            // admin dashboard
            {
                path: 'dashboard',
                name: 'adminDashboard',
                component: AdminDashboard,
            },

            // configuration
            {
                path: 'configuration',
                name: 'adminConfiguration',
                component: AdminConfiguration,
            },

            // roles
            {
                path: 'roles',
                name: 'adminRoles',
                component: AdminRoles,
            },

            // priority
            {
                path: 'priority',
                name: 'adminPriority',
                component: AdminPriority,
            },

            // status
            {
                path: 'status',
                name: 'adminStatus',
                component: AdminStatus,
            },

            // types
            {
                path: 'incident-types',
                name: 'adminTypes',
                component: AdminTypes,
            },

            // users
            {
                path: 'users',
                name: 'adminUsers',
                component: AdminUsers,
            },

            // activities
            {
                path: 'activities',
                name: 'allActivities',
                component: AllActivities,
            },
        ]
    },

    /* Client */
    {
        path: '/client',
        component: Body,
        meta: {
            auth: true,
        },
        children: [
            // 
            {
                path: 'dashboard',
                name: 'clientDashboard',
                component: ClientDashboard,
            },
        ]
    },

    /* Worker */
    {
        path: '/worker',
        component: Body,
        meta: {
            auth: true,
        },
        children: [{
                path: 'dashboard',
                name: 'workerDashboard',
                component: WorkerDashboard,
            },

        ]
    },

    {
        path: '/default',
        component: Body,
        children: [{
                path: '',
                name: 'defaultRoot',
                component: Default,
            },

        ]
    },

    {
        path: '/my-activities',
        component: Body,
        meta: {
            auth: true,
        },
        children: [{
                path: '',
                name: 'myActivity',
                component: MyActivity,
                title: ' My Activity ',
            },

        ]
    },


]

const router = createRouter({
    history: createWebHistory(),
    routes,
})
router.beforeEach((to, from, next) => {
    const store = useStore();
    if (to.meta.title) {
        document.title = to.meta.title + ' | Home Care Agency';
    }

    const path = ['/', '/register/client', '/register/health-care-worker'];
    // console.log(to.meta)
    // console.log(store.state.auth.user)
    // console.log(store.getters?.getUser)
    // console.log(store.getters.getUser)

    if (store.state.auth.user || path.includes(to.path)) {
        return next();
    }
    next('/');
});
export default router
//   if (path.includes(to.path) || localStorage.getItem('User')) {
//     return next();
//   }