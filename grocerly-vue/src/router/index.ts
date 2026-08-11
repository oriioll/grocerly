import { useCookies } from 'vue3-cookies'
const { cookies } = useCookies()

import Register from '@/views/Register.vue'
import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      redirect: '/home',
      name: 'Root',
    },
    {
      path: '/home',
      component: Register,
      name: 'Home',
      meta: {
        title: 'Grocerly - Manage your recipes and your groceries',
      },
    },
    {
      path: '/register',
      component: Register,
      name: 'Register',
      meta: {
        title: 'Grocerly - Register your user',
      },
    },
  ],
})

router.beforeEach((to, from, next) => {
  const onlyNoToken = ['Register']
  const onlyWithToken = ['Home', '/']
  document.title = (to.meta.title as string) || 'Grocerly'
  if (!cookies.isKey('token') && onlyWithToken.includes(to.name as string)) {
    return next({ name: 'Register' })
  }
  if (cookies.isKey('token') && onlyNoToken.includes(to.name as string)) {
    return next({ name: 'Home' })
  }
  next()
})
export default router
