<template>
  <div>
    <ul>
      <li v-for="post in paginationData.data" :key="post.id">
        {{ post.title }}
      </li>
    </ul>
    <pagination
      :data="paginationData"
      :limit="2"
      :align="'center'"
      @pagination-change-page="changePaginationResults"
    >
      <span slot="prev-nav">&lt; 前へ</span>
      <span slot="next-nav">次へ &gt;</span>
    </pagination>
  </div>
</template>

<script>
export default {
  props: {
    paginationData: {
      type: Object,
      required: true,
      default: () => ({}),
    },
  },
  data: () => ({
    paginations: {},
  }),
  mounted() {
    this.paginations = this.paginationData
  },
  methods: {
    /**
     * ページネーション
     */
    changePaginationResults(page) {
      this.$emit('getPaginationResults', page)
      window.scrollTo(0, 0)
    },
  },
}
</script>

<style scoped>
li {
  list-style: none;
}
</style>
