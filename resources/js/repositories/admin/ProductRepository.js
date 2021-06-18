import axios from 'axios'
import route from '../../config/route'

const resource = `/${route.API}`

export default {
  // 全件取得
  fetchIndex: (
    shopId,
    page,
    searchKeyword,
    topProductCategoryId,
    productCategoryId,
    searchValidPeriodFrom,
    searchValidPeriodTo
  ) => {
    return axios.get(
      `${resource}/${route.PRODUCT}?shop_id=${shopId}&page=${page}&keyword=${searchKeyword}&top_product_category_id=${topProductCategoryId}&product_category_id=${productCategoryId}&valid_period_from=${searchValidPeriodFrom}&valid_period_to=${searchValidPeriodTo}`
    )
  },
  // 1件取得
  fetchShow: id => {
    return axios.get(`${resource}/${route.PRODUCT}/${id}`)
  },
  // リスト取得
  fetchList: () => {
    return axios.get(`${resource}/${route.PRODUCT}/name/list`)
  },
  // 一番大きいIDを取得
  fetchLastId: () => {
    return axios.get(`${resource}/${route.PRODUCT}/id/last`)
  },
  // 更新
  update: (id, params) => {
    return axios.patch(`${resource}/${route.PRODUCT}/${id}`, params)
  },
  // 新規作成
  store: params => {
    return axios.post(`${resource}/${route.PRODUCT}`, params)
  },
  // 削除
  destroy: (id, params) => {
    return axios.delete(`${resource}/${route.PRODUCT}/${id}`, { data: params })
  },
  storeCopy: params => {
    return axios.post(`${resource}/${route.PRODUCT}/copy`, params)
  },
}
