/* eslint no-shadow: ["error", { "allow": ["state"] }] */
const state = {
  shopId: null,
  searchKeyword: '',
}

const getters = {
  selectedShopId: state => state.shopId,
}

const mutations = {
  setSelectedShopId(state, shopId) {
    state.shopId = shopId
  },
  setSearchKeyword(state, data) {
    state.searchKeyword = data
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
