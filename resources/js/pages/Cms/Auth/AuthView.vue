<template>
    <Head>
        <title>{{ pageTitle }}</title>
        <meta name="description" :content="pageDescription">
    </Head>
    <div class="bg-[#ffffff] min-h-screen flex flex-col lg:grid lg:grid-cols-2 p-4 md:p-8 lg:py-20 xl:px-[200px]">
        <div class="w-full flex justify-center items-center">
            <Login v-if="isLogin" />
            <ResetPassword v-if="isReset" />
            <ForgetPassword v-if="isForget" />
        </div>
        <div class="relative w-full hidden lg:flex lg:justify-start">
            <img :src="ilustration" alt="logo aqi" class="w-[680px] h-[900px] object-cover rounded-[30px]">
            <div class="absolute inset-x-0 xl:left-[0px]  xl:w-[600px] xl:justify-center xl:mx-1 bottom-[40px] flex justify-start">
                <h1 class="text-3xl font-semibold text-white px-14">
                    Welcome Back to Content Management System 👋
                </h1>
            </div>
        </div>
    </div>

</template>

<script setup>
import ResetPassword from './Form/ResetPassword.vue';
import Login from './Form/Login.vue';
import ForgetPassword from './Form/ForgetPassword.vue';
import ilustration from '../../../../../public/images/ilustasi.jpeg';
import { computed, ref } from 'vue';

import { usePage, Head } from '@inertiajs/vue3';


const page =usePage();

const isLogin = computed(() => page.url === '/login');
const isRegister = computed(() => page.url === '/register');
const isReset = computed(() => page.url === '/reset-password');
const isForget = computed(() => page.url === '/forget-password');

const pageTitle = computed(() => {
    if (isLogin.value) return 'Login';
    if (isReset.value) return 'Reset Password';
    if (isForget.value) return 'Forgot Password';
    return 'Car Rental CMS';
});

const pageDescription = computed(() => {
    if (isLogin.value) return 'Login to Car Rental Management System';
    if (isReset.value) return 'Reset your password';
    if (isForget.value) return 'Recover your account';
    return 'Car Rental Management System';
});
</script>