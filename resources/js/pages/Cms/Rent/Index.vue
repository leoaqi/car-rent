<template>

    <Head>
        <title>Rent</title>
        <meta name="description" content="Brand">
    </Head>
    <div class="flex flex-row justify-between items-center">
        <h1 class="font-medium text-xl">Master Data Rent</h1>
    </div>
    <div class="border border-natural-200 px-4 py-3 bg-white mt-8 rounded-xl">
        <div class="overflow-x-auto">
            <Search hint="Search by name" v-model="search"  @search="handleSearch" />
            <table class="min-w-full bg-white border-none table-auto overflow-scroll w-full">
                <thead class="bg-primary-100 border-none">
                    <tr class="text-primary-500">
                        <th class="py-4 px-4 text-sm font-medium text-left">Name</th>
                        <th class="py-4 px-4 text-sm font-medium text-left">Car Name</th>
                        <th class="py-4 px-4 text-sm font-medium text-left">Car Brand</th>
                        <th class="py-4 px-4 text-sm font-medium text-left">Phone</th>
                        <th class="py-4 px-4 text-sm font-medium text-left">Type</th>
                        <th class="py-4 px-4 text-sm font-medium text-left">Start Date</th>
                        <th class="py-4 px-4 text-sm font-medium text-left">End Date</th>
                        <th class="py-4 px-4 text-sm font-medium text-left">Action</th>
                    </tr>
                </thead>
                <tbody class="py-4">
                    <tr v-if="data.data.length == 0">
                        <td colspan="7" class="py-5 px-4 text-xs font-normal text-center w-full">No Data</td>
                    </tr>
                    <tr v-for="(rent) in data.data" :key="rent.id">
                        <td class="py-5 px-4 border-b border-natural-200 text-xs font-normal ">{{ rent.name }}
                        </td>
                        <td class="py-5 px-4 border-b border-natural-200 text-xs font-normal ">{{ rent.car.name }}
                        </td>
                        <td class="py-5 px-4 border-b border-natural-200 text-xs font-normal ">{{ rent.car.brand.name }}
                        </td>
                        <td class="py-5 px-4 border-b border-natural-200 text-xs font-normal ">{{ rent.phone }}
                        </td>
                        <td class="py-5 px-4 border-b border-natural-200 text-xs font-normal capitalize">{{
                        rent.type.replace('-', ' ') }}
                        </td>
                        <td class="py-5 px-4 border-b border-natural-200 text-xs font-normal ">{{
                        $formatDate(rent.start_date) }}
                        </td>
                        <td class="py-5 px-4 border-b border-natural-200 text-xs font-normal ">{{
                        $formatDate(rent.end_date) }}
                        </td>
                        <td class="py-5 px-4 border-b border-natural-200 text-xs font-normal text-center">
                            <i class="ri-eye-line text-primary-500 hover:text-primary-200 hover:cursor-pointer"
                            v-on:click="showDetailModel(rent)"></i>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <Pagination :data="props.data" />
    <ModalDetail v-model="showDetail" :data="selectedRent"  />
</template>

<script setup>
import { Head, router } from '@inertiajs/vue3'
import AuthanticateLayout from '../Layout/AuthanticateLayout.vue'
import ModalDetail from './DetailRent.vue';
import Pagination from '../Components/Pagination.vue';
import Search from '../Components/SearchInput.vue';
import { ref } from 'vue'
defineOptions({
    layout: AuthanticateLayout
})

const props = defineProps({
    data: Object
})

const showDetail = ref(false)
const selectedRent = ref(null)
const search = ref('')

const showDetailModel = (data)=>{
    showDetail.value = true
    selectedRent.value = data
}

const handleSearch= ()=> {
    
    if(search.value === ''){
        router.get('/rent')
        return
    }
    router.get('/rent',{
        search: search.value
    }, {
        preserveState: true
    })
}
</script>