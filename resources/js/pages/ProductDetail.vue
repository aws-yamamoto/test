<template>
  <div>
    <h2 v-if="id">商品詳細</h2>
    <h2 v-else>商品追加</h2>

    <Breadcrumb :items="breadcrumbData" />

    <div v-if="isEditing" class="text-right">
      <button type="button" class="btn btn-light" @click="onCancel">キャンセル</button>
      <button type="button" class="btn btn-warning white-text" @click.prevent="onSave">保存</button>
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

    <div class="mb-3">
      <div>
        <img v-show="record.image" :src="record.image" class="w-25" />
      </div>
      <div v-if="isEditing">
        <label>
          <span class="btn btn-primary">
            画像アップロード
            <input ref="image" type="file" style="display:none" @change="onChangeImage" />
          </span>
        </label>
        <button
          v-show="record.image"
          type="button"
          class="btn btn-danger m-0"
          @click="onDeleteImage"
        >
          削除
        </button>
      </div>
    </div>

    <div class="row">
      <div class="form-group col-4">
        <label>商品カテゴリ名</label>
        <select
          v-model="record.product_category_id"
          class="browser-default custom-select"
          :disabled="!isEditing"
        >
          <option value="">
            選択してください
          </option>
          <option
            v-for="item in categories"
            :key="item.id"
            :value="item.id"
            :selected="record.item_id"
          >
            {{ item.name }}
          </option>
        </select>
      </div>
    </div>

    <div class="row">
      <InputForm
        id="productNameForm"
        v-model="record.name"
        :label="'商品名'"
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
      <Textarea
        id="descriptionOverviewForm"
        v-model="record.short_description"
        :label="'説明(概要)'"
        :class="'col-4'"
        :disabled="!isEditing"
      />
      <Textarea
        id="descriptionDetailForm"
        v-model="record.long_description"
        :label="'説明(詳細)'"
        :class="'col-4'"
        :disabled="!isEditing"
      />
      <button
        type="button"
        class="btn btn-light rounded-circle p-0 m-0 ml-3 mt-3"
        style="width:2rem;height:2rem;"
        @click="onDescriptionHelp()"
      >
        <i class="fas fa-info"></i>
      </button>
    </div>

    <div class="row d-flex align-items-center">
      <InputForm
        id="productUnitFrom"
        v-model="record.unit"
        :label="'単位'"
        :class="'col-4'"
        :disabled="!isEditing"
      />
      <button
        type="button"
        class="btn btn-light rounded-circle p-0 m-0 ml-3 mt-3"
        style="width:2rem;height:2rem;"
        @click="onUnitHelp()"
      >
        <i class="fas fa-info"></i>
      </button>
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

    <div class="row">
      <Textarea
        id="noteForm"
        v-model="record.note"
        :label="'備考'"
        :class="'col-4'"
        :disabled="!isEditing"
      />
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import httpStatus from '../config/httpStatus'
import Breadcrumb from '../components/Breadcrumb.vue'
import SelectBox from '../components/SelectBox.vue'
import InputForm from '../components/InputForm.vue'
import Textarea from '../components/Textarea.vue'
import DatePicker from '../components/DatePicker.vue'
import selectList from '../config/selectList'
import route from '../config/route'
import dataStructure from '../config/dataStructure'
import activityHistory from '../config/activityHistory'
import { RepositoryFactory } from '../repositories/RepositoryFactory'

const ProductRepository = RepositoryFactory.get('products')
const ProductCategoryRepository = RepositoryFactory.get('productCategories')

export default {
  components: {
    Breadcrumb,
    SelectBox,
    InputForm,
    Textarea,
    DatePicker,
  },
  mixins: [
    // ローダーmixin
    require('../mixins/loader').default,
    // モーダル
    require('../components/modal').default,
    // 画像アップロード
    require('../mixins/uploadImage').default,
    // アクティビティ履歴登録
    require('../mixins/shopActivityHistory').default,
  ],
  props: {
    id: {
      type: String,
      required: false,
      default: '',
    },
  },
  data: () => ({
    record: {},
    dispTypeList: selectList.dispTypeList,
    appDispTypeList: selectList.appDispTypeList,
    editStatusList: selectList.editStatusList,
    categories: [],
    productRoute: route.product,
    productItemStructureRoute: route.productItemStructure,
    productItemRoute: route.productItem,
    productId: null,
    errors: [],
    isEditing: false,
    breadcrumbData: [],
    imageData: null,
  }),
  computed: {
    ...mapGetters({
      selectedShopId: 'shop/selectedShopId',
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
        // 商品カテゴリ一覧取得
        const productCategories = await ProductCategoryRepository.fetchChildList(
          this.selectedShopId
        )

        if (productCategories.status !== httpStatus.OK) {
          this.$store.commit('error/setCode', productCategories.status)
          await this.showErrorReadDataModal()
          return false
        }
        this.categories = productCategories.data
        // 編集の場合
        if (this.id) {
          const response = await ProductRepository.fetchShow(this.id)

          if (response.status !== httpStatus.OK) {
            this.$store.commit('error/setCode', response.status)
            await this.showErrorReadDataModal()
            return false
          }
          this.record = response.data
          this.productId = this.id
        } else {
          this.isEditing = true
          this.record = dataStructure.product

          const lastId = await ProductRepository.fetchLastId(this.id)
          if (lastId.status !== httpStatus.OK) {
            this.$store.commit('error/setCode', lastId.status)
            await this.showErrorReadDataModal()
            return false
          }
          this.record.image_name = `product-id-${Number(lastId.data) + 1}`
        }
      } catch (e) {
        this.showErrorReadDataModal()
      } finally {
        this.hideLoader()
      }

      this.breadcrumbData = [
        {
          label: '商品管理',
          href: `/${route.PRODUCT}`,
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
        this.$router.push(`/${route.product}`)
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

        this.record = Object.assign(this.record, { shop_id: this.selectedShopId })
        if (this.imageData) {
          const image = await this.uploadImage('products')
          this.record.image = image
        }

        if (this.id) {
          // 更新処理
          response = await ProductRepository.update(this.id, this.record)
        } else {
          // 新規登録処理
          response = await ProductRepository.store(this.record)
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
          this.$shop.commit('error/setCode', response.status)
          await this.showFailuredSaveModal()
          return
        }

        // アクティビティ履歴に登録
        const kind = activityHistory.kind.PRODUCT
        const { data } = response
        const activityType =
          status === httpStatus.OK
            ? activityHistory.activityType.UPDATE
            : activityHistory.activityType.CREATED
        await this.shopActivityHistory(kind, data, activityType)

        await this.showFinishedSaveModal()
        this.$router.push(`/${route.product}`)
      } catch (e) {
        // 登録処理失敗モーダル表示
        await this.showFailuredSaveModal
        console.log(e)
      } finally {
        this.hideLoader()
      }
    },
    /**
     * 戻るボタン押下時の処理
     */
    onBack() {
      this.$router.push(`/${route.PRODUCT}`)
    },
    /**
     * アップロードされた画像を表示
     */
    async onChangeImage(event) {
      this.previewImage(event)
    },
    /**
     * アップロードされた画像を削除
     */
    onDeleteImage() {
      this.record.image = ''
      this.$el.querySelector('input[type="file"]').value = null
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
        const response = await ProductRepository.destroy(this.id, {
          shop_id: this.selectedShopId,
        })

        if (response.status !== httpStatus.OK) {
          this.$store.commit('error/setCode', response.status)
          await this.showFailuredSaveModal()
          return
        }

        // アクティビティ履歴に登録
        const kind = activityHistory.kind.PRODUCT
        const { data } = response
        const activityType = activityHistory.activityType.DELETE
        await this.shopActivityHistory(kind, data, activityType)

        // 削除完了モーダル
        await this.showFinishedDeleteModal()
        this.$router.push(`/${route.product}`)
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
    async onUnitHelp() {
      const params = {
        title: '単位とは',
        content: '/images/unit.png',
        message: 'カート画面にて、商品の単位として使用されます。',
        isCarousel: false,
      }

      await this.showHelpModal(params)
    },
    async onDescriptionHelp() {
      const params = {
        title: '説明(概要)、説明(詳細)とは',
        content: [
          {
            image: '/images/long_description.png',
            message: '説明(概要)は商品名の下に表示されます。',
          },
          {
            image: '/images/short_description.png',
            message: '説明(詳細)は商品画像上に表示されます。',
          },
        ],
        isCarousel: true,
      }

      await this.showHelpModal(params)
    },
  },
}
</script>
