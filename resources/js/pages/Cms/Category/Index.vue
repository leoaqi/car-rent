<template>
    <div class="flex flex-row justify-between items-center">
        <h1 class="font-medium text-xl">Master Data Category</h1>
        <ButtonAdd @click="router.visit('/category/add')">
            <h1 class="text-xs font-medium">+ Add New Category</h1>
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
                    <tr v-for="(category) in data.data" :key="category.id">
                        <td class="py-5 px-4 border-b border-natural-200 text-xs font-normal w-full">{{ category.name }}
                        </td>
                        <td class="py-5 px-4 border-b border-natural-200 text-xs font-normal ">
                            <div class="flex flex-row gap-2.5">
                                <img :src="icEdit" v-on:click="editCategory(category)" alt="" class="hover:cursor-pointer">
                                <img :src="icDelete" v-on:click="onShowModalDelete(category)" alt=""
                                    class="hover:cursor-pointer">
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <Pagination :data="data" />
    <ModalDelete v-model="showModalDelete" @handleDelete="handleDelete" title="Delete Category" 
        description="Are you sure want to delete this category? Please check carefully before
                delete" />
</template>

<script setup>
import { defineProps, ref } from 'vue';
import AuthanticateLayout from '../Layout/AuthanticateLayout.vue'
import ButtonAdd from '../Components/ButtonAdd.vue';
import icEdit from '../../../../../public/icons/ic_edit.svg';
import icDelete from '../../../../../public/icons/ic_delete.svg';
import Pagination from '../Components/Pagination.vue'
import ModalDelete from '../Components/ModalDelete.vue';
import { router } from '@inertiajs/vue3'
import {Toast} from '../../../utils/toast'

defineOptions({
    layout: AuthanticateLayout
})

const props = defineProps({
    data: Object
})

const toast = new Toast()

const showModalDelete = ref(false)
const selectCategory = ref(null);

const handleClose = () => {
    router.delete(`/category/${selectCategory.value.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            toast.success('Category deleted successfully')
            showModalDelete.value = false;
            selectCategory.value = null;
        },
    });
}

const handleDelete = () => {
    handleClose()
}

const editCategory = (category) => {
    router.visit(`/category/${category.id}/edit`)
}

const onShowModalDelete = (data) => {
    selectCategory.value = data
    showModalDelete.value = true
}
</script>