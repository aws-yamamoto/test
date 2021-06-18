<template>
  <div>
    <h2 v-if="id">店舗詳細</h2>
    <h2 v-else>店舗設定 追加</h2>

    <Breadcrumb :items="breadcrumbData" />

    <div v-if="isEditing" class="text-right">
      <button type="button" class="btn btn-light" @click="onCancel">キャンセル</button>
      <button type="button" class="btn btn-warning white-text" @click="onSave">保存</button>
    </div>

    <div v-else class="text-right">
      <button type="button" class="btn btn-light" @click="onBack">戻る</button>
      <button type="button" class="btn btn-primary" @click="onEditing">編集</button>
      <button type="button" class="btn btn-danger" @click="onDelete">削除</button>
    </div>

    <div v-if="errors" class="text-danger text-left">
      <ul>
        <li v-for="msg in errors" :key="msg">{{ msg }}</li>
      </ul>
    </div>

    <div class="row">
      <InputForm
        :id="'shopNameForm'"
        v-model="record.shop_name"
        :label="'店舗名'"
        :class="'col-4'"
        :disabled="!isEditing"
      />
    </div>

    <div class="row">
      <InputForm
        :id="'shopTelForm'"
        v-model="record.tel"
        :label="'電話番号'"
        :class="'col-4'"
        :disabled="!isEditing"
      />
    </div>
  </div>
</template>

<script>
import httpStatus from '../config/httpStatus'
import InputForm from '../components/InputForm.vue'
import Breadcrumb from '../components/Breadcrumb.vue'
import route from '../config/route'
import dataStructure from '../config/dataStructure'
import activityHistory from '../config/activityHistory'
import { RepositoryFactory } from '../repositories/RepositoryFactory'

const ShopRepository = RepositoryFactory.get('shops')
const InfoItemRepository = RepositoryFactory.get('infoItems')

export default {
  components: {
    InputForm,
    Breadcrumb,
  },
  mixins: [
    // ローダーmixin
    require('../mixins/loader').default,
    // モーダル
    require('../components/modal').default,
    // アクティビティ履歴登録
    require('../mixins/shopActivityHistory').default,
    // 画像アップロード
    require('../mixins/uploadImage').default,
  ],
  props: {
    id: {
      type: String,
      default: '',
    },
  },
  data: () => ({
    isEditing: false,
    imageData: null,
    imageAppLogo: null,
    imageLabelLogo: null,
    record: {},
    errors: [],
    breadcrumbData: [],
    infoItemList: [],
    infoItemRoute: route.INFO_ITEM,
  }),
  watch: {
    $route: {
      async handler() {
        await this.load()
      },
      immediate: true,
    },
  },
  created() {
    this.clearError()
  },
  methods: {
    /**
     * ページ切り替え時の処理
     */
    async load() {
      try {
        this.showLoader()
        let infoItemList = await InfoItemRepository.fetchList()
        infoItemList = infoItemList.data
        console.log(infoItemList)
        this.infoItemList = infoItemList.map(x => {
          return {
            id: x.id,
            value: x.info_item_name,
            image: x.image,
          }
        })
        // 編集の場合
        if (this.id) {
          const response = await ShopRepository.fetchShow(this.id)
          if (response.status !== httpStatus.OK) {
            this.$shop.commit('error/setCode', response.status)
            await this.showErrorReadDataModal()
            return false
          }

          this.record = response.data
        } else {
          this.isEditing = true
          this.record = dataStructure.shop
        }
      } catch (e) {
        this.showErrorReadDataModal()
      } finally {
        this.hideLoader()
      }

      this.breadcrumbData = [
        {
          label: `店舗管理`,
          href: `/${route.shop}`,
        },
        {
          label: this.record.shop_name,
        },
      ]
      return null
    },
    /**
     * 編集ボタン押下時の処理
     */
    onEditing() {
      this.isEditing = true
    },
    /**
     * キャンセルボタン押下時の処理
     */
    async onCancel() {
      const result = await this.showCancelModal()
      if (!result) return

      if (!this.id) {
        this.$router.push(`/${route.shop}`)
      } else {
        // 初期読み込み
        this.load()
        this.isEditing = false
        this.clearError()
      }
    },
    /**
     * 戻るボタン押下時の処理
     */
    onBack() {
      this.$router.push(`/${route.SHOP_LIST}`)
    },
    /**
     * 保存ボタン押下時の処理
     */
    async onSave() {
      this.showLoader()
      try {
        // 保存確認モーダル表示
        const result = await this.showConfirmSaveModal()
        if (!result) return

        let response = null
        if (this.id) {
          // 更新処理
          response = await ShopRepository.update(this.id, this.record)
        } else {
          // 新規登録処理
          response = await ShopRepository.shop(this.record)
        }

        if (response.status === httpStatus.UNPROCESSABLE_ENTITY) {
          let errors = []
          // eslint-disable-next-line no-restricted-syntax
          for (const key of Object.keys(response.data.errors)) {
            errors = [...errors, ...response.data.errors[key]]
          }
          this.errors = errors
          return
        }

        let status = httpStatus.OK
        if (!this.id) status = httpStatus.CREATED

        if (response.status !== status) {
          this.$store.commit('error/setCode', response.status)
          await this.showFailuredSaveModal()
          return
        }

        // アクティビティ履歴に登録
        const kind = activityHistory.kind.STORE
        const { data } = response
        const activityType =
          status === httpStatus.OK
            ? activityHistory.activityType.UPDATE
            : activityHistory.activityType.CREATED
        await this.shopActivityHistory(kind, data, activityType)

        await this.showFinishedSaveModal()
        this.$router.push(`/${route.shop}`)
      } catch (e) {
        // 登録処理失敗モーダル表示
        await this.showFailuredSaveModal
        console.log(e)
      } finally {
        this.hideLoader()
      }
    },
    /**
     * 削除ボタン押下時の処理
     */
    async onDelete() {
      // 削除確認モーダル
      const result = await this.showConfirmDeleteModal(this.record.shop_name)
      if (!result) return

      this.showLoader()
      try {
        const response = await ShopRepository.destroy(this.id)

        if (response.status !== httpStatus.OK) {
          this.$shop.commit('error/setCode', response.status)
          await this.showFailuredSaveModal()
          return
        }

        // アクティビティ履歴に登録
        const kind = activityHistory.kind.STORE
        const { data } = response
        const activityType = activityHistory.activityType.DELETE
        await this.shopActivityHistory(kind, data, activityType)

        // 削除完了モーダル
        await this.showFinishedDeleteModal()
        this.$router.push(`/${route.shop}`)
      } catch (e) {
        // 削除処理失敗モーダル
        await this.showFailuredDeleteModal()
        console.log(e)
      } finally {
        this.hideLoader()
      }
    },
    addInfoItem() {
      this.record.info_items.push({
        id: null,
      })
    },
    async deleteInfoItem(id, infoItemIndex) {
      // 削除確認モーダル
      const itemName = this.infoItemList.find(x => x.id === id).value
      const result = await this.showConfirmDeleteModal(itemName)
      if (!result) return

      this.showLoader()
      try {
        const infoItemPivots = await InfoItemRepository.fetchIndexInfoItemPivot()
        const targetInfoItemPivot = infoItemPivots.data.find(
          x => x.info_item_id === id && x.shop_id === this.record.id
        )

        if (targetInfoItemPivot) {
          const response = await InfoItemRepository.destroyInfoItemPivot(targetInfoItemPivot.id)

          if (response.status !== httpStatus.OK) {
            this.$store.commit('error/setCode', response.status)
            await this.showFailuredDeleteModal()
            return
          }

          this.record.info_items = this.record.info_items.filter(
            (x, index) => index !== infoItemIndex
          )
        } else {
          this.record.info_items = this.record.info_items.filter(
            (x, index) => index !== infoItemIndex
          )
        }
      } catch (e) {
        // 削除処理失敗モーダル
        await this.showFailuredDeleteModal()
        console.log(e)
      } finally {
        this.hideLoader()
      }
    },
    /**
     * 表示されているエラーをクリア
     */
    clearError() {
      this.errors = null
    },
  },
}
</script>
