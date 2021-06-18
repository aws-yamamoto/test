<template>
  <div>
    <div class="d-flex align-items-center">
      <h2 class="mb-0">商品カテゴリ管理</h2>
      <button
        type="button"
        class="btn btn-light rounded-circle p-0 m-0 ml-3"
        style="width:2rem;height:2rem;"
        @click="onHelp()"
      >
        <i class="fas fa-info"></i>
      </button>
    </div>

    <Breadcrumb :items="breadcrumbData" />

    <SearchBox
      v-model="inputSearchKeyword"
      :placeholder="'商品カテゴリ名、商品カテゴリ名(表示用)'"
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

    <div class="text-right">
      <RouterLink
        class="btn btn-success text-right"
        :to="`/${productCategotyRoute}/${categoryId}/${productCategotyRoute}/new`"
      >
        追加
      </RouterLink>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">優先順</th>
          <th scope="col">商品カテゴリ名</th>
          <th scope="col">商品カテゴリ名(表示用)</th>
          <th scope="col">有効期間</th>
          <th scope="col">表示区分</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in records" :key="item.id">
          <td class="align-middle">{{ item.priority_order }}</td>
          <td class="align-middle">{{ item.name }}</td>
          <td class="align-middle">{{ item.subname }}</td>
          <td class="align-middle">
            {{ item.valid_period_from | date }} <br />~<br />
            {{ item.valid_period_to | date }}
          </td>
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
          <td class="align-middle">
            <button type="button" class="btn btn-primary" @click="onDetail(item.id, item.name)">
              詳細
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
import moment from 'moment'
import httpStatus from '../config/httpStatus'
import route from '../config/route'
import Paginate from '../components/Paginate.vue'
import Breadcrumb from '../components/Breadcrumb.vue'
import SearchBox from '../components/SearchBox.vue'
import { RepositoryFactory } from '../repositories/RepositoryFactory'

const ProductCategoryRepository = RepositoryFactory.get('productCategories')

export default {
  components: {
    Paginate,
    Breadcrumb,
    SearchBox,
  },
  mixins: [
    // ローダーmixin
    require('../mixins/loader').default,
    // モーダル
    require('../components/modal').default,
    // 優先順位更新
    require('../mixins/updatePriprityOrder').default,
  ],
  props: {
    categoryId: {
      type: String,
      required: false,
      default: '1',
    },
  },
  data: () => ({
    records: [],
    recordCount: 0,
    productCategotyRoute: route.PRODUCT_CATEGORY_LIST,
    shopId: sessionStorage.getItem('shopId'),
    paginationData: {},
    breadcrumbData: [],
    inputSearchKeyword: '',
    inputSearchValidPeriodFrom: '',
    inputSearchValidPeriodTo: '',
  }),
  computed: {
    ...mapState({
      productCategoryName: state => state.breadcrum.productCategoryName,
      productCategoryListPage: state => state.pagenation.productCategoryListPage,
      searchKeyword: state => state.productCategory.searchKeyword,
      searchValidPeriodFrom: state => state.productCategory.searchValidPeriodFrom,
      searchValidPeriodTo: state => state.productCategory.searchValidPeriodTo,
    }),
  },
  watch: {
    $route: {
      async handler() {
        this.inputSearchValidPeriodTo = this.searchValidPeriodTo

        if (this.searchValidPeriodFrom) {
          this.inputSearchValidPeriodFrom = this.searchValidPeriodFrom
        } else {
          this.inputSearchValidPeriodFrom = `${moment().year()}-${moment().month() +
            1}-${moment().date()}`
        }
        this.load()
      },
      immediate: true,
    },
    inputSearchValidPeriodFrom(val) {
      this.$store.commit('productCategory/setSearchValidPeriodFrom', val)
      this.$store.commit('pagenation/setProductCategoryListPage', 1)
      this.load()
    },
    inputSearchValidPeriodTo(val) {
      this.$store.commit('productCategory/setSearchValidPeriodTo', val)
      this.$store.commit('pagenation/setProductCategoryListPage', 1)
      this.load()
    },
  },
  methods: {
    /**
     * ページ切り替え時の処理
     */
    async load(page = this.productCategoryListPage) {
      this.showLoader()
      try {
        this.inputSearchKeyword = this.searchKeyword
        const response = await ProductCategoryRepository.fetchIndex(
          this.categoryId,
          this.shopId,
          page,
          this.inputSearchKeyword,
          this.inputSearchValidPeriodFrom,
          this.inputSearchValidPeriodTo
        )
        console.log(response.data.data)
        if (response.status !== httpStatus.OK) {
          this.$store.commit('error/setCode', response.status)
          await this.showErrorReadDataModal()
          return false
        }

        this.records = response.data.data
        this.paginationData = response.data
        this.recordCount = this.records.length
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
     * 詳細ボタン押下時の処理
     *
     * @param {Number} id 商品カテゴリID
     * @param {String} name 商品カテゴリ名
     */
    onDetail(id, name) {
      this.$store.commit('breadcrum/setSelectedProductCategoryName', name)
      this.$router.push(
        `/${route.PRODUCT_CATEGORY_LIST}/${this.categoryId}/${route.PRODUCT_CATEGORY}/${id}`
      )
    },
    /**
     * ページネーション
     */
    getPaginationResults(page) {
      this.$store.commit('pagenation/setProductCategoryListPage', page)
      this.load(page)
    },
    /**
     * 検索ボタン押下時
     */
    search(val) {
      this.$store.commit('productCategory/setSearchKeyword', val)
      this.$store.commit('pagenation/setProductCategoryListPage', 1)
      this.load()
    },
    /**
     * ヘルプボタン押下時
     */
    async onHelp() {
      const params = {
        content: '/images/product_category.png',
        isCarousel: false,
      }

      await this.showHelpModal(params)
    },
  },
}
</script>
