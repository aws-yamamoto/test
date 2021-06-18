/**
 * アクティビティを登録するミックスイン
 */
import { mapState } from 'vuex'
import { RepositoryFactory } from '../repositories/RepositoryFactory'

const ActivityHistoryRepository = RepositoryFactory.get('activityHistories')

export default {
  computed: {
    ...mapState({
      user: state => state.auth.user,
    }),
  },
  data: () => ({
    apiParam: null,
    targetRecordNum: 1,
    calcPriorityNum: 1,
  }),
  methods: {
    /**
     * アクティビティ登録処理
     * @param {String} kind
     * @param {Object} data
     * @param {String} activityType
     */
    async shopActivityHistory(kind, data, activityType) {
      const apiParams = {
        user_id: this.user.id,
        user_name: this.user.name,
        kind,
        data,
        avtivity_type: activityType,
      }

      const response = await ActivityHistoryRepository.shop(apiParams)
      return response
    },
  },
}
