<template>
  <div>
    <h2 v-if="id">商品カテゴリ詳細</h2>
    <h2 v-else>商品カテゴリ追加</h2>

    <Breadcrumb :items="breadcrumbData" />

    <div v-if="isEditing" class="text-right mb-3">
      <button type="button" class="btn btn-light" @click="onCancel">キャンセル</button>
      <button type="button" class="btn btn-warning white-text" @click="onSave">保存</button>
    </div>

    <div v-else class="text-right mb-3">
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
        :id="'productCategoryNameForm'"
        v-model="record.name"
        :label="'商品カテゴリ名'"
        :class="'col-4'"
        :disabled="!isEditing"
      />
      <InputForm
        :id="'productCategoryNameDispForm'"
        v-model="record.subname"
        :label="'商品カテゴリ名(サブ名称)'"
        :class="'col-4'"
        :disabled="!isEditing"
      />
    </div>

    <div class="row">
      <DatePicker
        :id="'productDatePickerFrom'"
        v-model="record.valid_period_from"
        :label="'有効期間(From)'"
        :class="'col-4'"
        :disabled="!isEditing"
      />

      <DatePicker
        :id="'productDatePickerTo'"
        v-model="record.valid_period_to"
        :label="'有効期間(To)'"
        :class="'col-4'"
        :disabled="!isEditing"
      />
    </div>

    <div class="row">
      <InputForm
        :id="'priorityOrderForm'"
        v-model="record.priority_order"
        :label="'優先順位'"
        :class="'col-4'"
        :disabled="!isEditing"
      />
    </div>

    <div class="row d-flex align-items-center">
      <SelectBox
        v-model="record.app_display_type"
        :label="'アプリ表示区分'"
        :class-val="'col-4 mb-3'"
        :items="appDispTypeList"
        :disabled="!isEditing"
      />
      <button
        type="button"
        class="btn btn-light rounded-circle p-0 m-0 ml-3 mt-3"
        style="width:2rem;height:2rem;"
        @click="onAppDesplayTypeHelp()"
      >
        <i class="fas fa-info"></i>
      </button>
    </div>

    <div class="row d-flex align-items-center">
      <SelectBox
        v-model="record.disp_type"
        :label="'表示区分'"
        :class-val="'col-4 mb-3'"
        :items="dispTypeList"
        :disabled="!isEditing"
      />
      <button
        type="button"
        class="btn btn-light rounded-circle p-0 m-0 ml-3 mt-3"
        style="width:2rem;height:2rem;"
        @click="onDispTypeHelp()"
      >
        <i class="fas fa-info"></i>
      </button>
    </div>

    <div class="row d-flex align-items-center">
      <SelectBox
        v-model="record.edit_status"
        :items="editStatusList"
        :label="'編集ステータス'"
        :class="'col-4'"
        :disabled="!isEditing"
      />
      <button
        type="button"
        class="btn btn-light rounded-circle p-0 m-0 ml-3 mt-3"
        style="width:2rem;height:2rem;"
        @click="onEditStatusHelp()"
      >
        <i class="fas fa-info"></i>
      </button>
    </div>

    <div v-if="record.parent_product_category_id" class="row">
      <p class="col-4">info ポップアップ画像</p>
    </div>
    <div v-if="record.parent_product_category_id && isEditing" class="row">
      <p class="col-12 text-danger">
        ※リストにない画像を登録する場合は
        <a :href="`/${infoItemRoute}`" target="_blank">info ポップアップ管理</a>から登録してください
      </p>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapState } from 'vuex'
import httpStatus from '../config/httpStatus'
import Breadcrumb from '../components/Breadcrumb.vue'
import SelectBox from '../components/SelectBox.vue'
import InputForm from '../components/InputForm.vue'
import DatePicker from '../components/DatePicker.vue'
import selectList from '../config/selectList'
import route from '../config/route'
import dataStructure from '../config/dataStructure'
import activityHistory from '../config/activityHistory'
import { RepositoryFactory } from '../repositories/RepositoryFactory'

const ProductCategoryRepository = RepositoryFactory.get('productCategories')
const InfoItemRepository = RepositoryFactory.get('infoItems')

export default {
  components: {
    Breadcrumb,
    SelectBox,
    InputForm,
    DatePicker,
  },
  mixins: [
    // ローダーmixin
    require('../mixins/loader').default,
    // モーダル
    require('../components/modal').default,
    // アクティビティ履歴登録
    require('../mixins/shopActivityHistory').default,
  ],
  props: {
    id: {
      type: String,
      required: false,
      default: '',
    },
    categoryId: {
      type: String,
      required: false,
      default: '1',
    },
  },
  data: () => ({
    record: {},
    dispTypeList: selectList.dispTypeList,
    appDispTypeList: selectList.appDispTypeList,
    editStatusList: selectList.editStatusList,
    errors: [],
    isEditing: false,
    breadcrumbData: [],
    infoItemList: [],
    infoItemRoute: route.infoItem,
  }),
  computed: {
    ...mapGetters({
      selectedStoreId: 'shop/selectedShopId',
    }),
    ...mapState({
      productCategoryName: state => state.breadcrum.productCategoryName,
    }),
  },
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
      this.showLoader()
      try {
        let infoItemList = await InfoItemRepository.fetchList()
        if (infoItemList.status !== httpStatus.OK) {
          this.$store.commit('error/setCode', infoItemList.status)
          await this.showErrorReadDataModal()
          return false
        }
        infoItemList = infoItemList.data
        this.infoItemList = infoItemList.map(x => {
          return {
            id: x.id,
            value: x.info_item_name,
            image: x.image,
          }
        })
        // 編集の場合
        if (this.id) {
          const response = await ProductCategoryRepository.fetchShow(this.id)
          console.log(response)
          if (response.status !== httpStatus.OK) {
            this.$store.commit('error/setCode', response.status)
            await this.showErrorReadDataModal()
            return false
          }
          console.log(response.data)
          this.record = response.data
        } else {
          this.isEditing = true
          this.record = dataStructure.productCategory
          if (this.categoryId) {
            this.record.parent_product_category_id = this.categoryId
          }
        }
      } catch (e) {
        this.showErrorReadDataModal()
      } finally {
        this.hideLoader()
      }

      this.breadcrumbData = [
        {
          label: '商品カテゴリ管理',
          href: `/${route.PRODUCT_CATEGORY_LIST}`,
        },
        {
          label: this.record.name,
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
        this.$router.push(`/${route.PRODUCT_CATEGORY_LIST}`)
      } else {
        // 初期読み込み
        this.load()
        this.isEditing = false
        this.clearError()
      }
    },
    /**
     * 保存ボタン押下時の処理
     */
    async onSave() {
      try {
        this.showLoader()

        // 保存確認モーダル表示
        const result = await this.showConfirmSaveModal()
        if (!result) return

        let response = null

        this.record = Object.assign(this.record, { shop_id: this.selectedStoreId })
        if (this.id) {
          // 更新処理
          response = await ProductCategoryRepository.update(this.id, this.record)
        } else {
          // 新規登録処理
          response = await ProductCategoryRepository.store(this.record)
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
        const kind = this.record.parent_product_category_id
          ? activityHistory.kind.PRODUCT_CATEGORY
          : activityHistory.kind.TOP_PRODUCT_CATEGORY
        const { data } = response
        const activityType =
          status === httpStatus.OK
            ? activityHistory.activityType.UPDATE
            : activityHistory.activityType.CREATED
        await this.shopActivityHistory(kind, data, activityType)

        await this.showFinishedSaveModal()
        if (this.record.parent_product_category_id) {
          this.$router.push(
            `/${route.PRODUCT_CATEGORY_LIST}/${this.categoryId}/${route.PRODUCT_CATEGORY}`
          )
        } else {
          this.$router.push(`/${route.PRODUCT_CATEGORY_LIST}`)
        }
      } catch (e) {
        // 登録処理失敗モーダル表示
        await this.showFailuredSaveModal()
        console.log(e)
      } finally {
        this.hideLoader()
      }
    },
    /**
     * 戻るボタン押下時の処理
     */
    onBack() {
      this.$router.push(`/${route.PRODUCT_CATEGORY_LIST}`)
    },
    /**
     * 削除処理
     */
    async onDelete() {
      // 削除確認モーダル
      const result = await this.showConfirmDeleteModal(this.record.name)
      if (!result) return

      this.showLoader()
      try {
        const response = await ProductCategoryRepository.destroy(this.id, {
          store_id: this.selectedStoreId,
        })

        if (response.status !== httpStatus.OK) {
          this.$store.commit('error/setCode', response.status)
          await this.showFailuredDeleteModal()
          return
        }

        // アクティビティに登録
        const kind = this.record.parent_product_category_id
          ? activityHistory.kind.PRODUCT_CATEGORY
          : activityHistory.kind.TOP_PRODUCT_CATEGORY
        const { data } = response
        const activityType = activityHistory.activityType.DELETE
        await this.shopActivityHistory(kind, data, activityType)

        // 削除完了モーダル
        await this.showFinishedDeleteModal()
        if (this.record.parent_product_category_id) {
          this.$router.push(
            `/${route.PRODUCT_CATEGORY_LIST}/${this.categoryId}/${route.PRODUCT_CATEGORY}`
          )
        } else {
          this.$router.push(`/${route.PRODUCT_CATEGORY_LIST}`)
        }
      } catch (e) {
        // 削除処理失敗モーダル
        await this.showFailuredDeleteModal()
        console.log(e)
      } finally {
        this.hideLoader()
      }
    },
    // info ポップアップ画像
    addInfoItem() {
      this.record.info_items.push({
        id: null,
      })
    },
    async deleteInfoItem(id, infoItemIndex) {
      const itemName = this.infoItemList.find(x => x.id === id).value
      // 削除確認モーダル
      const result = await this.showConfirmDeleteModal(itemName)
      if (!result) return

      this.showLoader()
      try {
        let infoItemPivots = await InfoItemRepository.fetchIndexInfoItemPivot()
        infoItemPivots = infoItemPivots.data
        const targetInfoItemPivot = infoItemPivots.find(
          x => x.info_item_id === id && x.product_category_id === this.record.id
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
    onPreview(image) {
      window.open(image, '_blank')
    },
    /**
     * 表示されているエラーをクリア
     */
    clearError() {
      this.errors = null
    },
    /**
     * ヘルプボタン押下時
     */
    async onAppDesplayTypeHelp() {
      const params = {
        title: 'アプリ表示区分とは',
        content: [
          {
            image: '/images/app_display_type_full.png',
            message: '横幅フル表示',
          },
          {
            image: '/images/app_display_type_half.png',
            message: '横幅ハーフ表示',
          },
        ],
        isCarousel: true,
      }

      await this.showHelpModal(params)
    },
    async onDispTypeHelp() {
      const params = {
        title: '表示区分とは',
        content: `
        表示：アプリ画面に表示されます。
        非表示：アプリ画面に表示されません。
        プレ表示：検証モード時のみアプリ画面に表示されます。
        `,
      }

      await this.showTextHelpModal(params)
    },
    async onEditStatusHelp() {
      const params = {
        title: '編集ステータスとは',
        content: `
        編集完了：アプリ画面に表示されます。
        編集中：アプリ画面に表示されません。
        `,
      }

      await this.showTextHelpModal(params)
    },
  },
}
</script>
