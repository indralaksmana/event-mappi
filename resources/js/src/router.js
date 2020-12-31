/*=========================================================================================
  File Name: router.js
  Description: Routes for vue-router. Lazy loading is enabled.
  Object Strucutre:
                    path => router path
                    name => router name
                    component(lazy loading) => component to load
                    meta : {
                      rule => which user can have access (ACL)
                      breadcrumb => Add breadcrumb to specific page
                      pageTitle => Display title besides breadcrumb
                    }
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


import Vue from 'vue'
import Router from 'vue-router'
import store from './store/store'

Vue.use(Router)

const router = new Router({
  mode: 'history',
  base: process.env.MIX_APP_VUE_PUBLIC_PATH,
  scrollBehavior () {
    return { x: 0, y: 0 }
  },
  routes: [
    {
      path: '/',
      redirect: { name: 'auth-login' }
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: () => import('./views/dashboard/Calendar.vue'),
      meta: {
        no_scroll: true,
        layout: 'with-sidebar',
        authRequired: true
      }
    },
    {
      path: '/event',
      name: 'event',
      component: () => import('@/views/event/List.vue'),
      meta: {
        breadcrumb: [
          { title: 'Dashboard', url: '/' },
          { title: 'Event List', active: true }
        ],
        pageTitle: 'Event List',
        layout: 'with-sidebar',
        authRequired: true
      }
    },
    {
      path: '/auth/login',
      name: 'auth-login',
      component: () => import('@/views/auth/login/Login.vue'),
      meta: {
        layout: 'full-page',
        authRequired: false
      }
    },
    {
      path: '/not-found',
      name: 'page-not-found',
      component: () => import('@/views/Error404.vue'),
      meta: {
        layout: 'full-page',
        authRequired: false
      }
    },
    {
      path: '/not-authorized',
      name: 'page-not-authorized',
      component: () => import('@/views/NotAuthorized.vue'),
      meta: {
        layout: 'full-page',
        authRequired: false
      }
    },
    // Redirect to 404 page, if no match found
    {
      path: '*',
      redirect: { name: 'page-not-found' }
    }
  ]
})

router.afterEach(() => {
  // Remove initial loading
  const appLoading = document.getElementById('loading-bg')
  if (appLoading) {
    appLoading.style.display = 'none'
  }
})

router.beforeEach((to, from, next) => {

    // If auth required, check login. If login fails redirect to login page
    if (to.meta.authRequired) {
      if (!(store.state.auth.isAuthenticated())) {
        router.push({ path: '/auth/login', query: { to: to.path } })
      }
    }

    if (to.name === 'auth-login' || to.path === '/') {
      if (store.state.auth.isAuthenticated()) {
        router.push({ path: '/dashboard' })
      }
    }

    return next()

})

export default router
