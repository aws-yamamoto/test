import './bootstrap'
import Vue from 'vue'

// loader
import Loading from 'vue-loading-overlay'
import 'vue-loading-overlay/dist/vue-loading.css'

import VueSidebarMenu from 'vue-sidebar-menu'
import 'vue-sidebar-menu/dist/vue-sidebar-menu.css'

import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import locale from 'element-ui/lib/locale/lang/en'

// smoothScroll
import smoothScroll from 'vue-smoothscroll'

import App from './App.vue'

import 'core-js/stable'
import 'regenerator-runtime/runtime'

// vue router
import router from './router'

// vuex
import store from './store'

Vue.use(ElementUI, { locale })
Vue.use(smoothScroll)
Vue.use(VueSidebarMenu)
Vue.use(Loading)

Vue.component('pagination', require('laravel-vue-pagination'))

require('./filters/index')
require('./bootstrap')

const createApp = async () => {
  await store.dispatch('auth/currentUser')
  // eslint-disable-next-line no-unused-vars
  const app = new Vue({
    el: '#app',
    router,
    store,
    components: { App },
    template: '<App />',
  })
}

createApp()
