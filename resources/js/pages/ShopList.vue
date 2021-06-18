<template>
  <div>
    <h2>店舗一覧</h2>

    <SearchBox
      v-model="inputSearchKeyword"
      :placeholder="'店舗名'"
      :value="inputSearchKeyword"
      @search="search"
    />

    <div class="text-right">
      <RouterLink class="btn btn-success" to="/shop-detail/new">
        追加
      </RouterLink>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">店舗名</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(record, index) in records" :key="record.id">
          <td class="align-middle">{{ index + 1 }}</td>
          <td class="align-middle">{{ record.shop_name }}</td>
          <td class="align-middle">
            <RouterLink class="btn btn-primary text-white" :to="`/${shopDetail}/${record.id}`">
              詳細
            </RouterLink>
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
import { RepositoryFactory } from '../repositories/RepositoryFactory'

const ShopRepository = RepositoryFactory.get('shops')

export default {
  components: {
    Paginate,
    SearchBox,
  },
  mixins: [
    // ローダーmixin
    require('../mixins/loader').default,
    // モーダル
    require('../components/modal').default,
  ],
  data: () => ({
    records: [],
    shopRoute: route.shop,
    paginationData: {},
    inputSearchKeyword: '',
    shopDetail: route.SHOP_DETAIL,
  }),
  computed: {
    ...mapState({
      shopListPage: state => state.page,
      searchKeyword: state => state.shop.searchKeyword,
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
  methods: {
    /**
     * ページ切り替え時の処理
     */
    async load(page = this.shopListPage) {
      this.showLoader()
      console.log(this.searchKeyword)
      try {
        this.inputSearchKeyword = this.searchKeyword
        const response = await ShopRepository.fetchIndex(page, this.inputSearchKeyword)
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
     * ページネーション
     */
    getPaginationResults(page) {
      this.$store.commit('pagenation/setShopListPage', page)
      this.load(page)
    },
    /**
     * 検索ボタン押下時
     */
    search(val) {
      this.$store.commit('shop/setSearchKeyword', val)
      this.$store.commit('pagenation/setShopListPage', 1)
      this.load()
    },
  },
}
</script>
