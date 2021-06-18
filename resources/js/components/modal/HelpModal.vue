<template>
  <transition name="modal">
    <div class="modal modal-mask" style="display: block">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header py-1">
            <h4 v-if="title" class="modal-title">
              {{ title }}
            </h4>
            <h4 v-else class="modal-title">
              <span class="text-primary">青枠部分</span>の編集を行います
            </h4>
          </div>
          <div class="modal-body text-center">
            <div v-if="isCarousel">
              <div id="carousel-1z" class="carousel slide" data-ride="carousel">
                <!-- <ol class="carousel-indicators">
                  <li
                    v-for="(item, index) in content"
                    :key="`carousel-${index}`"
                    data-target="#carousel-1z"
                    :data-slide-to="index"
                    :class="index === 0 ? 'active' : ''"
                  >
                  </li>
                </ol> -->
                <div class="carousel-inner" role="listbox">
                  <div
                    v-for="(item, index) in content"
                    :key="`carousel-item-${index}`"
                    :class="index === 0 ? 'carousel-item active' : 'carousel-item'"
                  >
                    <img class="w-50" :src="item.image" />
                    <p class="pt-3">{{ item.message }}</p>
                  </div>
                </div>
                <a
                  class="carousel-control-prev"
                  href="#carousel-1z"
                  role="button"
                  data-slide="prev"
                >
                  <i class="fas fa-chevron-left"></i>
                  <span class="sr-only">Previous</span>
                </a>
                <a
                  class="carousel-control-next"
                  href="#carousel-1z"
                  role="button"
                  data-slide="next"
                >
                  <i class="fas fa-chevron-right"></i>
                  <span class="sr-only">Next</span>
                </a>
              </div>
            </div>
            <div v-else>
              <img :src="content" class="mx-auto w-50" />
              <p v-if="message" class="pt-3">{{ message }}</p>
            </div>
          </div>
          <div class="modal-footer py-1">
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
    title: null,
    content: null,
    message: null,
    isCarousel: false,
    buttons: [],
  }),
}
</script>

<style scoped>
.fa-chevron-right:before,
.fa-chevron-left:before {
  color: #37474f;
}
</style>
