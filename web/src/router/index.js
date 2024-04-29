import {
  createRouter,
  createWebHistory
} from "vue-router"
import Body from '../components/body';
import Default from '../pages/dashboard/defaultPage.vue';
/* Auth */
import Login from '../pages/auth/login';
import Register from '../pages/auth/register';
import AdminDashboard from '../pages/dashboard/admin';
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
  if (to.meta.title)
    document.title = to.meta.title + ' | Home Care Agency';
  const path = ['/auth/login', '/auth/register'];
  if (path.includes(to.path) || localStorage.getItem('User')) {
    return next();
  }
  next('/auth/login');
});
export default router