/* eslint no-shadow: ["error", { "allow": ["state"] }] */

const state = {
  searchKeyword: '',
  searchValidPeriodFrom: '',
  searchValidPeriodTo: '',
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
}

const actions = {}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions,
}
