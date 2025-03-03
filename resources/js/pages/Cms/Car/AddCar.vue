<template>
    <div class="bg-white rounded-xl max-w-screen-md mx-auto py-4 border border-natural-200">
        <form class="px-6">
            <div class="mb-4">
                <div class="text-center">
                    <h1 class="text-xl text-text-primary">{{ isEditing ? 'Edit' : 'Add New' }} Car</h1>
                    <h1 class="text-sm text-text-secondary pt-3">{{ isEditing ? 'Edit a' : 'Create a new' }} car for
                        content management
                        system
                    </h1>
                </div>
                <label class="label">
                    Car Name
                </label>
                <input v-model="form.name" type="text" class="text-field"
                    :class="{ 'border-red-500': form.errors.name }" placeholder="Enter car name" />
                <div v-if="form.errors.name" class="text-red-500 text-xs mt-1">
                    {{ form.errors.name }}
                </div>
                <div class="flex flex-col lg:flex-row gap-2">
                    <div class="w-full">
                        <label class="label">Year</label>
                        <input type="number" v-model="form.year" class="text-field" placeholder="Enter year" />
                    </div>
                    <div class="w-full">
                        <label class="label">Capacity</label>
                        <input type="number" v-model="form.capacity" class="text-field" placeholder="Enter capacity" />
                    </div>
                    <div class="w-full">
                        <label class="label">CC</label>
                        <input type="number" v-model="form.cc" class="text-field" placeholder="Enter cc" />
                    </div>
                </div>
                <div class="flex flex-col lg:flex-row gap-1.5">
                    <div class="w-full">
                        <label class="label">Category</label>
                        <Dropdown v-model="selectedCategory" :options="categories" placeholder="Select cateogry"
                            header="Category" id="category" labelKey="name" valueKey="id" @change="updateCategoryId" />
                    </div>
                    <div class="w-full">
                        <label class="label">Brand</label>
                        <Dropdown v-model="selectedBrand" :options="brands" placeholder="Select brand" header="Brand"
                            id="brand" labelKey="name" valueKey="id" @change="updateBrandId" />
                    </div>
                </div>
                <label class="label">Prices</label>
                <div v-for="(price, index) in form.prices" :key="index"
                    class="flex flex-row gap-4 mb-3 items-start justify-center">
                    <div class="w-1/2">
                        <Dropdown v-model="price.type" :options="getAvailablePriceTypes(index)"
                            placeholder="Select price type" header="Price Type" :id="`price-type-${index}`"
                            labelKey="name" valueKey="id" />
                    </div>
                    <div class="w-1/2">
                        <input type="text" class="text-field" placeholder="Enter price amount"
                            :value="formatToIDR(price.amount)" @input="formatPrice($event, index)" />
                    </div>
                    <button type="button" @click="removePrice(index)" class="text-red-500 hover:text-red-700 pt-2">
                        <i class="ri-delete-bin-line text-xl"></i>
                    </button>
                </div>
                <button type="button" @click="addPrice"
                    class="text-primary-500 hover:text-primary-600 text-sm font-medium mt-2">
                    + Add Price
                </button>
                <label class="label">Car Images</label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-4">
                    <input type="file" multiple accept="image/*" class="hidden" ref="fileInput"
                        @change="handleFileChange" />
                    <div class="text-center" @click="$refs.fileInput.click()">
                        <div v-if="!previewImages.length" class="cursor-pointer">
                            <i class="ri-upload-cloud-2-line text-4xl text-gray-400"></i>
                            <p class="text-sm text-gray-500 mt-2">Click to upload images</p>
                        </div>
                        <div v-else class="grid grid-cols-3 gap-4">
                            <div v-for="(image, index) in previewImages" :key="index" class="relative">
                                <img :src="image" class="w-full h-32 object-cover rounded-lg">
                                <button @click.prevent="removeImage(index)"
                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600">
                                    <i class="ri-close-line"></i>
                                </button>
                            </div>
                            <div v-if="previewImages.length < 5"
                                class="border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center cursor-pointer h-32"
                                @click.stop="$refs.fileInput.click()">
                                <i class="ri-add-line text-2xl text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <label class="label">
                    Description
                </label>
                <textarea cols="30" v-model="form.description" rows="3" class="text-field"></textarea>
            </div>
        </form>
        <div class="w-full h-[1px] bg-natural200 my-3"></div>
        <div class="flex flex-col md:flex-row justify-center py-4 px-6 gap-4 mx-auto max-w-screen-xl">
            <ButtonForm title="Cancel" type="outline-border" class="w-full  md:w-[232px] " @click="back" />
            <ButtonForm title="Add New Car" class="w-full md:w-[254px]" @click="handleSubmit" />
        </div>
    </div>
</template>

<script setup>
import AuthanticateLayout from '../Layout/AuthanticateLayout.vue'
import { computed, defineProps, defineOptions, ref } from 'vue'
import { useForm, router } from '@inertiajs/vue3'
import Dropdown from '../Components/Dropdown.vue'
import ButtonForm from '../Components/ButtonForm.vue'
defineOptions({
    layout: AuthanticateLayout,
})

const props = defineProps({
    car: {
        type: Object,
        default: null
    },
    categories: {
        type: Object,
        default: null
    },
    brands: {
        type: Object,
        default: null
    }
});

const isEditing = computed(() => !!props.car);

const selectedCategory = ref(null)
const selectedBrand = ref(null)

const form = useForm({
    name: props.car?.name || '',
    prices: props.car?.prices || [{ type: null, amount: '' }],
    images: [],
    description: props.car?.description || '',
    cc: props.car?.cc || '',
    capacity: props.car?.capacity || '',
    year: props.car?.year || '',
    category_id: props.car?.category_id || null,
    brand_id: props.car?.brand_id || null,

});

const addPrice = () => {
    form.prices.push({ type: null, amount: '' });
};

const removePrice = (index) => {
    form.prices.splice(index, 1);
    if (form.prices.length === 0) {
        addPrice();
    }
};

const priceTypes = [
    { id: 1, name: 'Auto Matic', value: 'automatic' },
    { id: 2, name: 'Manual', value: 'manual'  },
    { id: 3, name: 'With Driver', value : 'with-driver' }
];

const getAvailablePriceTypes = (currentIndex) => {
    const selectedTypes = form.prices
        .map((price, index) => index !== currentIndex ? price.type?.id : null)
        .filter(Boolean);

    return priceTypes.filter(type => !selectedTypes.includes(type.id));
};
const formatToIDR = (value) => {
    if (!value) return '';
    const number = parseInt(value.toString().replace(/\D/g, ''));
    return isNaN(number) ? '' : new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(number);
};

const formatPrice = (event, index) => {
    const value = event.target.value.replace(/[^\d]/g, '');
    form.prices[index].amount = value;
};

const fileInput = ref(null);
const previewImages = ref([]);

const updateCategoryId = (category) => {
    form.category_id = category?.id || null;
};
const updateBrandId = (brand) => {
    form.brand_id = brand?.id || null;
};

const handleFileChange = (event) => {
    const files = Array.from(event.target.files);
    const maxFiles = 5 - previewImages.value.length;
    const selectedFiles = files.slice(0, maxFiles);

    selectedFiles.forEach(file => {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = (e) => {
                previewImages.value.push(e.target.result);
            };
            reader.readAsDataURL(file);
            form.images.push(file);
        }
    });
};

const removeImage = (index) => {
    event.preventDefault();
    event.stopPropagation();
    previewImages.value.splice(index, 1);
    form.images.splice(index, 1);
};

const back = ()=>{
    router.visit('/car');
}

const handleSubmit = () => {
    form.post('/car/add', {
        onSuccess: () => {
            router.visit('/car');
        },
        onError: (errors) => {
            form.errors = errors.errors;
        },
    });
}
</script>