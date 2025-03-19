<template>
    <Head>
        <title>Data Booking Tour</title>
    </Head>
    <div class="flex flex-row justify-between items-center">
        <h1 class="font-medium text-xl">Data Booking Tour Package</h1>
    </div>
    <div class="border border-natural-200 px-4 py-3 bg-white mt-8 rounded-xl">
        <div class="overflow-x-auto">
            <div class="flex flex-col md:flex-row gap-3 mb-2 lg:mb-2">
                <Search hint="Search by name" v-model="search" @search="handleSearch" />
                <div class="mt-0 md:mt-0">
                    <select v-model="paymentStatus" @change="handleFilterChange"
                        class="border border-gray-300 rounded-lg px-3 py-3.5 text-sm w-full lg:w-fit">
                        <option value="">All Payment Status</option>
                        <option value="pending">Pending</option>
                        <option value="partial">Partial</option>
                        <option value="paid">Paid</option>
                        <option value="refunded">Refunded</option>
                    </select>
                </div>
                <div class="mt-2 md:mt-0 ">
                    <select v-model="bookingStatus" @change="handleFilterChange"
                        class="border border-gray-300 rounded-lg px-3 py-3.5 text-sm w-full lg:w-fit">
                        <option value="">All Booking Status</option>
                        <option value="completed">Completed</option>
                        <option value="pending">Pending</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <Button v-if="search || paymentStatus || bookingStatus" title="Reset" @click="resetFilters" class="h-12 max-w-28"/>
            </div>
            <div class="min-w-[1200px]">
                <table class="min-w-full bg-white border-none table-auto overflow-scroll w-full">
                    <thead class="bg-primary-100 border-none">
                        <tr class="text-primary-500">
                            <th class="py-4 px-4 text-sm font-medium text-center">Name</th>
                            <th class="py-4 px-4 text-sm font-medium text-center">Email</th>
                            <th class="py-4 px-4 text-sm font-medium text-center">Phone</th>
                            <th class="py-4 px-4 text-sm font-medium text-center">Package</th>
                            <th class="py-4 px-4 text-sm font-medium text-center">Travel Date</th>
                            <th class="py-4 px-4 text-sm font-medium text-center">Amount</th>
                            <th class="py-4 px-4 text-sm font-medium text-center">Payment Status</th>
                            <th class="py-4 px-4 text-sm font-medium text-center">Booking Status</th>
                            <th class="py-4 px-4 text-sm font-medium text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody class="py-4">
                        <tr v-if="data.data.length == 0">
                            <td colspan="6" class="py-5 px-4 text-xs font-normal text-center w-full">No Data</td>
                        </tr>
                        <tr v-for="(booking, index) in data.data" :key="booking.id">
                            <td class="py-5 px-4  text-xs font-normal"
                                :class="{ 'border-b border-natural-200': index !== data.data.length - 1 }">{{
                    booking.customer_name
                }}
                            </td>
                            <td class="py-5 px-4  text-xs font-normal text-center"
                                :class="{ 'border-b border-natural-200': index !== data.data.length - 1 }">{{
                    booking.customer_email }}
                            </td>
                            <td class="py-5 px-4  text-xs font-normal text-center"
                                :class="{ 'border-b border-natural-200': index !== data.data.length - 1 }">{{
                    booking.customer_phone }}
                            </td>
                            <td class="py-5 px-4  text-xs font-normal text-center"
                                :class="{ 'border-b border-natural-200': index !== data.data.length - 1 }">{{
                    booking.tour_package.name }}
                            </td>
                            <td class="py-5 px-4  text-xs font-normal text-center"
                                :class="{ 'border-b border-natural-200': index !== data.data.length - 1 }">{{
                    formatDate(booking.travel_date) }}
                            </td>
                            <td class="py-5 px-4  text-xs font-normal text-center"
                                :class="{ 'border-b border-natural-200': index !== data.data.length - 1 }">{{
                    formatToIDR(booking.total_amount) }}
                            </td>
                            <td class="py-5 px-4  text-xs font-normal capitalize text-center"
                                :class="{ 'border-b border-natural-200': index !== data.data.length - 1 }">{{
                    booking.payment_status }}
                            </td>
                            <td class="py-5 px-4  text-xs font-normal capitalize text-center"
                                :class="{ 'border-b border-natural-200': index !== data.data.length - 1 }">{{
                    booking.booking_status }}
                            </td>
                            <td class="py-5 px-4  text-xs font-normal text-center"
                                :class="{ 'border-b border-natural-200': index !== data.data.length - 1}">
                                <div class="flex flex-row items-center gap-2.5">
                                    <img v-if="booking.booking_status !== 'completed'" :src="icEdit" alt="" class="hover:cursor-pointer">
                                    <img v-if="booking.booking_status !== 'completed'" :src="icDelete" alt="" class="hover:cursor-pointer">
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <Pagination :data="props.data" />

</template>

<script setup>
import { router, Head } from '@inertiajs/vue3'
import { ref } from 'vue'
import AuthanticateLayout from '../Layout/AuthanticateLayout.vue'
import icEdit from '../../../../../public/icons/ic_edit.svg';
import icDelete from '../../../../../public/icons/ic_delete.svg';
import { formatToIDR, formatDate } from '../../../utils/format'
import Pagination from '../Components/Pagination.vue';
import Search from '../Components/SearchInput.vue';
import Button from '../Components/Button.vue'


defineOptions({
    layout: AuthanticateLayout
})

const props = defineProps({
    data: Object,
    filters: Object
})

console.log(props.data);


const search = ref(props.filters?.search || '')
const paymentStatus = ref(props.filters?.payment_status || '')
const bookingStatus = ref(props.filters?.booking_status || '')

const handleSearch = () => {
    if (search.value.trim() === '') {
        router.get('/booking', {
            payment_status: paymentStatus.value
        }, {
            preserveState: true,
            replace: true
        })
    } else {
        router.get('/booking', {
            search: search.value,
            payment_status: paymentStatus.value
        }, {
            preserveState: true
        })
    }
}

const handleFilterChange = () => {
    const params = {
        per_page: props.data.per_page
    };

    if (search.value) {
        params.search = search.value;
    }

    if (paymentStatus.value) {
        params.payment_status = paymentStatus.value;
    }

    if (bookingStatus.value) {
        params.booking_status = bookingStatus.value;
    }

    router.get('/booking', params, {
        preserveState: true,
        replace: true
    })
}

const resetFilters = () => {
    search.value = '';
    paymentStatus.value = '';
    bookingStatus.value = '';
    
    router.get('/booking', {
        per_page: props.data.per_page
    }, {
        preserveState: true,
        replace: true
    });
}

</script>