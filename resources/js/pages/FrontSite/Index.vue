<template>

    <Head>
        <title>Car Rent</title>
    </Head>
    <div class="bg-natural-400">
        <div :class="{ 'fixed top-0 left-0 right-0 z-50': isScrolled }">
            <Sidebar @filter="toogleFilter" :filter="selectedBrands.length || selectedCategories.length" />
        </div>
        <div class="flex flex-row gap-5 h-full">
            <!-- Filter -->
            <div :class="{
                'hidden': !isFilterVisible,
                'w-[300px] bg-white p-6 overflow-y-auto': true,
                'transform transition-transform duration-300 ease-in-out': true,
                '-translate-x-fll': !isFilterVisible,
                'translate-x-0': isFilterVisible
            }">
                <div class=" mb-8">
                    <h2 class="text-md font-medium  text-text-secondary  mb-2">Brands</h2>
                    <div class="space-y-2">
                        <div v-for="(count, brand) in brandCount" :key="brand" class="flex items-center">
                            <input type="checkbox" :disabled="count === 0" :id="brand" :value="brand"
                                v-model="selectedBrands" class="w-4 h-4 rounded accent-primary"
                                :class="{ 'cursor-pointer': count > 0, 'cursor-not-allowed': count === 0 }">
                            <label :for="brand" class="ml-2 text-text-primary" :class="{ 'opacity-50': count === 0 }">
                                {{ brand }} ({{ count }})
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <h2 class="text-md font-medium  text-text-secondary  mb-2">Categories</h2>
                    <div class="space-y-2">
                        <div v-for="(count, category) in categoryCount" :key="category" class="flex items-center">
                            <input type="checkbox" v-model="selectedCategories" :disabled="count === 0" :id="category"
                                :value="category" class="w-4 h-4 rounded accent-primary"
                                :class="{ 'cursor-pointer': count > 0, 'cursor-not-allowed': count === 0 }">
                            <label :for="category" class="ml-2  text-text-primary"
                                :class="{ 'opacity-50': count === 0 }">
                                {{ category }} ({{ count }})
                            </label>
                        </div>
                    </div>
                </div>
                <Button v-if="selectedBrands.length > 0 || selectedCategories.length > 0" title="Reset"
                    class="max-w-[240px]" @click="handleReset" />
            </div>
            <div>
                <!-- Section Hero -->
                <section class="bg-natural-400" :class="{
                    'mt-5': isFilterVisible
                }">
                    <div class="relative">
                        <img :src="prambanan" alt="" class="w-screen h-[300px] object-cover" :class="{
                            'rounded-lg': isFilterVisible,
                        }">
                        <div class="absolute opacity-80 bg-primary inset-0" :class="{
                            'rounded-lg': isFilterVisible,
                        }">
                        </div>
                        <div class="absolute inset-0 inset-x-24 inset-y-20">
                            <h1 class="text-white font-poppins font-bold text-3xl">Need a vehicle in Yogyakarta?</h1>
                            <h1 class="text-white font-poppins font-normal text-xl">The Most Complete Car Rental in
                                Yogyakarta
                            </h1>
                            <h1 class="text-white font-poppins font-normal text-sm mt-5">24-hour service with fast
                                response
                                without
                                any hassle and various car choices for self-drive & with professional driver. Your
                                satisfaction
                                is
                                our priority.!</h1>
                        </div>
                        <div
                            class="absolute bg-white px-6 py-4 -bottom-10 left-1/2 transform -translate-x-1/2 rounded-lg shadow-sm w-11/12">
                            <div class="flex flex-row gap-4 justify-evenly">
                                <div class="flex flex-row gap-3.5 items-center">
                                    <div
                                        class="rounded-full bg-primary w-10 h-10 flex items-center justify-center cursor-pointer hover:bg-primary-400 transition-colors">
                                        <i class="ri-whatsapp-line text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h1 class="text-xl text-primary font-poppins font-medium">On 24 Hour</h1>
                                        <h1 class="text-sm text-text-primary font-poppins font-normal">Service 24 Hour
                                        </h1>
                                    </div>
                                </div>
                                <div class="flex flex-row gap-3.5 items-center">
                                    <div
                                        class="rounded-full bg-primary w-10 h-10 flex items-center justify-center cursor-pointer hover:bg-primary-400 transition-colors">
                                        <i class="ri-time-line text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h1 class="text-xl text-primary font-poppins font-medium">On Time</h1>
                                        <h1 class="text-sm text-text-primary font-poppins font-normal">Delivery & Pickup
                                        </h1>
                                    </div>
                                </div>
                                <div class="flex flex-row gap-3.5 items-center">
                                    <div
                                        class="rounded-full bg-primary w-10 h-10 flex items-center justify-center cursor-pointer hover:bg-primary-400 transition-colors">
                                        <i class="ri-user-line text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h1 class="text-xl text-primary font-poppins font-medium">Staff friendly</h1>
                                        <h1 class="text-sm text-text-primary font-poppins font-normal">Driver & Staff
                                            Profesional</h1>
                                    </div>
                                </div>
                                <div class="flex flex-row gap-3.5 items-center">
                                    <div
                                        class="rounded-full bg-primary w-10 h-10 flex items-center justify-center cursor-pointer hover:bg-primary-400 transition-colors">
                                        <i class="ri-car-fill text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h1 class="text-xl text-primary font-poppins font-medium">Well maintained car
                                        </h1>
                                        <h1 class="text-sm text-text-primary font-poppins font-normal">Clean & Well
                                            Maintained
                                            Guarantee</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Section Car -->
                <section class="bg-natural-400 p-2 lg:p-7 font-poppins mt-16">
                    <div class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mx-auto">
                        <template v-for="car in data" :key="car.id">
                            <div class="bg-white rounded-xl py-4 px-4 shadow-xs cursor-pointer"
                                v-on:click="router.visit(`/car-detail/${car.id}`)">
                                <div class="flex flex-row justify-between items-center">
                                    <h1 class="text-xl font-bold font-poppins ">{{ car.name }}</h1>
                                    <i class="ri-heart-line text-2xl "></i>
                                </div>
                                <h1 class="text-sm text-natural-300 font-poppins">{{ car.brand.name }}</h1>
                                <div class="mt-2">
                                    <img :src="car.images[0] ? `/storage/${car.images[0].image}` : '/images/no-image.png'"
                                        :alt="car.name" class="w-full h-60 object-contain">
                                </div>
                                <div class="mt-4 flex flex-row justify-between">
                                    <div class="flex flex-row gap-1 items-center">
                                        <i class="ri-gas-station-fill text-natural-500 text-2xl"></i>
                                        <h1 class="text-md text-natural-500">{{ car.gasoline || 0 }}L</h1>
                                    </div>
                                    <div class="flex flex-row gap-1 items-center">
                                        <i class="ri-steering-fill text-natural-500 text-2xl"></i>
                                        <h1 class="text-md text-natural-500 capitalize">{{ car.type }}</h1>
                                    </div>
                                    <div class="flex flex-row gap-1 items-center">
                                        <i class="ri-group-fill text-natural-500 text-2xl"></i>
                                        <h1 class="text-md text-natural-500 capitalize font-poppins">{{ car.capacity }}
                                        </h1>
                                    </div>
                                </div>
                                <h1 class="text-md font-bold mt-3 text-text-primary font-poppins">{{
                                    formatCurrency(car.prices.find(price =>
                                        price.type ===
                                        car.type)?.price || 0)}} / <span
                                        class="text-md text-natural-500 font-normal font-poppins">day</span></h1>
                                <!-- <Button title="Rent Now" class="mt-3" @click="handleRent" /> -->
                            </div>
                        </template>
                    </div>
                </section>
            </div>
        </div>
        <Footer />
    </div>
</template>

<script setup>
import prambanan from '../../../../public/images/prambanan.jpg'
import { formatCurrency } from '../../utils/format'
import { Head, router, usePage } from '@inertiajs/vue3'
import { ref, onMounted, onUnmounted, watch } from 'vue'
import Sidebar from './Components/Sidebar.vue'
import Footer from './Components/Footer.vue'
import Button from '../Cms/Components/Button.vue'

const props = defineProps({
    data: Object,
    brandCount: Object,
    categoryCount: Object,
})

// console.log(props.data);
console.log(props.brandCount);
console.log(props.categoryCount);

const page = usePage()
const selectedBrands = ref([])
const selectedCategories = ref([])
const isFilterVisible = ref(false)

const toogleFilter = () => {
    isFilterVisible.value = !isFilterVisible.value
}

onMounted(() => {
    const urlParams = new URLSearchParams(window.location.search)
    const brandParams = []
    const categoryParams = []

    // Get all brand parameters
    for (const [key, value] of urlParams.entries()) {
        if (key.startsWith('brands[')) {
            brandParams.push(value)
        }
    }

    if (brandParams.length > 0) {
        selectedBrands.value = brandParams
    }

    // Get all category parameters
    for (const [key, value] of urlParams.entries()) {
        if (key.startsWith('categories[')) {
            categoryParams.push(value)
        }
    }

    if (categoryParams.length > 0) {
        selectedCategories.value = categoryParams
    }

    console.log('Brand Params:', brandParams)

})


watch([selectedBrands, selectedCategories], ([newBrands, newCategories]) => {
    console.log('Current URL:', page.url)
    console.log('New filters:', { brands: newBrands, categories: newCategories })
    router.get('/', {
        brands: newBrands,
        categories: newCategories
    }, {
        preserveState: true,
        preserveScroll: true,
        replace: true
    })
})

const handleReset = () => {
    selectedBrands.value = []
    selectedCategories.value = []
}

const isScrolled = ref(false)

const handleScroll = () => {
    isScrolled.value = window.scrollY > 0
}

onMounted(() => {
    window.addEventListener('scroll', handleScroll)
})

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll)
})

</script>