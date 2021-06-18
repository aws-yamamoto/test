/**
 * ローダーを表示するミックスイン
 */

export default {
  data: () => ({
    loader: null,
  }),
  methods: {
    /**
     * ローダー表示
     */
    showLoader() {
      this.loader = this.$loading.show({
        container: null,
        color: '#2196F3',
        width: 100,
        height: 100,
      })
    },
    /**
     * ローダー非表示
     */
    hideLoader() {
      this.loader.hide()
    },
  },
}
