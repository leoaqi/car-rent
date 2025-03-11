<template>
    <Modal v-model="isOpen" title="Detail">
        <div class="bg-white rounded-lg shadow-xl p-4 lg:w-3xl">
            <div class="flex justify-end">
                <i class="ri-close-line hover:cursor-pointer hover:text-primary-500 w-4 h-4 object-cover" @click="handleClose"></i>
            </div>
            <div class="flex flex-col gap-4 w-full">
                <div class="flex flex-row gap-4 w-full">
                    <div class="flex flex-col w-1/2">
                        <label class="label">Name</label>
                        <input type="text" class="text-field-disabled"
                            :value="data.name" disabled />
                    </div>
                    <div class="flex flex-col w-1/2">
                        <label class="label">Phone</label>
                        <input type="text" class="text-field-disabled"
                            :value="data.phone" disabled />
                    </div>
                </div>
                <div class="flex flex-row gap-4 w-full">
                    <div class="flex flex-col w-1/2">
                        <label class="label">Car Name</label>
                        <input type="text" class="text-field-disabled"
                            :value="data.car.name" disabled />
                    </div>
                    <div class="flex flex-col w-1/2">
                        <label class="label">Car Brand</label>
                        <input type="text" class="text-field-disabled"
                            :value="data.car.brand.name" disabled />
                    </div>
                </div>
                <div class="flex flex-row gap-4 w-full">
                    <div class="flex flex-col w-1/2">
                        <label class="label">Car Category</label>
                        <input type="text" class="text-field-disabled"
                            :value="data.car.category.name" disabled />
                    </div>
                    <div class="flex flex-col w-1/2">
                        <label class="label">Type Rent</label>
                        <input type="text" class="text-field-disabled capitalize"
                            :value="data.type.replace('-',' ')" disabled />
                    </div>
                </div>
                <div class="flex flex-row gap-4 w-full">
                    <div class="flex flex-col w-1/2">
                        <label class="label">Start Date</label>
                        <input type="text" class="text-field-disabled"
                            :value="$formatDate(data.start_date)" disabled />
                    </div>
                    <div class="flex flex-col w-1/2">
                        <label class="label">End Date</label>
                        <input type="text" class="text-field-disabled capitalize"
                            :value="$formatDate(data.end_date)" disabled />
                    </div>
                </div>
                <div class="flex flex-row gap-4 w-full">
                    <div class="flex flex-col w-1/2">
                        <label class="label">Location Pickup</label>
                        <textarea type="text" class="text-field-disabled"
                            :value="data.location_pickup" disabled />
                    </div>
                    <div class="flex flex-col w-1/2">
                        <label class="label">Location Delivery</label>
                        <textarea type="text" class="text-field-disabled"
                            :value="data.location_delivery" disabled />
                    </div>
                </div>
                <div class="flex flex-row gap-4 w-full">
                    <div class="flex flex-col w-1/2">
                        <label class="label">Price</label>
                        <input type="text" class="text-field-disabled"
                            :value="$formatCurrency(data.price)" disabled />
                    </div>
                    <div class="flex flex-col w-1/2">
                        <label class="label">Payment Status</label>
                        <input type="text" class="text-field-disabled capitalize"
                            :value="data.payment_status" disabled />
                    </div>
                </div>
            </div>
        </div>
    </Modal>
</template>

<script setup>
import Modal from '../Components/Modal.vue'
import { defineEmits, defineProps, computed } from 'vue';

const props = defineProps({
    modelValue: {
        type: Boolean,
        required: true
    },
    data: Object,
    title: String,
    description: String
})

const isOpen = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value)
})
const emit = defineEmits(['update:modelValue'])

const handleClose = () => {
    emit('update:modelValue', false)
}
</script>