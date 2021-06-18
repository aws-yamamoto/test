/* eslint no-shadow: ["error", { "allow": ["state"] }] */

const state = {
  searchKeyword: '',
  searchValidPeriodFrom: '',
  searchValidPeriodTo: '',
  selectedProductCategoryId: null,
}

const getters = {}

const mutations = {
  setSearchKeyword(state, data) {
    state.searchKeyword = data
  },
  setSearchValidPeriodFrom(state, data) {
    state.searchValidPeriodFrom = data
  },
  setSearchValidPeriodTo(state, data) {
    state.searchValidPeriodTo = data
  },
  setSelectedProductCategoryId(state, data) {
    state.selectedProductCategoryId = data
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
