<template>

    <Head>
        <title>Brand</title>
        <meta name="description" content="Brand">
    </Head>
    <div class="flex flex-row justify-between items-center">
        <h1 class="font-medium text-xl">Master Data Brand</h1>
        <ButtonAdd>
            <h1 class="text-xs font-medium">+ Add New Brand</h1>
        </ButtonAdd>
    </div>
    <div class="border border-natural-200 px-4 py-10 bg-white mt-8 rounded-xl">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border-none table-auto overflow-scroll w-full">
                <thead class="bg-primary-100 border-none">
                    <tr class="text-primary-500">
                        <th class="py-4 px-4 text-sm font-medium text-left">Name</th>
                        <th class="py-4 px-4 text-sm font-medium text-left">Action</th>
                    </tr>
                </thead>
                <tbody class="py-4">
                    <tr v-for="(brand) in brandData.data" :key="brand.id">
                        <td class="py-5 px-4 border-b border-natural-200 text-xs font-normal w-full">{{ brand.name }}
                        </td>
                        <td class="py-5 px-4 border-b border-natural-200 text-xs font-normal ">
                            <div class="flex flex-row gap-2.5">
                                <img :src="icEdit" alt="" class="hover:cursor-pointer">
                                <img :src="icDelete" alt="" class="hover:cursor-pointer">
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- <div>
        <Pagination :paginator="brandData" />
    </div> -->

    <Pagination :data="brandData" />
</template>

<script setup>
import { defineProps, ref } from 'vue';
import { Head } from '@inertiajs/vue3'
import AuthanticateLayout from '../Layout/AuthanticateLayout.vue'
import { router } from '@inertiajs/vue3';
import ButtonAdd from '../Components/ButtonAdd.vue';
import icEdit from '../../../../../public/icons/ic_edit.svg';
import icDelete from '../../../../../public/icons/ic_delete.svg';
import Pagination from '../Components/Pagination.vue';

defineOptions({
    layout: AuthanticateLayout
})

const props = defineProps({
    brandData: Object
})

const perPage = ref(props.brandData.per_page.toString());

// Methods
function changePerPage() {
    router.get(props.brandData.path, { per_page: perPage.value }, {
        preserveState: true,
        preserveScroll: true,
        replace: true
    });
}
</script>