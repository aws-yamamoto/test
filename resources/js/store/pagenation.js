/* eslint no-shadow: ["error", { "allow": ["state"] }] */
const state = {
  productCategoryListPage: 1,
  shopListPage: 1,
}

const getters = {}

const mutations = {
  setShopListPage(state, data) {
    state.shopListPage = data
  },
  setProductCategoryListPage(state, data) {
    state.productCategoryListPage = data
  },
}

const actions = {}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions,
}
