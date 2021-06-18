<template>
  <div>
    <nav class="navbar navbar-dark primary-color justify-content-between">
      <!-- <nav class="navbar navbar-dark mb-2" style="background-color:#ffa76d;"> -->
      <a class="navbar-brand" href="/">テスト 管理システム</a>
      <form class="form-inline my-1">
        <div class="md-form form-sm my-0">
          <select
            v-model="shopId"
            class="browser-default custom-select"
            @change="changeStore($event.target.value)"
          >
            <option v-for="shop in shops" :key="shop.id" :value="shop.id" :selected="shopId">{{
              shop.shop_name
            }}</option>
          </select>
        </div>
        <p class="text-white mb-0 mx-3">{{ username }}</p>
        <button class="btn btn-light btn-md my-2 my-sm-0" @click.prevent="logout">
          ログアウト
        </button>
      </form>
    </nav>
  </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex'
import httpStatus from '../config/httpStatus'
import route from '../config/route'
import { RepositoryFactory } from '../repositories/RepositoryFactory'

const ShopRepository = RepositoryFactory.get('shops')

export default {
  mixins: [
    // ローダーmixin
    require('../mixins/loader').default,
    // モーダル
    require('./modal').default,
  ],
  data: () => ({
    shops: [],
    shopId: sessionStorage.getItem('shopId'),
    menus: [
      {
        title: 'メニュー',
        contents: [{ name: 'メニュー管理', url: route.INFO }],
      },
    ],
  }),
  computed: {
    ...mapState({
      apiStatus: state => state.auth.apiStatus,
    }),
    ...mapGetters({
      isLogin: 'auth/check',
      selectedShopId: 'shop/selectedShopId',
    }),
    isLogin() {
      return this.$store.getters['auth/check']
    },
    username() {
      return this.$store.getters['auth/username']
    },
    errorCode() {
      return this.$store.state.error.code
    },
  },
  watch: {
    $route: {
      async handler() {
        if (!this.errorCode) this.load()
      },
      immediate: true,
    },
  },
  methods: {
    async load() {
      try {
        const response = await ShopRepository.fetchList()
        if (response.status !== httpStatus.OK) {
          this.$store.commit('error/setCode', response.status)
          await this.showErrorReadDataModal()
          return false
        }
        this.shops = response.data
        if (!this.shopId) {
          this.shopId = 1
          sessionStorage.setItem('shopId', this.shopId)
        }
        this.$store.commit('shop/setSelectedShopId', this.shopId)
      } catch (e) {
        await this.showConfirmModal({
          title: 'データ読み込みエラー',
          content: 'データを読み込めませんでした。',
          buttons: [{ label: 'OK', classes: 'btn btn-primary' }],
        })
      }
      return null
    },
    changeStore(shopId) {
      const { path } = this.$route
      if (Number(shopId) !== Number(sessionStorage.getItem('shopId'))) {
        this.$router.push('/')
        if (path === '/') {
          window.location.reload()
        }
      }
      sessionStorage.setItem('shopId', shopId)
      this.$store.commit('shop/setSelectedShopId', this.shopId)
      // this.$store.commit('pagenation/setTopProductCategoryListPage', 1)
      this.$store.commit('pagenation/setProductCategoryListPage', 1)
      this.$store.commit('pagenation/setProductListPage', 1)
      this.$store.commit('pagenation/setProductItemStructureListPage', 1)
      // this.$store.commit('pagenation/setProductItemListPage', 1)
      // this.$store.commit('pagenation/setProductItemQuantityListPage', 1)
      // this.$store.commit('pagenation/setItemListPage', 1)
      // this.$store.commit('pagenation/setInfoItemListPage', 1)
      this.$store.commit('pagenation/setShopListPage', 1)
      // this.$store.commit('pagenation/setOrderListPage', 1)
      // this.$store.commit('pagenation/setOrderTimezoneListPage', 1)
      // this.$store.commit('pagenation/setUserListPage', 1)
      // this.$store.commit('pagenation/setVerificationDeviceListPage', 1)
      // this.$store.commit('pagenation/setAppVersionListPage', 1)

      // this.$store.commit('product/setSelectedTopProductCategoryId', null)
      // this.$store.commit('product/setSelectedProductCategoryId', null)
    },
    async logout() {
      this.showLoader()
      await this.$store.dispatch('auth/logout')

      if (this.apiStatus) {
        this.$router.push('/login')
      }
      this.hideLoader()
    },
  },
}
</script>

<style scoped>
/*
 * サイドバー
 */
.sidebar {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  z-index: 100; /* ナビゲーションバーの背面 */
  padding: 48px 0 0; /* ナビゲーションバーの高さ */
  box-shadow: inset -1px 0 0 rgba(0, 0, 0, 0.1);
}

.sidebar-sticky {
  position: relative;
  top: 0;
  height: calc(100vh - 48px);
  padding-top: 0.5rem;
  overflow-x: hidden;
  overflow-y: auto; /* ビューポートがコンテンツより短い場合、スクロール可能なコンテンツ */
}

@supports ((position: -webkit-sticky) or (position: sticky)) {
  .sidebar-sticky {
    position: -webkit-sticky;
    position: sticky;
  }
}

/*
 * ナビゲーションバー
 */
nav.navbar {
  z-index: 999;
}
</style>
