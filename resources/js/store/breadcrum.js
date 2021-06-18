/* eslint no-shadow: ["error", { "allow": ["state"] }] */

const state = {
  productCategoryName: '',
  productId: null,
  productName: '',
  productItemStructureName: '',
  productItemName: '',
  itemName: '',
  productItemQuantityName: '',
}

const getters = {}

const mutations = {
  setSelectedProductCategoryName(state, data) {
    state.productCategoryName = data
  },
  setSelectedProductId(state, data) {
    state.productId = data
  },
  setSelectedProductName(state, data) {
    state.productName = data
  },
  setSelectedProductItemStructureName(state, data) {
    state.productItemStructureName = data
  },
  setSelectedProductItemName(state, data) {
    state.productItemName = data
  },
  setSelectedItemName(state, data) {
    state.itemName = data
  },
  setSelectedProductItemQuantityName(state, data) {
    state.productItemQuantityName = data
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
