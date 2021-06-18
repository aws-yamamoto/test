/* eslint no-shadow: ["error", { "allow": ["state"] }] */
import axios from 'axios'
import httpStatus from '../config/httpStatus'
import { RepositoryFactory } from '../repositories/RepositoryFactory'

const AuthRepository = RepositoryFactory.get('auth')

const state = {
  user: null,
  apiStatus: null,
  loginErrorMessages: null,
  registerErrorMessages: null,
}

const getters = {
  check: state => !!state.user,
  username: state => (state.user ? state.user.name : ''),
}

const mutations = {
  setUser(state, user) {
    state.user = user
  },
  setApiStatus(state, status) {
    state.apiStatus = status
  },
  setLoginErrorMessages(state, messages) {
    state.loginErrorMessages = messages
  },
  setRegisterErrorMessages(state, messages) {
    state.registerErrorMessages = messages
  },
}

const actions = {
  // ユーザー登録
  async register(context, data) {
    context.commit('setApiStatus', null)
    const response = await axios.post('/api/register', data)

    if (response.status === httpStatus.CREATED) {
      context.commit('setApiStatus', true)
      // context.commit('setUser', response.data)
      return response.data
    }

    context.commit('setApiStatus', false)
    if (response.status === httpStatus.UNPROCESSABLE_ENTITY) {
      context.commit('setRegisterErrorMessages', response.data.errors)
    } else {
      context.commit('error/setCode', response.status, { root: true })
    }
    return response
  },

  // ログイン
  async login(context, data) {
    context.commit('setApiStatus', null)
    // const response = await axios.post('/api/login', data)
    const response = await AuthRepository.login(data)
    if (response.status === httpStatus.OK) {
      context.commit('setApiStatus', true)
      context.commit('setUser', response.data)
      return false
    }

    context.commit('setApiStatus', false)
    if (response.status === httpStatus.UNPROCESSABLE_ENTITY) {
      context.commit('setLoginErrorMessages', response.data.errors)
    } else {
      context.commit('error/setCode', response.status, { root: true })
    }
    return response
  },

  // ログアウト
  async logout(context) {
    context.commit('setApiStatus', null)
    const response = await AuthRepository.logout()
    if (response.status === httpStatus.OK) {
      context.commit('setApiStatus', true)
      context.commit('setUser', null)
      return false
    }

    context.commit('setApiStatus', false)
    context.commit('error/setCode', response.status, { root: true })
    return response
  },

  // ログインユーザーチェック
  async currentUser(context) {
    context.commit('setApiStatus', null)
    const response = await AuthRepository.fetchAuthUser()
    const user = response.data || null

    if (response.status === httpStatus.OK) {
      context.commit('setApiStatus', true)
      context.commit('setUser', user)
      return false
    }
    context.commit('setApiStatus', false)
    context.commit('error/setCode', response.status, { root: true })
    return response
  },
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions,
}
