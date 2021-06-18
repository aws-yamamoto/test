import axios from 'axios'
import route from '../../config/route'

const resource = `/${route.API}`

export default {
  // トークンリフレッシュ
  refreshToken: () => {
    return axios.get(`${resource}/${route.REFRESH_TOKEN}`)
  },
}
