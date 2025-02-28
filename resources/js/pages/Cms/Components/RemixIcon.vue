// resources/js/Components/RemixIcon.vue
<template>
  <i :class="`ri-${name} ${size ? 'ri-' + size : ''} ${className}`"></i>
</template>

<script setup>
defineProps({
  name: {
    type: String,
    required: true
  },
  size: {
    type: String,
    default: ''
  },
  className: {
    type: String,
    default: ''
  }
});
</script>