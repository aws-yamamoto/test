<template>
  <div class="form-group" :class="classVal">
    <label v-if="label">{{ label }}</label>
    <select
      class="browser-default custom-select"
      :value="value"
      :disabled="disabled"
      @change="$emit('input', $event.target.value)"
    >
      <option value="">
        選択してください
      </option>
      <option v-for="item in items" :key="item.id" :value="item.id" :selected="value == item.id">
        {{ item.value }}
      </option>
    </select>
  </div>
</template>

<script>
export default {
  props: {
    label: {
      type: String,
      required: false,
      default: '',
    },
    classVal: {
      type: String,
      required: false,
      default: '',
    },
    items: {
      type: Array,
      required: false,
      default: () => {
        return []
      },
    },
    value: {
      type: null,
      default: null,
    },
    disabled: {
      type: Boolean,
      required: false,
      default: false,
    },
  },
}
</script>
