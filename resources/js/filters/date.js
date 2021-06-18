/**
 * @fileOverview データベースの日時等を 'YYYY-MM-DD' 形式に変換して表示する
 */

import moment from 'moment'
import Vue from 'vue'

Vue.filter('date', (value, format) => {
  if (!value) return ''
  return moment(value).format(format || 'YYYY-MM-DD')
})
