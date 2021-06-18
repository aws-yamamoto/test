<template>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li
        v-for="(item, index) in items"
        :key="`breadcrumb-${index}`"
        :class="index === items.length - 1 ? 'breadcrumb-item active' : 'breadcrumb-item'"
      >
        <a v-if="index !== items.length - 1" :href="item.href">
          {{ item.label }}
        </a>
        <span v-else>
          {{ item.label }}
        </span>
      </li>
    </ol>
  </nav>
</template>

<script>
export default {
  props: {
    items: {
      type: Array,
      required: true,
      default: () => {
        return []
      },
    },
  },
}
</script>
