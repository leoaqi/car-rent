<template>

    <Head>
        <title>Brand</title>
        <meta name="description" content="Brand">
    </Head>
    <div class="flex flex-row justify-between items-center">
        <h1 class="font-medium text-xl">Master Data Brand</h1>
        <ButtonAdd @click="addNewBrand">
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
                                <img :src="icEdit" v-on:click="editBrand(brand)" alt="" class="hover:cursor-pointer">
                                <img :src="icDelete" v-on:click="onShowModalDelete(brand)" alt="" class="hover:cursor-pointer">
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <Pagination :data="brandData" />

    <ModalDelete v-model="showModalDelete" @handleDelete="handleDelete" title="Delete Brand" 
        description="Are you sure want to delete this brand? Please check carefully before
                delete" />
</template>

<script setup>
import { defineProps, ref } from 'vue';
import { Head ,router} from '@inertiajs/vue3'
import AuthanticateLayout from '../Layout/AuthanticateLayout.vue'
import ButtonAdd from '../Components/ButtonAdd.vue';
import icEdit from '../../../../../public/icons/ic_edit.svg';
import icDelete from '../../../../../public/icons/ic_delete.svg';
import Pagination from '../Components/Pagination.vue';
import ModalDelete from '../Components/ModalDelete.vue';
import {Toast} from '../../../utils/toast'

defineOptions({
    layout: AuthanticateLayout
})

const toast = new Toast()

const showModalDelete = ref(false)
const selectedBrand = ref(null);

const props = defineProps({
    brandData: Object
})

const addNewBrand = () => {
    router.visit('/brand/add');
};

const editBrand = (brand) => {
    router.visit(`/brand/${brand.id}/edit`);
};

const handleClose = () => {
    router.delete(`/brand/${selectedBrand.value.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            toast.success('Brand has been deleted')
            showModalDelete.value = false;
            selectedBrand.value = null;
        },
    });
}

const handleDelete = () => {
    handleClose()
}

const onShowModalDelete = (data) => {
    toast.success('Brand has been deleted')
    selectedBrand.value = data 
    showModalDelete.value = true
}
</script>