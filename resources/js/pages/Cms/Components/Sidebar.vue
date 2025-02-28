<template>
    <div :class="[isHovered ? 'w-screen lg:w-[264px] '  : 'w-screen lg:w-fit']" class="h-[70px] lg:h-screen bg-white shadow-lg transition-all duration-75"
        @mouseenter="isHovered = true" @mouseleave="isHovered = false">
        <!-- Logo -->
        <div class="hidden  lg:flex items-center justify-center w-full h-[48px] py-10">
            <img :src="[!isHovered ? logo : logoaqi]" alt="logoaqi" class="object-fill" :class="[
                { 'w-[126px] h-8': isHovered },
                { 'w-8 h-8': !isHovered },
            ]" />
        </div>  

        <!-- Navigation Items -->
        <nav class="pt-2 px-4 flex flex-row justify-between lg:flex-col w-full">
            <template v-for="item in menuItems" :key="item.name">
                <div class="relative">
                    <div class="absolute md:inset-y-1 lg:inset-y-1" :class="[
                        { 'w-full h-[40px] z-0 bg-primary-100 rounded-lg hidden lg:inline': isActive(item.slug) && isHovered },
                        { 'hidden z-0': !isActive(item.slug) }
                    ]"></div>

                    <Link :href="item.slug" :class="[
                        'relative flex items-center gap-1 z-10 text-xs pl-4 py-3 text-gray-700 my-1 mr-1 pr-4',
                        {'my-[5px]': !isHovered},
                        {
                            'bg-primary-500 text-white z-10 rounded-lg': isActive(item.slug),
                            'hover:bg-red-50 hover:text-red-600 hover:rounded-lg transition-colors': !isActive(item.slug)
                        }
                    ]">
                        <span >
                            <i  class="w-6 h-6" :class="[
                            item.icon,
                            
                        ]"/>
                        </span>
                        <span :class="[
                            'transition-all duration-300 hidden',
                            isHovered ? 'opacity-100 w-auto lg:inline' : 'hidden md:hidden'
                        ]">
                            {{ item.name }}
                        </span>
                    </Link>

                </div>
            </template>
        </nav>
    </div>
</template>

<script setup>
import logoaqi from '../../../../../public/images/logoaqi.png';
import logo from '../../../../../public/images/logo.png';
import {usePage, Link} from '@inertiajs/vue3'
import { ref } from 'vue';

const route = usePage()
const isHovered = ref(false);

const isActive = (slug) => {
    const currentPath = route.url;
    return currentPath.startsWith(slug);
};

const menuItems = [
    { name: 'Dashboard', slug: '/dashboard', icon: 'ri-apps-line' },
    { name: 'Brand', slug: '/brand', icon: 'ri-bnb-line' },
    { name: 'Category', slug: '/category', icon: 'ri-verified-badge-line' },
    { name: 'Car', slug: '/car', icon: 'ri-car-line' },
    // { name: 'Branch', slug: '/branch', icon: BranchIcon },
    // { name: 'User Management', slug: '/user-management', icon: UserIcon },
    // { name: 'Role Management', slug: '/role-management', icon: RoleIcon },
    // { name: 'Approval', slug: '/approval', icon: ApprovalIcon },
    // { name: 'Report', slug: '/report', icon: ReportIcon },
];
</script>