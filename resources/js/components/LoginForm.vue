<template>
  <form class="text-center py-5 col-6 mx-auto" @submit.prevent="login">
    <p class="h4 mb-4">ログイン</p>

    <div v-if="loginErrors" class="text-danger text-left">
      <ul v-if="loginErrors.email">
        <li v-for="msg in loginErrors.email" :key="msg">{{ msg }}</li>
      </ul>
      <ul v-if="loginErrors.password">
        <li v-for="msg in loginErrors.password" :key="msg">{{ msg }}</li>
      </ul>
    </div>

    <!-- <div v-if="loginErrorMessages" class="text-danger text-left">
      <ul>
        <li v-for="msg in loginErrorMessages" :key="msg">{{ msg }}</li>
      </ul>
    </div> -->

    <input
      id="loginFormEmail"
      v-model="loginForm.email"
      type="email"
      class="form-control mb-4"
      placeholder="E-mail"
    />

    <input
      id="loginFormPassword"
      v-model="loginForm.password"
      type="password"
      class="form-control mb-4"
      placeholder="Password"
    />

    <div class="justify-content-around">
      <div>
        <p>※パスワードを忘れた場合は、システム管理者までお問い合わせください。</p>
      </div>
    </div>

    <button type="submit" class="btn btn-info btn-block my-4 text-white">
      ログイン
    </button>
  </form>
</template>

<script>
import { mapState } from 'vuex'
import route from '../config/route'

export default {
  mixins: [
    // ローダーmixin
    require('../mixins/loader').default,
  ],
  data: () => ({
    loginForm: {
      email: '',
      password: '',
    },
  }),
  computed: {
    ...mapState({
      apiStatus: state => state.auth.apiStatus,
      loginErrors: state => state.auth.loginErrorMessages,
    }),
  },
  created() {
    this.clearError()
  },
  methods: {
    async login() {
      this.showLoader()
      // authストアのloginアクション呼び出し
      await this.$store.dispatch('auth/login', this.loginForm)

      if (this.apiStatus) {
        // トップページに遷移
        this.$router.push(route.INFO)
        this.$store.commit('error/setCode', null)
      }
      this.hideLoader()
    },
    clearError() {
      this.$store.commit('auth/setLoginErrorMessages', null)
    },
  },
}
</script>
