<template>
    <Head>
        <title>Master Data Tour Package</title>
    </Head>
    <div class="flex flex-row justify-between items-center">
        <h1 class="font-medium text-xl">Master Data Tour Package</h1>
        <ButtonAdd @click="router.visit('/tour/add')">
            <h1 class="text-xs font-medium">+ Add New Tour Package</h1>
        </ButtonAdd>
    </div>
    <div class="border border-natural-200 px-4 py-3 bg-white mt-8 rounded-xl">
        <div class="overflow-x-auto">
            <div class="mb-2">
                <Search hint="Search by name" v-model="search" @search="handleSearch" />
            </div>
            <table class="min-w-full bg-white border-none table-auto overflow-scroll w-full">
                <thead class="bg-primary-100 border-none">
                    <tr class="text-primary-500">
                        <th class="py-4 px-4 text-sm font-medium text-left">Name</th>
                        <th class="py-4 px-4 text-sm font-medium text-left">Duration</th>
                        <th class="py-4 px-4 text-sm font-medium text-left">Price</th>
                        <th class="py-4 px-4 text-sm font-medium text-left">Destinations</th>
                        <th class="py-4 px-4 text-sm font-medium text-left">Status</th>
                        <th class="py-4 px-4 text-sm font-medium text-left">Action</th>
                    </tr>
                </thead>
                <tbody class="py-4">
                    <tr v-if="data.data.length == 0">
                        <td colspan="6" class="py-5 px-4 text-xs font-normal text-center w-full">No Data</td>
                    </tr>
                    <tr v-for="(tour) in data.data" :key="tour.id">
                        <td class="py-5 px-4 border-b border-natural-200 text-xs font-normal">{{ tour.name }}
                        </td>
                        <td class="py-5 px-4 border-b border-natural-200 text-xs font-normal">{{ tour.duration_days }}
                            days
                        </td>
                        <td class="py-5 px-4 border-b border-natural-200 text-xs font-normal">{{ formatToIDR(tour.price)
                            }}
                        </td>
                        <td class="py-5 px-4 border-b border-natural-200 text-xs font-normal">{{
            tour.destination_list.length }} places
                        </td>
                        <td class="py-5 px-4 border-b border-natural-200 text-xs font-normal capitalize">{{ tour.status
                            }}
                        </td>
                        <td class="py-5 px-4 border-b border-natural-200 text-xs font-normal text-center">
                            <div class="flex flex-row gap-2.5">
                                <img :src="icEdit" alt="" v-on:click="editTourPackage(tour)"
                                    class="hover:cursor-pointer">
                                <img :src="icDelete" alt="" v-on:click="onShowModalDelete(tour)"
                                    class="hover:cursor-pointer">
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <Pagination :data="props.data" />
    <ModalDelete v-model="showModalDelete" @handleDelete="handleDelete" title="Delete Tour Package" 
        description="Are you sure want to delete this tour package? Please check carefully before
                delete" />
</template>

<script setup>
import AuthanticateLayout from '../Layout/AuthanticateLayout.vue'
import ButtonAdd from '../Components/ButtonAdd.vue';
import { router, Head } from '@inertiajs/vue3'
import Search from '../Components/SearchInput.vue';
import { ref } from 'vue'
import icEdit from '../../../../../public/icons/ic_edit.svg';
import icDelete from '../../../../../public/icons/ic_delete.svg';
import { formatToIDR } from '../../../utils/format'
import Pagination from '../Components/Pagination.vue';
import ModalDelete from '../Components/ModalDelete.vue';
import { Toast } from '../../../utils/toast'

defineOptions({
    layout: AuthanticateLayout
})

const props = defineProps({
    data: Object,
})

const toast = new Toast()
const search = ref('')
const selectedTour = ref(null)
const showModalDelete = ref(false)

const handleSearch = () => {
    if (search.value.trim() === '') {
        router.get('/tour', {}, {
            preserveState: true,
            replace: true
        })
    } else {
        router.get('/tour', {
            search: search.value
        }, {
            preserveState: true
        })
    }
}

const handleDelete = () => {
    router.delete(`/tour/${selectedTour.value.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            toast.success('Tour package has been deleted')
            showModalDelete.value = false;
            selectedTour.value = null;
        },
    });
}

const onShowModalDelete = (data) => {
    selectedTour.value = data
    showModalDelete.value = true
}

const editTourPackage = (data) => {
    router.visit(`/tour/edit/${data.id}`)
}
</script>