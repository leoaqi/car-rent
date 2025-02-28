<template>
    <div class="w-full px-6 lg:px-10 xl:px-26 2xl:px-10 xl:mx-auto bg-base-white">
        <img :src="logoAqi" alt="logo aqi" class="w-[158px] h-[40px] object-cover mt-10 mb-20">
        <div v-if="!isSuccess">
            <div>
                <h3 class="text-3xl font-medium">Forget Password?</h3>
                <p class="text-sm font-normal text-textScondary py-4">No worriess, we’ll send you the reset link to
                    reset your password. Please enter your email first.</p>
            </div>
            <form>
                <div>
                    <label for="email" class="block text-sm font-medium mb-2 text-textPrimary mt-14">Email</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input type="email" id="email" v-model="email"
                            class="block w-full pr-10 pl-3 py-3 border-form sm:text-sm"
                            placeholder="Enter your email" />
                    </div>
                </div>
            </form>
            <div class="pt-14">
                <Button title="Submit" @click="submit" />
                <Link href="/login"
                    class="flex text-body-3 my-6 font-medium text-primary500 justify-center items-center hover:underline hover:cursor-pointer">
                    Back to Sign In Page
                </Link>
            </div>
        </div>
        <div v-if="isSuccess">
            <div>
                <h3 class="text-heading-3 font-medium">Email Sent</h3>
                <p class="text-content font-normal text-textScondary py-4">No worriess, we’ll send you the reset link to
                    reset your password. Please enter your email first.</p>
            </div>
            <div class="pt-14">
                <Button title="Back to Sign In Page" @click="backToLogin" />
                <Link href="/reset-password"
                    class="flex text-body-3 my-6 font-medium text-primary500 justify-center items-center hover:underline">
                    Re-Send Email
                </Link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import Button from '../../Components/Button.vue';
import logoAqi from '../../../../../../public/images/logoaqi.png';
import { Link } from '@inertiajs/vue3';

const email = ref('')
const isSuccess = ref(false)

const submit = () => {
    if (email.value === '') {
        isSuccess.value = false
    } else {
        isSuccess.value = true
    }
}

const backToLogin = () => {
    // router.push('/login')
}
</script>