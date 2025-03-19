<template>
    <div>
        <Sidebar />
        <div>
            <slot />
        </div>
        <Footer />
    </div>
</template>

<script setup>
import Sidebar from '../Components/Sidebar.vue'
import Footer from '../Components/Footer.vue'
import { usePage, router } from '@inertiajs/vue3'

const page = usePage()
console.log('Current component:', page.component)
</script>