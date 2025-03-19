<template >
    <Head>
        <title>Destination</title>
    </Head>
    <div class="flex flex-row justify-between items-center">
        <h1 class="font-medium text-xl">Master Data Destination</h1>
        <ButtonAdd @click="router.visit('/destination/add')">
            <h1 class="text-xs font-medium">+ Add New Destination</h1>
        </ButtonAdd>
    </div>
    <div class="border border-natural-200 px-4 py-3 bg-white mt-8 rounded-xl">
        <div class="overflow-x-auto">
            <div class="mb-2">
                <Search hint="Search by name" v-model="search"  @search="handleSearch" />
            </div>
            <table class="min-w-full bg-white border-none table-auto overflow-scroll w-full">
                <thead class="bg-primary-100 border-none">
                    <tr class="text-primary-500">
                        <th class="py-4 px-4 text-sm font-medium text-left">Name</th>
                        <th class="py-4 px-4 text-sm font-medium text-left">Region</th>
                        <th class="py-4 px-4 text-sm font-medium text-left">Thumbnail</th>
                        <th class="py-4 px-4 text-sm font-medium text-left">Action</th>
                    </tr>
                </thead>
                <tbody class="py-4">
                    <tr v-if="data.data.length == 0">
                        <td colspan="6" class="py-5 px-4 text-xs font-normal text-center w-full">No Data</td>
                    </tr>
                    <tr v-for="(destination) in data.data" :key="destination.id">
                        <td class="py-5 px-4 border-b border-natural-200 text-xs font-normal">{{ destination.name }}
                        </td>
                        <td class="py-5 px-4 border-b border-natural-200 text-xs font-normal">{{ destination.region }}
                        </td>
                        <td class="py-5 px-4 border-b border-natural-200">
                            <div v-if="destination.images.length === 0"  class="flex flex-row items-center gap-2">
                                <i class="ri-image-fill"></i>
                                <label class="text-sm">No Image </label>
                            </div>
                            <img v-else :src="`/storage/destination/${destination.images[0].image_path.split('/').pop()}`"
                                class="w-6 h-6 object-contain rounded-lg" alt="Car thumbnail" />
                        </td>
                        <td class="py-5 px-4 border-b border-natural-200 text-xs font-normal text-center">
                            <div class="flex flex-row gap-2.5">
                                <img :src="icEdit" alt="" v-on:click="editDestination(destination)" class="hover:cursor-pointer">
                                <img :src="icDelete" alt="" v-on:click="onShowModalDelete(destination)"
                                    class="hover:cursor-pointer">
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <Pagination :data="data" />
    <ModalDelete v-model="showModalDelete" @handleDelete="handleDelete" title="Delete Destination" 
        description="Are you sure want to delete this destination? Please check carefully before
                delete" />
</template>

<script setup>
import AuthanticateLayout from '../Layout/AuthanticateLayout.vue'
import ButtonAdd from '../Components/ButtonAdd.vue';
import {router, Head} from '@inertiajs/vue3'
import {ref} from 'vue'
import Search from '../Components/SearchInput.vue';
import icEdit from '../../../../../public/icons/ic_edit.svg';
import icDelete from '../../../../../public/icons/ic_delete.svg';
import ModalDelete from '../Components/ModalDelete.vue';
import Pagination from '../Components/Pagination.vue'
defineOptions({
    layout: AuthanticateLayout
})

const props = defineProps({
    data: Object
})

const search = ref('')
const selectedDestination = ref(null)
const showModalDelete = ref(false)

const handleSearch = () =>{
    if(search.value === ''){
        router.get('/destination')
        return
    }
    router.get('/destination',{
        search: search.value
    }, {
        preserveState: true
    })
}

const handleDelete = () => {
    router.delete(`/destination/${selectedDestination.value.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            showModalDelete.value = false;
            selectedDestination.value = null;
        },
    });
}

const onShowModalDelete = (data) => {
    selectedDestination.value = data
    showModalDelete.value = true
}

const editDestination = (data)=>{
    router.visit(`/destination/${data.id}/edit`)
}
</script>