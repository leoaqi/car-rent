<template>

    <Head>
        <title>{{ data.name }}</title>
    </Head>
    <section class="bg-natural-400 py-10">
        <div class="max-w-screen-xl mx-auto px-4">
            <div class="flex flex-row">
                <!-- Detail Car -->
                <div class="flex flex-col gap-10 w-full">
                    <div class="p-4 mx-4 rounded-xl w-full ">
                        <!-- Main showcase card -->
                        <div class="flex justify-center mb-4 ">
                            <a-image :src="images[selectedImage]" :alt="images[selectedImage]"
                                class="w-fit h-fit object-contain" />
                        </div>

                        <!-- Thumbnail gallery -->
                        <div class="flex flex-row justify-center gap-3 items-center">
                            <div v-for="(image, index) in images" :key="index" @click="selectImage(index)"
                                class="w-[100px] h-[100px] items-center" :class="{
            'border-1 border-primary rounded-lg p-2': selectedImage === index,
            'border border-gray-200 rounded-lg overflow-hidden cursor-pointer hover:border-primary-400 transition-colors': selectedImage !== index
        }">
                                <img :src="image" :alt="image" class="object-contain w-full h-full" />
                            </div>
                        </div>
                    </div>
                    <div class="bg-white px-4 py-6 h-fit mx-4 my-7 rounded-xl">
                        <h1 class="font-poppins font-bold text-3xl mb-4">
                            {{ data.name }}
                        </h1>
                        <label class="text-base font-poppins text-text-secondary">
                            {{ data.description }}
                        </label>
                        <div class="grid grid-cols-2 mt-10">
                            <div class="flex flex-row gap-4">
                                <label class="text-md text-natural-300">Brand</label>
                                <label class="text-md text-text-primary">{{ data.brand.name }}</label>
                            </div>
                            <div class="flex flex-row gap-4">
                                <label class="text-md text-natural-300">Capacity</label>
                                <label class="text-md text-text-primary">{{ data.capacity }} Person</label>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 mt-5 mb-6">
                            <div class="flex flex-row gap-4">
                                <label class="text-md text-natural-300">Steering</label>
                                <label class="text-md text-text-primary capitalize">{{ data.type }}</label>
                            </div>
                            <div class="flex flex-row gap-4">
                                <label class="text-md text-natural-300">Gasoline</label>
                                <label class="text-md text-text-primary">{{ data.gasoline }} L</label>
                            </div>
                        </div>
                        <div class="flex flex-col mt-10">
                            <h1 class="text-xl mb-3">Prices</h1>
                            <div v-for="price in data.prices " class="mb-2">
                                <div class="grid grid-cols-2">
                                    <h1 class="capitalize text-md text-text-secondary">
                                        {{ price.type.replaceAll('-', ' ') }}</h1>
                                    <h1 class="text-md font-bold">{{ formatToIDR(price.price) }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Rent -->
                <div class="w-full">
                    <div class="bg-white p-5 rounded-xl my-2">
                        <h1 class="text-2xl font-medium">Billing Info</h1>
                        <p class="text-sm text-natural-300 mb-5">Please enter your billing info</p>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="flex flex-col w-full">
                                <label class="label">Name</label>
                                <input type="text" v-model="form.name" class="text-field" placeholder="Name" />
                            </div>
                            <div class="flex flex-col w-full">
                                <label class="label">Phone Number</label>
                                <input type="number" v-model="form.phone" class="text-field"
                                    placeholder="Phone Number" />
                            </div>
                            <div class="flex flex-col w-full">
                                <label class="label">Address</label>
                                <textarea type="text" v-model="form.address" class="text-field" placeholder="Address" />
                            </div>
                            <div class="flex flex-col w-full">
                                <label class="label">Town/City</label>
                                <textarea type="number" v-model="form.town" class="text-field"
                                    placeholder="Town or city" />
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-5 rounded-xl my-2">
                        <h1 class="text-2xl font-medium">Rental Info</h1>
                        <p class="text-sm text-natural-300 mb-5">Please enter your rental date</p>

                        <h1 class="text-md font-medium">Pickup</h1>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="flex flex-col w-full">
                                <label class="label">Location</label>
                                <input type="text" v-model="form.pickup_location" class="text-field"
                                    placeholder="Location" />
                            </div>
                            <div class="flex flex-col w-full">
                                <label class="label">Date Time</label>
                                <VueDatePicker text-input v-model="form.pickup_date" class="dp__main"
                                    :min-date="new Date()" format="dd-MM-yyyy" :enable-time-picker="false">
                                    <template #dp-input="{ value }">
                                        <input type="text" :value="value" class="text-field"
                                            placeholder="Select date" />
                                    </template>
                                </VueDatePicker>
                            </div>
                        </div>
                        <h1 class="text-md font-medium mt-4">Drop Off</h1>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="flex flex-col w-full">
                                <label class="label">Location</label>
                                <input type="text" v-model="form.dropoff_location" class="text-field"
                                    placeholder="Location" />
                            </div>
                            <div class="flex flex-col w-full">
                                <label class="label">Date Time</label>
                                <VueDatePicker text-input v-model="form.dropoff_date" class="dp__main"
                                    format="dd-MM-yyyy" :min-date="form.pickup_date || new Date()"
                                    :enable-time-picker="false">
                                    <template #dp-input="{ value }">
                                        <input type="text" :value="value" class="text-field"
                                            placeholder="Select date" />
                                    </template>
                                </VueDatePicker>
                            </div>
                            <div class="flex flex-col">
                                <h1 class="text-md font-medium mt-4">Driver</h1>
                                <div class="flex items-center gap-2">
                                    <input type="checkbox" v-model="form.driver" :disabled="!hasDriverOption"
                                        :class="{ 'opacity-50 cursor-not-allowed': !hasDriverOption }"
                                        class="accent-primary" />
                                    <label class="text-sm text-gray-700">
                                        With driver
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 flex justify-between items-center">
                            <h2 class="text-xl font-medium">Total Price:</h2>
                            <p class="text-xl font-bold text-primary">{{ formatToIDR(calculateTotalPrice) }}</p>
                        </div>

                        <CustomButton title="Rent Now" class="mt-5" @click="handleSubmit" />
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import FrontLayout from './Layout/FrontLayout.vue'
import { defineOptions, computed, ref, watch } from 'vue';
import { Head, router } from '@inertiajs/vue3'
import { formatToIDR, formatDateForDB, calculateDaysDifference } from '../../utils/format'
import CustomButton from '../Cms/Components/Button.vue'
import { useForm, usePage } from '@inertiajs/vue3'
import { Toast } from '../../utils/toast'

const page = usePage()
console.log('Current component:', page.component)

defineOptions({
    layout: FrontLayout
})
const props = defineProps({
    data: Object
});

const toast = new Toast()

const form = useForm({
    name: '',
    phone: '',
    address: '',
    town: '',
    pickup_location: '',
    pickup_date: '',
    dropoff_location: '',
    dropoff_date: '',
    driver: false,
    price: '',
    type: '',
    car_id: props.data.id
})

watch(() => form.pickup_date, (newValue) => {
    form.dropoff_date = newValue
})


console.log(props.data);

const images = computed(() => {
    return props.data.images.map(img => `/storage/${img.image}`);
});


const selectedImage = ref(0)

const hasDriverOption = computed(() => {
    return props.data.prices.some(p => p.type === 'with-driver');
});

// Function to change the selected image
const selectImage = (index) => {
    selectedImage.value = index
}

const calculateTotalPrice = computed(() => {
    if (!form.pickup_date || !form.dropoff_date) return 0;

    const days = calculateDaysDifference(form.pickup_date, form.dropoff_date);
    const selectedPrice = form.driver
        ? props.data.prices.find(p => p.type === 'with-driver')?.price
        : props.data.prices.find(p => p.type === props.data.type)?.price;

    return days * (selectedPrice || 0);
});

const handleSubmit = () => {
    form.pickup_date = formatDateForDB(form.pickup_date)
    form.dropoff_date = formatDateForDB(form.dropoff_date)
    form.type = form.driver ? 'with-driver' : props.data.type
    form.price = calculateTotalPrice.value
    
    form.post('/rent', {
        onSuccess: () => {
            toast.success('Rent request submitted successfully');
            router.visit('/');
        },
        onError: (errors) => {
            console.log(errors);

            if (Object.keys(errors).length > 0) {
                const key = Object.keys(errors)[0];
                const message = errors[key];
                toast.error(`${key}: ${message}`);
            } else {
                toast.error('Something went wrong');
            }
        }
    });

}
</script>

<style scoped>
.dp__main :deep(.dp__theme_light) {
    --dp-primary-color: #AD2026;
    --dp-primary-text-color: #fff;
}
</style>