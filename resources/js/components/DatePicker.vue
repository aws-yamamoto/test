<template>
  <div class="form-group" :class="classVal">
    <label :for="id">{{ label }}</label>
    <input
      :id="id"
      type="date"
      class="form-control"
      :value="value | date"
      :disabled="disabled"
      @input="$emit('input', $event.target.value)"
    />
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
    id: {
      type: String,
      required: false,
      default: '',
    },
    value: {
      type: null,
      required: false,
      default: '2020-04-04T00:00:00',
    },
    classVal: {
      type: String,
      required: false,
      default: '',
    },
    disabled: {
      type: Boolean,
      required: false,
      default: false,
    },
  },
}
</script>
