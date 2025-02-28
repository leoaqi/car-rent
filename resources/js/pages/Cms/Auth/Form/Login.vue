<template>
    <div class="w-full px-6 lg:px-10 xl:px-26 2xl:px-10 xl:mx-auto bg-base-white">
        <img :src="logoAqi" alt="logo aqi" class="w-[158px] h-[40px] object-cover mt-10 mb-20">
        <h2 class="text-3xl font-medium mb-2">Sign In to Your Account</h2>
        <h2 class="text-sm font-normal text-textScondary">Enter your registered email & password to sign in</h2>
        <div :class="[isError ? 'block' : 'hidden']" class="w-full mb-10 bg-error-50 p-4 rounded-[4px] mt-10 block">
            <p class="text-error-500 font-semibold">Error! <span class="font-normal">{{ errorMessage }}</span></p>
        </div>
        <form @submit.prevent="form.post('/login')">
            <div>
                <label for="email" class="block text-content font-medium mb-2 text-textPrimary mt-10">Email</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input type="email" id="email" v-model="form.email"
                        class="block w-full pr-10 pl-3 py-3 border-form sm:text-sm"
                        placeholder="Enter your email" />
                </div>
                <label for="password" class="block text-content font-medium mb-2 text-textPrimary mt-6">Password</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input :type="showPassword ? 'text' : 'password'" id="password" v-model="form.password"
                        class="block w-full pr-10 pl-3 py-3 border-form sm:text-sm"
                        placeholder="Enter your password" />
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer"
                        @click="togglePasswordVisibility">
                        <i v-if="showPassword" class="ri-eye-fill text-gray-400"></i>
                        <i v-if="!showPassword" class="ri-eye-off-fill text-gray-400"></i>
                    </div>
                </div>
            </div>
            <div class="flex flex-row space-x-6 items-center justify-between my-8">
                <label class="inline-flex items-center mt-2">
                    <input type="checkbox"
                        :class="['form-checkbox h-[14px] w-[14px] text-primary-500 rounded-[4px] border-natural-300']" />
                    <span :class="['ml-2 font-normal text-[12px] text-text-primary']">Remember me</span>
                </label>
                <Link href="/forget-password" class="text-primary-500 pt-3 text-[12px] hover:underline">Forget
                    Password?</Link>
            </div>
            <div class="w-full mb-10 relative">
                <div
                    class="bg-white rounded-lg shadow-[-1px_0_20px_-1px_rgba(0,0,0,0.1)] px-4 py-3 flex items-center gap-4 justify-between pr-4">
                    <div>
                        <label class="inline-flex items-center mt-2">
                            <input type="checkbox"
                                :class="['form-checkbox h-[14px] w-[14px] text-primary500 rounded-[4px] border-natural300 mb-0']" />
                            <span :class="['ml-2 font-normal text-[12px] text-textPrimary']">Prove that i’m not a
                                robot</span>
                        </label>
                    </div>
                    <!-- <img :src="captcha" alt="icon" class="w-[14px] h-[14px]"> -->
                </div>
                <div class="absolute rounded-tr-[6px] rounded-br-[6px] bg-primary500 w-[5px] h-auto inset-y-0 right-0">
                </div>
            </div>
            <!-- <input type="submit" value="Sign In" class="btnPrimary"> -->
        </form>
        <Button title="Sign In" @click="signIn" />
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import Button from '../../Components/Button.vue';
import logoAqi from '../../../../../../public/images/logoaqi.png'

const email = ref('')
const password = ref('')
const errorMessage = ref('')
const showPassword = ref(false)
const isError = ref(false)

const togglePasswordVisibility = computed(() => {
    showPassword.value = !showPassword.value
})

function signIn() {
    form.post('/login', {
        onError: (error)=> {
            console.log(error);
            
            isError.value = true
            errorMessage.value = error.message
            form.reset()
        }
    });
}

const form = useForm({
    email: email.value,
    password: password.value,
})

</script>