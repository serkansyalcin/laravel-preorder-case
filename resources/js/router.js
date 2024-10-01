import { createRouter, createWebHistory } from "vue-router"
import UserLayout from "./layouts/User/Index.vue"
import AdminLayout from "./layouts/Admin/Index.vue"

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
    component: AdminLayout,
    children: [
      {
        path: '',
        component: () => import(/* webpackChunkName: "home" */ './pages/admin/Home.vue')
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

export default router;
