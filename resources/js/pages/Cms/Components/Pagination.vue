<template>
  <div class="flex items-center justify-end gap-4 mt-5">
    <div class="flex items-center gap-2">
      <span class="text-sm font-normal text-text-primary">Rows per page:</span>
      <div class="relative">

        <select v-model="perPage" @change="changePerPage" class="border p-1 rounded text-center">
          <option value="10">10</option>
          <option value="25">25</option>
          <option value="50">50</option>
          <option value="100">100</option>
        </select>
      </div>
    </div>

    <span class="text-sm font-normal text-text-primary">
      {{ data.from ?? 0 }} - {{ data.to ?? 0 }} of {{ data.total }}
    </span>

    <div class="flex gap-1.5">
      <a :href="data.prev_page_url || ''" class="px-1 py-1 "
        :class="{ 'pointer-events-none text-gray-400': !data.prev_page_url }">
        <i class="ri-arrow-left-s-line text-lg"></i>
      </a>

      <a :href="data.next_page_url || ''" class="px-1 py-1 "
        :class="{ 'pointer-events-none text-gray-400': !data.next_page_url }">
        <i class="ri-arrow-right-s-line text-lg"></i>
      </a>
    </div>
  </div>
</template>

<script setup>
import { defineProps, ref } from 'vue'
import {router} from '@inertiajs/vue3'

const props = defineProps({
  data: Object
})

const perPage = ref(props.data.per_page.toString() ?? 10);

function changePerPage() {
  const currentQuery = new URLSearchParams(window.location.search);
  const params = {};

  for (const [key, value] of currentQuery.entries()) {
    if (key !== 'per_page') {
      params[key] = value;
    }
  }
  
  params.per_page = perPage.value;

  router.get(props.data.path, params, {
    preserveState: true,
    preserveScroll: true,
    replace: true
  });
}
</script>