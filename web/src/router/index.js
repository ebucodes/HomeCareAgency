import {
  createRouter,
  createWebHistory
} from "vue-router"
import { useStore } from "vuex";
import Body from '../components/body';
import Default from '../pages/dashboard/defaultPage.vue';
/* Auth */
import Login from '../pages/auth/login';
import Register from '../pages/auth/register';
import AdminDashboard from '../pages/dashboard/admin';
import ClientDashboard from '../pages/dashboard/client';
import WorkerDashboard from '../pages/dashboard/worker';
import AdminConfiguration from '../pages/admin/configuration';


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
    path: '/register',
    name: 'register',
    component: Register,
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
        children: [{
            path: 'dashboard',
            name: 'adminDashboard',
            component: AdminDashboard,
        },
        {
            path: 'configuration',
            name: 'adminConfiguration',
            component: AdminConfiguration,
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
        children: [{
            path: 'dashboard',
            name: 'clientDashboard',
            component: ClientDashboard,
        },
        {
            path: 'configuration',
            name: 'adminConfiguration',
            component: AdminConfiguration,
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
        {
            path: 'configuration',
            name: 'adminConfiguration',
            component: AdminConfiguration,
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

    const path = ['/', '/register'];
    console.log(to.meta)
    // console.log(store.state.auth.user)
    // console.log(store.getters?.getUser)
    // console.log(store.getters.getUser)

    if (store.state.auth.user) {
    return next();
  }
  next('/');
});
export default router