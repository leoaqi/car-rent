<template>
    <div class="min-h-screen flex items-center justify-center bg-natural-100">
        <div class="text-center">
            <h1 class="text-6xl font-bold text-primary">404</h1>
            <p class="text-2xl mt-4 text-gray-600">{{ message || 'Page Not Found' }}</p>
            <button @click="router.visit('/')" 
                class="mt-8 px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-600 transition-colors">
                Back to Home
            </button>
        </div>
    </div>
</template>

<script setup>
import { defineOptions } from 'vue'
import { router } from '@inertiajs/vue3'
import FrontLayout from './Layout/FrontLayout.vue'

defineOptions({
    layout: FrontLayout
})

defineProps({
    message: {
        type: String,
        default: ''
    }
})
</script>