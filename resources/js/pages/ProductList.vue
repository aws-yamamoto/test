<template>
  <div>
    <div class="d-flex align-items-center">
      <h2 class="mb-0">商品管理</h2>
      <button
        type="button"
        class="btn btn-light rounded-circle p-0 m-0 ml-3"
        style="width:2rem;height:2rem;"
        @click="onHelp()"
      >
        <i class="fas fa-info"></i>
      </button>
    </div>

    <SearchBox
      v-model="inputSearchKeyword"
      :placeholder="'商品名'"
      :value="inputSearchKeyword"
      @search="search"
    />

    <p class="mb-2">有効期間で絞り込み</p>
    <div class="d-flex align-items-center mb-3">
      <el-date-picker
        v-model="inputSearchValidPeriodFrom"
        type="date"
        value-format="yyyy-MM-dd"
        placeholder="有効期間(From)"
      >
      </el-date-picker>
      <span class="mx-2">〜</span>
      <el-date-picker
        v-model="inputSearchValidPeriodTo"
        type="date"
        value-format="yyyy-MM-dd"
        placeholder="有効期間(To)"
      >
      </el-date-picker>
    </div>

    <div class="row">
      <SelectBox
        v-model="inputSelectedProductCategoryId"
        :label="'商品カテゴリで絞り込み'"
        :class-val="'col-4 mb-3'"
        :items="productCategories"
      />
    </div>

    <div class="text-right">
      <RouterLink class="btn btn-success text-right" :to="`${productRoute}/new`">
        追加
      </RouterLink>

      <button type="button" class="btn btn-warning" @click="onAddCopy()">
        商品をコピーして新規追加
      </button>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">優先順位</th>
          <th scope="col">商品カテゴリ</th>
          <th scope="col">商品名</th>
          <th scope="col">有効期間</th>
          <th scope="col">画像</th>
          <th scope="col">表示区分</th>
          <th scope="col">備考</th>
          <th scope="col"></th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in records" :key="item.id">
          <td class="align-middle">{{ item.priority_order }}</td>
          <td class="align-middle">{{ item.product_category_name }}</td>
          <td class="align-middle">{{ item.name }}</td>
          <td class="align-middle">
            {{ item.valid_period_from | date }} <br />~<br />
            {{ item.valid_period_to | date }}
          </td>
          <td class="align-middle image-column"><img :src="item.image" class="w-100" /></td>
          <td v-if="item.disp_type === 1" class="align-middle">
            <h5>
              <span class="badge badge-default p-2">
                表示
              </span>
            </h5>
          </td>
          <td v-else-if="item.disp_type === 2" class="align-middle">
            <h5>
              <span class="badge badge-light p-2">
                非表示
              </span>
            </h5>
          </td>
          <td v-else class="align-middle">
            <h5>
              <span class="badge badge-secondary p-2">
                プレ表示
              </span>
            </h5>
          </td>
          <td class="align-middle">{{ item.note }}</td>
          <td class="align-middle">
            <RouterLink class="btn btn-primary text-white" :to="`/${productRoute}/${item.id}`">
              詳細
            </RouterLink>
          </td>
          <td class="align-middle">
            <button
              type="button"
              class="btn btn-primary"
              @click="onProductItemStructure(item.id, item.name)"
            >
              商品構成
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <Paginate :pagination-data="paginationData" @getPaginationResults="getPaginationResults" />
  </div>
</template>

<script>
import { mapState } from 'vuex'
import httpStatus from '../config/httpStatus'
import route from '../config/route'
import Paginate from '../components/Paginate.vue'
import SearchBox from '../components/SearchBox.vue'
import SelectBox from '../components/SelectBox.vue'
import { RepositoryFactory } from '../repositories/RepositoryFactory'

const ProductRepository = RepositoryFactory.get('products')
const ProductCategoryRepository = RepositoryFactory.get('productCategories')

export default {
  components: {
    Paginate,
    SearchBox,
    SelectBox,
  },
  mixins: [
    // ローダーmixin
    require('../mixins/loader').default,
    // モーダル
    require('../components/modal').default,
  ],
  data: () => ({
    records: [],
    productRoute: route.PRODUCT,
    productItemStructureRoute: route.productItemStructure,
    shopId: sessionStorage.getItem('shopId'),
    paginationData: {},
    topProductCategories: [],
    productCategories: [],
    inputSelectedProductCategoryId: null,
    inputSearchKeyword: '',
    inputSearchValidPeriodFrom: '',
    inputSearchValidPeriodTo: '',
  }),
  computed: {
    ...mapState({
      productListPage: state => state.pagenation.productListPage,
      searchKeyword: state => state.product.searchKeyword,
      searchValidPeriodFrom: state => state.product.searchValidPeriodFrom,
      searchValidPeriodTo: state => state.product.searchValidPeriodTo,
      selectedProductCategoryId: state => state.product.selectedProductCategoryId,
    }),
  },
  watch: {
    $route: {
      async handler() {
        this.inputSearchValidPeriodTo = this.searchValidPeriodTo
        this.inputSearchValidPeriodFrom = this.searchValidPeriodFrom
        await this.load()
        await this.fetchProductCategories()
      },
      immediate: true,
    },
    inputSelectedProductCategoryId(val) {
      this.inputSelectedProductCategoryId = val
      this.$store.commit('product/setSelectedProductCategoryId', val)
      this.$store.commit('pagenation/setProductListPage', 1)
      this.load()
    },
    inputSearchValidPeriodFrom(val) {
      this.$store.commit('product/setSearchValidPeriodFrom', val)
      this.$store.commit('pagenation/setProductListPage', 1)
      this.load()
    },
    inputSearchValidPeriodTo(val) {
      this.$store.commit('product/setSearchValidPeriodTo', val)
      this.$store.commit('pagenation/setProductListPage', 1)
      this.load()
    },
  },
  methods: {
    /**
     * ページ切り替え時の処理
     */
    async load(page = this.productListPage) {
      this.showLoader()
      try {
        this.inputSearchKeyword = this.searchKeyword
        this.inputSelectedProductCategoryId = this.selectedProductCategoryId
        const response = await ProductRepository.fetchIndex(
          this.shopId,
          page,
          this.inputSearchKeyword,
          1,
          this.inputSelectedProductCategoryId,
          this.inputSearchValidPeriodFrom,
          this.inputSearchValidPeriodTo
        )
        if (response.status !== httpStatus.OK) {
          this.$store.commit('error/setCode', response.status)
          await this.showErrorReadDataModal()
          return false
        }

        this.records = response.data.data
        this.paginationData = response.data
      } catch (e) {
        // データ読み込みエラーモーダル
        await this.showErrorReadDataModal()
        console.log(e)
      } finally {
        this.hideLoader()
      }
      return null
    },
    /**
     * 子商品カテゴリ一覧取得
     *
     * 絞り込み検索時に、再度この処理を実行しないために、load() とは別で処理する
     */
    async fetchProductCategories() {
      this.showLoader()
      try {
        const response = await ProductCategoryRepository.fetchChildList(this.shopId)

        if (response.status !== httpStatus.OK) {
          this.$store.commit('error/setCode', response.status)
          await this.showErrorReadDataModal()
          return false
        }

        this.productCategories = response.data.map(x => {
          return {
            id: x.id,
            value: x.name,
          }
        })
      } catch (e) {
        // データ読み込みエラーモーダル
        await this.showErrorReadDataModal()
        console.log(e)
      } finally {
        this.hideLoader()
      }
      return null
    },
    /**
     * 商品構成ボタン押下時の処理
     *
     * @param {Number} id 商品ID
     * @param {String} name 商品名
     */
    onProductItemStructure(id, name) {
      this.$store.commit('breadcrum/setSelectedProductId', id)
      this.$store.commit('breadcrum/setSelectedProductName', name)
      this.$router.push(`/${this.productRoute}/${id}/${this.productItemStructureRoute}`)
    },
    /**
     * ページネーション
     */
    getPaginationResults(page) {
      this.$store.commit('pagenation/setProductListPage', page)
      this.load(page)
    },
    /**
     * 検索ボタン押下時
     */
    search(val) {
      this.$store.commit('product/setSearchKeyword', val)
      this.$store.commit('pagenation/setProductListPage', 1)
      this.load()
    },
    /**
     * ヘルプボタン押下時
     */
    async onHelp() {
      const params = {
        content: '/images/product.png',
        isCarousel: false,
      }

      await this.showHelpModal(params)
    },
    // 商品をコピーして新規追加ボタン押下時
    async onAddCopy() {
      this.showLoader()
      try {
        const response = await ProductRepository.fetchList()

        if (response.status !== httpStatus.OK) {
          this.$store.commit('error/setCode', response.status)
          await this.showErrorReadDataModal()
          return false
        }

        const products = response.data.map(x => {
          return {
            id: x.id,
            value: x.name,
          }
        })

        const props = {
          products,
        }

        const selectedProductId = await this.showCreateProductForCopyModal(props)
        if (!selectedProductId) return null

        const apiParams = {
          id: selectedProductId,
        }
        const addProductResponse = await ProductRepository.storeCopy(apiParams)

        if (addProductResponse.status !== httpStatus.CREATED) {
          this.$store.commit('error/setCode', addProductResponse.status)
          await this.showFailuredSaveModal()
          return false
        }
        await this.showFinishedSaveModal()
        window.location.reload()
      } catch (e) {
        // データ読み込みエラーモーダル
        await this.showErrorReadDataModal()
        console.log(e)
      } finally {
        this.hideLoader()
      }
      return null
    },
  },
}
</script>
