<template>
  <div class="px-4 lg:px-8 py-4 bg-white w-full ml-[2px] shadow-xs">
    <div class="flex flex-row justify-between items-center">
      <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-2">
          <li v-for="(crumb, index) in breadcrumbs" :key="index" class="inline-flex items-center">
            <template v-if="index < breadcrumbs.length - 1">
              <Link :href="crumb.path" class="text-text-secondary text-xs font-normal hover:text-primary-500">
              {{ crumb.name }}
              </Link>
              <span class="mx-2 text-gray-500"><i class="ri-arrow-drop-right-line"></i></span>
            </template>
            <span v-else class="text-primary-500 text-xs font-semibold">
              {{ crumb.name }}
            </span>
          </li>
        </ol>
      </nav>

      <div class="flex flex-row gap-8 items-center hover:cursor-pointer" @click="logout">
        <img :src="icBell" alt="Notifications" class="w-3 h-3 lg:w-5  lg:h-5 object-cover">
        <div class="hidden lg:flex flex-row items-center gap-3">
          <img :src="icProfile1" alt="Profile" class="w-[36px] h-[36px] rounded-full object-cover">
          <h1 class="text-sm font-normal text-text-primary">Hi, Administrator</h1>
        </div>
        <i class="ri-menu-line flex w-5 h-5 lg:hidden"></i>
      </div>
    </div>
  </div>
</template>

<script setup>
import { usePage, useForm, Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import icBell from '../../../../../public/icons/ic_bell.svg';
import icProfile1 from '../../../../../public/icons/ic_profile_1.png';

const page = usePage();
const form = useForm();

function logout() {
  form.post('/logout');
}

const breadcrumbs = computed(() => {
  const cleanPath = page.url.split('?')[0]
  const path = cleanPath.split('/').filter(segment => {
    return Boolean(segment) && !segment.includes('per_page')
      && !segment.includes('page') && !segment.includes('query')
      && !segment.match(/^\d+$/)
  });
  const crumbs = [];
  let fullPath = '';

  // Build breadcrumbs based on current URL
  path.forEach((segment) => {
    fullPath += `/${segment}`;
    crumbs.push({
      name: segment.charAt(0).toUpperCase() + segment.slice(1),
      path: fullPath
    });
  });

  return crumbs;
});
</script>
