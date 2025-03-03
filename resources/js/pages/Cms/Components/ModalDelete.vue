<template>
    <Modal v-model="isOpen">
        <div class="bg-white rounded-lg shadow-xl w-full md:w-[500px]">
            <!-- Header -->
            <div class="bg-primary-500 text-white px-6 py-4 rounded-t-lg flex justify-between items-center">
                <h3 class="text-xl font-medium">{{ title }}</h3>
                <button @click="handleClose"
                    class="text-white hover:text-gray-200 transition-colors focus:outline-none
                        hover:cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Body -->
            <div class="px-6 py-4">
                <p class="text-sm text-textScondary">{{ description }}</p>
            </div>

            <div class="horizontal-divider"></div>

            <!-- Footer -->
            <div class="px-6 pb-4 flex justify-end gap-3">
                <button @click="handleClose" class="px-4 py-2 border border-primary-500 text-[16px] font-medium rounded-lg text-primary-500 hover:bg-gray-50 
                           transition-colors focus:outline-none focus:ring-2 focus:ring-primary500 focus:ring-offset-2
                           hover:cursor-pointer">
                    Cancel
                </button>
                <button @click="handleDelete" class="px-4 py-2 bg-primary-500 text-white text-[16px] font-medium rounded-lg hover:bg-primary-600 
                           transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2
                           hover:cursor-pointer">
                    Delete
                </button>
            </div>
        </div>
    </Modal>
</template>

<script setup>
import Modal from './Modal.vue'
import { defineEmits, defineProps, computed } from 'vue';

const props = defineProps({
    modelValue: {
        type: Boolean,
        required: true
    },
    title: String,
    description: String
})

const isOpen = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value)
})
const emit = defineEmits(['update:modelValue', 'handleDelete'])

const handleClose = () => {
    emit('update:modelValue', false)
}

const handleDelete = () => {
    emit('handleDelete');
}
</script>