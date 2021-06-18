<template>
  <div class="form-inline active-cyan-4 mb-3">
    <!-- <input
      class="form-control form-control-sm w-50"
      type="text"
      :placeholder="placeholder"
      aria-label="Search"
      @keypress="onKeypress"
      @input="$emit('input', $event.target.value)"
    > -->
    <input
      v-model="inputValue"
      class="form-control form-control-sm w-50"
      type="text"
      :placeholder="placeholder"
      aria-label="Search"
      @keypress="onKeypress"
    />
    <button type="button" class="btn btn-info py-2 px-3 ml-0" @click="onSearch">
      <i class="fas fa-search" aria-hidden="true"></i>
    </button>
  </div>
</template>

<script>
export default {
  props: {
    placeholder: {
      type: String,
      required: false,
      default: '',
    },
    value: {
      type: String,
      required: false,
      default: '',
    },
  },
  data: () => ({
    inputValue: '',
  }),
  watch: {
    value: {
      async handler() {
        this.inputValue = this.value
      },
      immediate: true,
    },
  },
  methods: {
    onSearch() {
      this.$emit('search', this.inputValue)
    },
    onKeypress(e) {
      if (e.which === 13) {
        this.onSearch()
      }
    },
  },
}
</script>
