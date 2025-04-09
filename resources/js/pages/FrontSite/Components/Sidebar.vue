<template>
    <section class="bg-natural-400">
        <div class="bg-white px-11 lg:px-7 py-2 lg:py-4 flex flex-row border-b border-natural-200 items-center">
            <img :src="logo" alt="" class="w-16 h-16 object-contain cursor-pointer" v-on:click="backToRoute">
            <div class="pl-20">
                <SearchInput @filter="handleFilter" :filter="filter"/>
            </div>
            <div class="flex flex-row gap-2 ml-auto">
                <Link href="/tour"
                    :class="{ 'text-primary': $page.url.startsWith('/tour'), 'hover:text-primary': !$page.url.startsWith('/tour-packages') }">
                Tour Packages
                </Link>

            </div>
        </div>
    </section>
</template>

<script setup>
import SearchInput from './SearchInput.vue'
import logo from '../../../../../public/images/logo.png'
import { router, Link } from '@inertiajs/vue3'

const emit = defineEmits(['filter'])

const props = defineProps({
    filter: {
        type: Boolean,
        default: false
    }
})

const handleFilter = () => {
    console.log('handleFilter');
    emit('filter')
}

const backToRoute = () => {
    router.visit('/')
}
</script>