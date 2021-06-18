import axios from 'axios'
import route from '../../config/route'

const resource = `/${route.API}`

export default {
  /**
   * 管理者
   */

  /**
   * ログイン
   */
  login(params) {
    return axios.post(`${resource}/${route.LOGIN}`, params)
  },
  /**
   * ログアウト
   */
  logout() {
    return axios.post(`${resource}/${route.LOGOUT}`)
  },

  /**
   * ログインユーザー取得
   */
  fetchAuthUser() {
    return axios.get(`${resource}/${route.USER}`)
  },
}
