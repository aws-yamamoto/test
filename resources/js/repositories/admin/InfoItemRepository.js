import axios from 'axios'
import route from '../../config/route'

const resource = `/${route.API}`

export default {
  // 画像リスト取得
  fetchList: () => {
    return axios.get(`${resource}/${route.INFO_ITEM}-list`)
  },
  // 中間テーブル全件取得
  fetchIndexInfoItemPivot: () => {
    return axios.get(`/api/${route.infoItemPivot}`)
  },
  // 中間テーブル削除
  destroyInfoItemPivot: id => {
    return axios.delete(`/api/${route.infoItemPivot}/${id}`)
  },
  // 最後のIDを取得
  fetchLastId: () => {
    return axios.get(`/api/${route.infoItem}/id/last`)
  },
  // 全件取得
  fetchIndex: (page, searchKeyword) => {
    return axios.get(`/api/${route.infoItem}?page=${page}&keyword=${searchKeyword}`)
  },
  // 1件取得
  fetchShow: id => {
    return axios.get(`/api/${route.infoItem}/${id}`)
  },
  // 更新
  update: (id, params) => {
    return axios.patch(`/api/${resource}/${id}`, params)
  },
  // 新規作成
  store: params => {
    return axios.post(`/api/${resource}`, params)
  },
  // 削除
  destroy: id => {
    return axios.delete(`/api/${resource}/${id}`)
  },
}
