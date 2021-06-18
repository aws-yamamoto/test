<template>
  <div>
    <header v-if="isLogin" class="sticky-top">
      <Navbar />
    </header>
    <header v-else>
      <NotCertifiedNavbar />
      <RouterView />
    </header>
    <!-- <header>
      <RouterView />
    </header> -->
    <Sidebar v-if="isLogin" />
  </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex'
import httpStatus from './config/httpStatus'
import Sidebar from './components/Sidebar.vue'
import Navbar from './components/Navbar.vue'
import NotCertifiedNavbar from './components/NotCertifiedNavbar.vue'
import route from './config/route'
import { RepositoryFactory } from './repositories/RepositoryFactory'

const RefreshTokenRepository = RepositoryFactory.get('refreshTokens')

export default {
  components: {
    Sidebar,
    Navbar,
    NotCertifiedNavbar,
  },
  data: () => ({
    certifiedClass: 'col-md-12 ml-lg-auto col-lg-10 px-4',
    notCertifiedClass: 'col-md-6 px-4 mx-auto',
  }),
  computed: {
    ...mapState({
      apiStatus: state => state.auth.apiStatus,
    }),
    ...mapGetters({
      isLogin: 'auth/check',
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
    errorCode: {
      async handler(val) {
        if (val === httpStatus.UNAUTHORIZED) {
          console.log('リフレッシュトークン確認')
          await RefreshTokenRepository.refreshToken()
          this.$store.commit('auth/setUser', null)
          this.$router.push(`/${route.LOGIN}`)
        }
      },
      immediate: true,
    },
    $route: {
      async handler() {
        console.log('app.vue handler')
      },
      immediate: true,
    },
  },
  methods: {},
}
</script>

<style scoped>
[role='main'] {
  padding-top: 133px; /* 固定ナビゲーションバーの余白 */
}

@media (min-width: 768px) {
  [role='main'] {
    padding-top: 48px; /* 固定ナビゲーションバーの余白 */
  }
}
</style>
