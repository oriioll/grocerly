import { createRouter, createWebHistory } from 'vue-router'
import Register from '../views/Register.vue'
import Dashboard from '../views/Dashboard.vue'
import { UserService } from '@/services/UserService.ts'
let isAppLoaded: boolean = false
const userService: UserService = new UserService()
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
      path: '/recipes',
      component: Dashboard,
      name: 'Recipes',
      meta: {
        title: 'Recipes - Manage your recipes and create new ones',
        requiresAuth: true,
      },
    },
    {
      path: '/recipes/:recipeId',
      component: Dashboard,
      name: 'Recipes',
      meta: {
        title: 'Recipes - Manage your recipes and create new ones',
        requiresAuth: true,
      },
    },
    {
      path: '/shopping-lists',
      component: Dashboard,
      name: 'Recipes',
      meta: {
        title: 'Shopping lists - Manage your lists and create new ones',
        requiresAuth: true,
      },
    },
    {
      path: '/shopping-lists/:listId',
      component: Dashboard,
      name: 'Recipes',
      meta: {
        title: 'Recipes - Manage your lists and create new ones',
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

router.beforeEach(async (to, from, next) => {
  const token = localStorage.getItem('token')
  const requiresAuth = to.meta.requiresAuth
  const requiresGuest = to.meta.requiresGuest
  document.title = (to.meta.title as string) || 'Grocerly'
  //Verify pages where user is going and check if he has token or not
  if (requiresAuth && (!token || token.length <= 0)) {
    return next({ name: 'Register' })
  }
  if (requiresGuest && token) {
    return next({ name: 'Dashboard' })
  }

  //Cache the user each time the app is recharched or opened
  if (token && !isAppLoaded) {
    try {
      const user = await userService.getMe()
      // Re-cache user data: only update token if the API returned one
      if (user.name) localStorage.setItem('name', user.name)
      if (user.token) localStorage.setItem('token', user.token)
    } catch (e: any) {
      // On error, remove token and name but avoid clearing unrelated storage
      console.log(e)
      localStorage.removeItem('token')
      localStorage.removeItem('name')
      return next({ name: 'Register' })
    } finally {
      isAppLoaded = true
    }
  }
  next()
})

export default router
