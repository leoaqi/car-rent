<template>
    <div class="flex flex-row justify-between items-center">
        <h1 class="font-medium text-xl">Master Data Car</h1>
        <ButtonAdd>
            <h1 class="text-xs font-medium">+ Add New Car</h1>
        </ButtonAdd>
    </div>
    <div class="border border-natural-200 px-4 py-10 bg-white mt-8 rounded-xl">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border-none table-auto overflow-scroll w-full">
                <thead class="bg-primary-100 border-none">
                    <tr class="text-primary-500">
                        <th class="py-4 px-4 text-sm font-medium text-left">Name</th>
                        <th class="py-4 px-4 text-sm font-medium text-left">Brand</th>
                        <th class="py-4 px-4 text-sm font-medium text-left">Category</th>
                        <th class="py-4 px-4 text-sm font-medium text-left">Year</th>
                        <th class="py-4 px-4 text-sm font-medium text-left">Capacity</th>
                        <th class="py-4 px-4 text-sm font-medium text-left">Action</th>
                    </tr>
                </thead>
                <tbody class="py-4">
                    <tr v-for="(car) in data.data" :key="car.id">
                        <td class="py-5 px-4 border-b border-natural-200 text-xs font-normal">{{ car.name }}
                        </td>
                        <td class="py-5 px-4 border-b border-natural-200 text-xs font-normal">{{ car.brand.name }}
                        </td>
                        <td class="py-5 px-4 border-b border-natural-200 text-xs font-normal">{{ car.category.name }}
                        </td>
                        <td class="py-5 px-4 border-b border-natural-200 text-xs font-normal">{{ car.year }}
                        </td>
                        <td class="py-5 px-4 border-b border-natural-200 text-xs font-normal">{{ car.capacity }}
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

    <Pagination :data="data" />
</template>

<script setup>
import { defineProps } from 'vue';
import AuthanticateLayout from '../Layout/AuthanticateLayout.vue'
import ButtonAdd from '../Components/ButtonAdd.vue';
import icEdit from '../../../../../public/icons/ic_edit.svg';
import icDelete from '../../../../../public/icons/ic_delete.svg';
import Pagination from '../Components/Pagination.vue'

defineOptions({
    layout: AuthanticateLayout
})

const props = defineProps({
    data: Object
})

</script>