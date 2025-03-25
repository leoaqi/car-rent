<template>
    <div>
        <div :class="{'fixed top-0 left-0 right-0 z-50': isScrolled}">
            <Sidebar />
        </div>
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
import { ref, onMounted, onUnmounted } from 'vue'

const page = usePage()
console.log('Current component:', page.component)

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