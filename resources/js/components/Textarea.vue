<template>
  <div class="form-group" :class="classVal">
    <label :for="id">{{ label }}</label>
    <textarea
      :id="id"
      class="form-control"
      :value="value"
      :placeholder="placeholder"
      :disabled="disabled"
      rows="3"
      @input="$emit('input', $event.target.value)"
    >
    </textarea>
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
      required: true,
    },
    value: {
      type: String,
      required: false,
      default: '',
    },
    classVal: {
      type: String,
      required: false,
      default: '',
    },
    placeholder: {
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
