<template>
  <transition name="modal">
    <div class="modal modal-mask" style="display: block">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">
              {{ title }}
            </h4>
          </div>
          <div class="modal-body">{{ content }}</div>
          <div class="modal-footer">
            <button
              v-for="(b, index) in buttons"
              ref="buttonElements"
              :key="index"
              type="button"
              :class="b.classes"
              @click="b.callback()"
            >
              {{ b.label }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  data: () => ({
    title: '',
    content: '',
    buttons: [],
  }),
}
</script>

<style scoped>
.modal-body {
  white-space: pre-wrap;
}
</style>
