import axios from 'axios'
import route from '../../config/route'

const resource = `/${route.API}`

export default {
  // リスト取得
  fetchList: () => {
    return axios.get(`${resource}/${route.SHOP_LIST}`)
  },
  // 全件取得
  fetchIndex: (page, searchKeyword) => {
    return axios.get(`${resource}/${route.SHOP}?page=${page}&keyword=${searchKeyword}`)
  },
  // 1件取得
  fetchShow: id => {
    return axios.get(`${resource}/${route.SHOP}/${id}`)
  },
  // 更新
  update: (id, params) => {
    return axios.patch(`${resource}/${route.SHOP}/${id}`, params)
  },
  // 新規作成
  store: params => {
    return axios.post(`${resource}/${route.SHOP}`, params)
  },
  // 削除
  destroy: id => {
    return axios.delete(`${resource}/${route.SHOP}/${id}`)
  },
}
