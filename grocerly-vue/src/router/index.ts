import { useCookies } from 'vue3-cookies'
import { createRouter, createWebHistory } from 'vue-router'
import Register from '../views/Register.vue'
import Dashboard from '../views/Dashboard.vue'

const { cookies } = useCookies()

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      redirect: '/dashboard',
      name: 'Root',
    },
    {
      path: '/dashboard',
      component: Dashboard,
      name: 'Dashboard',
      meta: {
        title: 'Grocerly - Manage your recipes and your groceries',
        requiresAuth: true,
      },
    },
    {
      path: '/register',
      component: Register,
      name: 'Register',
      meta: {
        title: 'Grocerly - Register your user',
        requiresGuest: true,
      },
    },
  ],
})

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token')
  const requiresAuth = to.meta.requiresAuth
  const requiresGuest = to.meta.requiresGuest
  document.title = (to.meta.title as string) || 'Grocerly'
  if (requiresAuth && (!token || token.length <= 0)) {
    return next({ name: 'Register' })
  }
  if (requiresGuest && token) {
    return next({ name: 'Dashboard' })
  }
  next()
})

export default router
