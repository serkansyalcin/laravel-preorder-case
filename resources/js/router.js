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
      },
      {
        path: 'product/:productId',
        name: 'ProductDetail',
        component: () => import(/* webpackChunkName: "admin-home" */ './pages/user/product/productDetail.vue'),
        props: true, // Allows passing route params as props
      },
      {
        path: 'orders',
        name: 'ProductDetail',
        component: () => import(/* webpackChunkName: "admin-home" */ './pages/user/orders/orderLists.vue'),
        props: true, // Allows passing route params as props
      },
      {
        path: 'profile',
        name: 'userProfile',
        component: () => import(/* webpackChunkName: "admin-home" */ './pages/user/profile.vue'),
        props: true, // Allows passing route params as props
      }
    ]
  },
  {
    path: '/login',
    name: 'loginUser',
    component: () => import(/* webpackChunkName: "admin-home" */ './pages/user/Login.vue'),
    props: true, // Allows passing route params as props
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
      },
      {
        path: 'products',
        component: AdminLayout,
        children: [
          {
            path: '',
            name: "productLists",
            component: () => import(/* webpackChunkName: "admin-home" */ './pages/admin/products/ProductLists.vue')
          },
          {
            path: 'create',
            name: "ProductCreateForm",
            component: () => import(/* webpackChunkName: "admin-home" */ './pages/admin/products/ProductCreateForm.vue')
          },
          {
            path: 'edit/:productId',
            name: 'ProductEditForm',
            component: () => import(/* webpackChunkName: "admin-home" */ './pages/admin/products/ProductEditForm.vue'),
            props: true, // Allows passing route params as props
          },
        ]
      },
      {
        path: 'orders',
        component: AdminLayout,
        children: [
          {
            path: '',
            name: "orderLists",
            component: () => import(/* webpackChunkName: "admin-home" */ './pages/admin/orders/OrderLists.vue')
          }
        ]
      },
      {
        path: 'users',
        component: AdminLayout,
        children: [
          {
            path: '',
            name: "userLists",
            component: () => import(/* webpackChunkName: "admin-home" */ './pages/admin/users/UserLists.vue')
          }
        ]
      },

      {
        path: 'profile',
        component: AdminLayout,
        children: [
          {
            path: '',
            name: "profilePage",
            component: () => import(/* webpackChunkName: "admin-home" */ './pages/admin/profile/Profile.vue')
          }
        ]
      },
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
