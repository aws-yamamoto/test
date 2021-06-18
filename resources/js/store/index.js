import Vue from 'vue'
import Vuex from 'vuex'

import auth from './auth'
import error from './error'
import menu from './menu'
import pagenation from './pagenation'
import shop from './shop'
import breadcrum from './breadcrum'
import productCategory from './productCategory'
import product from './product'
import productItemStructure from './productItemStructure'

Vue.use(Vuex)
const store = new Vuex.Store({
  modules: {
    auth,
    error,
    menu,
    pagenation,
    shop,
    breadcrum,
    productCategory,
    product,
    productItemStructure,
  },
})

export default store
