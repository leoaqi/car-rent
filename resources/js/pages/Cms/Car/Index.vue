<template>
    <div class="flex flex-row justify-between items-center">
        <h1 class="font-medium text-xl">Master Data Car</h1>
        <ButtonAdd @click="router.visit('/car/add')">
            <h1 class="text-xs font-medium">+ Add New Car</h1>
        </ButtonAdd>
    </div>
    <div class="border border-natural-200 px-4 py-3 bg-white mt-8 rounded-xl">
        <div class="overflow-x-auto">
            <Search hint="Search by name" v-model="search"  @search="handleSearch" />
            <table class="min-w-full bg-white border-none table-auto overflow-scroll w-full">
                <thead class="bg-primary-100 border-none">
                    <tr class="text-primary-500">
                        <th class="py-4 px-4 text-sm font-medium text-left">Name</th>
                        <th class="py-4 px-4 text-sm font-medium text-left">Brand</th>
                        <th class="py-4 px-4 text-sm font-medium text-left">Category</th>
                        <th class="py-4 px-4 text-sm font-medium text-center">Year</th>
                        <th class="py-4 px-4 text-sm font-medium text-center">Capacity</th>
                        <th class="py-4 px-4 text-sm font-medium text-left">Thumbnail</th>
                        <th class="py-4 px-4 text-sm font-medium text-left">Action</th>
                    </tr>
                </thead>
                <tbody class="py-4">
                    <tr v-if="data.data.length == 0">
                        <td colspan="6" class="py-5 px-4 text-xs font-normal text-center w-full">No Data</td>
                    </tr>
                    <tr v-for="(car) in data.data" :key="car.id">
                        <td class="py-5 px-4 border-b border-natural-200 text-xs font-normal">{{ car.name }}
                        </td>
                        <td class="py-5 px-4 border-b border-natural-200 text-xs font-normal">{{ car.brand.name }}
                        </td>
                        <td class="py-5 px-4 border-b border-natural-200 text-xs font-normal">{{ car.category.name }}
                        </td>
                        <td class="py-5 px-4 border-b border-natural-200 text-xs font-normal text-center">{{ car.year }}
                        </td>
                        <td class="py-5 px-4 border-b border-natural-200 text-xs font-normal text-center">{{ car.capacity }}
                        </td>
                        <td class="py-5 px-4 border-b border-natural-200">
                            <img :src="car.images && car.images.length > 0 ? `/storage/car/${car.images[0].image.split('/').pop()}` : '/images/no-image.png'"
                                class="w-16 h-16 object-contain rounded-lg" alt="Car thumbnail" />
                        </td>
                        <td class="py-5 px-4 border-b border-natural-200 text-xs font-normal ">
                            <div class="flex flex-row gap-2.5">
                                <img :src="icEdit" alt="" v-on:click="router.visit(`/car/${car.id}/edit`)" class="hover:cursor-pointer">
                                <img :src="icDelete" v-on:click="onShowModalDelete(car)" alt=""
                                    class="hover:cursor-pointer">
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <Pagination :data="data" />
    <ModalDelete v-model="showModalDelete" @handleDelete="handleDelete" title="Delete Car" description="Are you sure want to delete this car? Please check carefully before
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
import Search from '../Components/SearchInput.vue';
import {Toast} from '../../../utils/toast'

defineOptions({
    layout: AuthanticateLayout
})

const props = defineProps({
    data: Object
})

const toast = new Toast()

const showModalDelete = ref(false)
const selectedCar = ref(null);
const search = ref('')

const onShowModalDelete = (data) => {
    selectedCar.value = data
    showModalDelete.value = true
}

const handleDelete = () => {
    router.delete(`/car/${selectedCar.value.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            console.log('Car has been deleted');
            
            toast.success('Car has been deleted')
            showModalDelete.value = false;
            selectedCar.value = null;
        },
    });
}

const handleSearch= ()=> {
    console.log(search.value.length);
    
    if(search.value === ''){
        router.get('/car')
        return
    }
    router.get('/car',{
        search: search.value
    }, {
        preserveState: true
    })
}

</script>