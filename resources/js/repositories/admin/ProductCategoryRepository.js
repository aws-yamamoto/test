import axios from 'axios'
import route from '../../config/route'

const resource = `/${route.API}`

export default {
  // 全件取得
  fetchIndex: (
    categoryId,
    shopId,
    page,
    searchKeyword,
    searchValidPeriodFrom,
    searchValidPeriodTo
  ) => {
    return axios.get(
      `${resource}/${route.PRODUCT_CATEGORY}/${categoryId}/child-categories?shop_id=${shopId}&page=${page}&keyword=${searchKeyword}&valid_period_from=${searchValidPeriodFrom}&valid_period_to=${searchValidPeriodTo}`
    )
  },
  // 1件取得
  fetchShow: id => {
    return axios.get(`${resource}/${route.PRODUCT_CATEGORY}/${id}`)
  },
  // 子カテゴリリスト取得
  fetchChildList: shopId => {
    return axios.get(
      `${resource}/${route.PRODUCT_CATEGORY}/child-categories/list?shop_id=${shopId}`
    )
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
  destroy: (id, params) => {
    return axios.delete(`/api/${resource}/${id}`, { data: params })
  },
  // 優先順位更新
  updatePriorityOrder: params => {
    return axios.patch(`/api/${resource}/priority-order/update`, params)
  },
}
