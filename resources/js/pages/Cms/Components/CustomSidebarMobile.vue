<template>
    <div class="w-full p-4">
        <img :src="logoaqi" alt="logo" class="!w-fit !object-contain !mb-6">
        <nav class="flex flex-col w-full">
            <template v-for="item in menuItems" :key="item.name">
                <Link :href="item.slug" @click="handleClick" :class="[
                'flex items-center gap-3 px-4 py-3 text-sm rounded-xl',
                {
                    '!bg-primary-500 !text-white': isActive(item.slug),
                    '!text-gray-700 hover:!bg-red-50 hover:!text-red-600': !isActive(item.slug)
                }
            ]">
                <i class="w-6 h-6" :class="[item.icon]" />
                <span>{{ item.name }}</span>
                </Link>
            </template>
        </nav>
    </div>

</template>

<script setup>
import logoaqi from '../../../../../public/images/logoaqi.png';
import logo from '../../../../../public/images/logo.png';
import { usePage, Link } from '@inertiajs/vue3'

const emit = defineEmits(['close']);

const handleClick = () => {
    emit('close');
};

const route = usePage()

const isActive = (slug) => {
    const currentPath = route.url;
    return currentPath.startsWith(slug);
};

const menuItems = [
    { name: 'Dashboard', slug: '/dashboard', icon: 'ri-apps-line' },
    { name: 'Brand', slug: '/brand', icon: 'ri-bnb-line' },
    { name: 'Category', slug: '/category', icon: 'ri-verified-badge-line' },
    { name: 'Car', slug: '/car', icon: 'ri-car-line' },
    { name: 'Rent', slug: '/rent', icon: 'ri-money-dollar-circle-line' },
    { name: 'Tourist Destination', slug: '/destination', icon: 'ri-road-map-line' },
    { name: 'Tourist Package', slug: '/tour', icon: 'ri-plane-line' },
    { name: 'Bookings', slug: '/booking', icon: 'ri-calendar-check-line' },
];
</script>