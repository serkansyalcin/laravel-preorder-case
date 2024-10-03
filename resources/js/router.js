import { createRouter, createWebHistory } from "vue-router"
import UserLayout from "./layouts/User/Index.vue"
import AdminLayout from "./layouts/Admin/Index.vue"
import useUser from "./store/user"

const routes = [
  {
    path: '/',
    component: UserLayout,
    children: [
      {
        path: '',
        component: () => import(/* webpackChunkName: "home" */ './pages/user/Home.vue')
      }
    ]
  },
  {
    path: '/admin',
    children: [
      {
        path: '',
        component: AdminLayout,
        children: [
          {
            path: '',
            name: "AdminDashboard",
            component: () => import(/* webpackChunkName: "admin-home" */ './pages/admin/Home.vue')
          }
        ]
      },
      {
        path: 'login',
        name: 'AdminLogin',
        component: () => import(/* webpackChunkName: "admin-login" */ './pages/admin/Login.vue')
      }
    ]
  },
  {
    path: '/:pathMatch(.*)*',
    component: () => import(/* webpackChunkName: "404" */ './pages/404.vue')
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach((to, from, next) => {
  const user = useUser()
  const userData = user.user;
  const token = user.token;
  const isAdminRequest = to.path.includes('/admin');
  if (isAdminRequest) {
    const isAdminLoginPage = to.path === '/admin/login'
    if (isAdminLoginPage) {
      if (token && userData && userData.is_admin) {
        return next({ path: '/admin' })
      } else {
        return next()
      }
    }

    if (userData && !userData.is_admin) {
      return next({ path: '/' })
    }

    if (!token || !userData) {
      return next({ path: '/admin/login' });
    }

    return next()
  } else {
    return next()
  }
})

export default router;
