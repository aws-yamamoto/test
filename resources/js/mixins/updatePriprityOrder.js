/**
 * 優先順位を更新するミックスイン
 */
import httpStatus from '../config/httpStatus'
import { RepositoryFactory } from '../repositories/RepositoryFactory'

const ProductCategoryRepository = RepositoryFactory.get('productCategories')
const ProductItemStructureRepository = RepositoryFactory.get('productItemStructures')
const ProductItemRepository = RepositoryFactory.get('productItems')

export default {
  data: () => ({
    apiParam: null,
    targetRecordNum: 1,
    calcPriorityNum: 1,
  }),
  methods: {
    /**
     * 優先順位計算(上位に更新)
     * @param {Object} selectedRecord
     * @param {Number} index
     * @param {String} resource
     * @param {String} type
     */
    upPriorityOrder(selectedRecord, index, resource, type = 'priority_order') {
      // 優先順位ボタンを押されたレコードより、優先順位が1つ上のレコード
      const beforeRecord = this.records[index - this.targetRecordNum]
      switch (type) {
        case 'priority_order':
          this.apiParam = [
            {
              id: selectedRecord.id,
              priority_order: Number(selectedRecord.priority_order) - this.calcPriorityNum,
            },
            {
              id: beforeRecord.id,
              priority_order: Number(beforeRecord.priority_order) + this.calcPriorityNum,
            },
          ]
          break
        case 'disp_order':
          this.apiParam = [
            {
              id: selectedRecord.id,
              disp_order: Number(selectedRecord.disp_order) - this.calcPriorityNum,
            },
            {
              id: beforeRecord.id,
              disp_order: Number(beforeRecord.disp_order) + this.calcPriorityNum,
            },
          ]
          break
        default:
          break
      }
      this.update(this.apiParam, resource)
    },
    /**
     * 優先順位計算(下位に更新)
     * @param {Object} selectedRecord
     * @param {Number} index
     * @param {String} resource
     * @param {String} type
     */
    downPriorityOrder(selectedRecord, index, resource, type = 'priority_order') {
      // 優先順位ボタンを押されたレコードより、優先順位が1つ下のレコード
      const afterRecord = this.records[index + this.targetRecordNum]

      switch (type) {
        case 'priority_order':
          this.apiParam = [
            {
              id: selectedRecord.id,
              priority_order: Number(selectedRecord.priority_order) + this.calcPriorityNum,
            },
            {
              id: afterRecord.id,
              priority_order: Number(afterRecord.priority_order) - this.calcPriorityNum,
            },
          ]
          break
        case 'disp_order':
          this.apiParam = [
            {
              id: selectedRecord.id,
              disp_order: Number(selectedRecord.disp_order) + this.calcPriorityNum,
            },
            {
              id: afterRecord.id,
              disp_order: Number(afterRecord.disp_order) - this.calcPriorityNum,
            },
          ]
          break
        default:
          break
      }

      this.update(this.apiParam, resource)
    },
    /**
     * API更新処理
     * @param {Array} apiParam
     * @param {String} resource
     */
    async update(apiParam, resource) {
      try {
        this.showLoader()

        let response = null

        switch (resource) {
          case 'productCategory':
            response = await ProductCategoryRepository.updatePriorityOrder(apiParam)
            break
          case 'productItemStructure':
            response = await ProductItemStructureRepository.updatePriorityOrder(apiParam)
            break
          case 'productItem':
            response = await ProductItemRepository.updatePriorityOrder(apiParam)
            break
          default:
            break
        }

        if (response.status !== httpStatus.OK) {
          this.$store.commit('error/setCode', response.status)
          await this.showErrorReadDataModal()
          return false
        }

        // eslint-disable-next-line no-restricted-globals
        location.reload()
      } catch (e) {
        await this.showFailuredSaveModal()
        console.log(e)
      } finally {
        this.hideLoader()
      }
      return null
    },
  },
}
