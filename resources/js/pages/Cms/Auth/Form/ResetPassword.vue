<template>
    <div class="w-full px-4 md:px-6 lg:px-4 xl:px-26 2xl:px-10 mx-auto bg-base-white">
        <img :src="logoAqi" alt="logo aqi" class="w-[158px] h-[40px] object-cover mt-10 mb-20 ">
        <div v-if="!isSuccess">
            <h2 class="text-heading-3 font-medium">Create New Password?</h2>
            <h2 class="text-content font-normal text-textScondary">Enter your new password</h2>
            <form>
                <!-- Password -->
                <div class="mb-4 mt-10">
                    <label for="password" class="block text-content font-medium mb-2 text-textPrimary">New
                        Password</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input :type="showPassword ? 'text' : 'password'" id="password" v-model="password"
                            class="block w-full pr-10 pl-3 py-3 border-form sm:text-sm"
                            placeholder="********" />
                        <!-- Ikon Mata dari Remix Icon -->
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer"
                            @click="togglePasswordVisibility">
                            <RiEyeFill v-if="showPassword" class="text-gray-400" />
                            <RiEyeOffFill v-if="!showPassword" class="text-gray-400" />
                        </div>
                    </div>

                    <!-- Checkbox -->
                    <div class="flex flex-col mb-10 mt-4">
                        <label class="inline-flex items-center mt-2">
                            <input type="checkbox" v-model="isValidLength" :disabled="true"
                                :class="['form-checkbox h-[14px] w-[14px] text-primary500 rounded-[4px]', !isValidLength && password.trim().length > 0 ? 'border-error500' : 'border-natural300']" />
                            <span
                                :class="['ml-2 text-gray-700 font-normal text-[12px]', !isValidLength && password.trim().length > 0 ? 'text-primary500' : 'text-textPrimary']">Between
                                8 - 12 letter</span>
                        </label>
                        <label class="inline-flex items-center mt-2">
                            <input type="checkbox" v-model="isValidUpperNLower" :disabled="true"
                                :class="['checkbock', !isValidUpperNLower && password.trim().length > 0 ? 'border-error500' : 'border-natural300']" />
                            <span
                                :class="['ml-2 text-gray-700 font-normal text-[12px]', !isValidUpperNLower && password.trim().length > 0 ? 'text-primary500' : 'text-textPrimary']">At
                                least include 1 uppercase and
                                lowercase letter</span>
                        </label>
                        <label class="inline-flex items-center mt-2">
                            <input type="checkbox" v-model="isValidNumber" :disabled="true"
                                :class="['checkbock', !isValidNumber && password.trim().length > 0 ? 'border-error500' : 'border-natural300']" />
                            <span
                                :class="['ml-2 text-gray-700 font-normal text-[12px]', !isValidNumber && password.trim().length > 0 ? 'text-primary500' : 'text-textPrimary']">At
                                least include 1 number</span>
                        </label>
                        <label class="inline-flex items-center mt-2">
                            <input type="checkbox" v-model="isValidSpecialChar" :disabled="true"
                                :class="['checkbock accent-primary-500', !isValidSpecialChar && password.trim().length > 0 ? 'border-error-500' : 'border-natural-300']" />
                            <span
                                :class="['ml-2 text-gray-700 font-normal text-[12px]', !isValidSpecialChar && password.trim().length > 0 ? 'text-primary500' : 'text-textPrimary']">At
                                least include 1 special character or
                                symbol (.,!@#$%^&*=)</span>
                        </label>
                    </div>
                </div>

                <!-- Konfirmasi Password -->
                <div class="mb-10">
                    <label for="confirmPassword" class="block text-content font-medium mb-2 text-textPrimary">Re-Enter
                        Password</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input :type="showPasswordConfirm ? 'text' : 'password'" id="passwordconfirm"
                            v-model="confirmPassword"
                            class="block w-full pr-10 pl-3 py-3 border-form sm:text-sm"
                            placeholder="Re-type your password" />
                        <!-- Ikon Mata dari Remix Icon -->
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer"
                            @click="togglePasswordConfirmVisibility">
                            <RiEyeFill v-if="showPasswordConfirm" class="text-gray-400" />
                            <RiEyeOffFill v-if="!showPasswordConfirm" class="text-gray-400" />
                        </div>
                    </div>
                </div>

            </form>
            <Button @click="handleSubmit" title="Reset Password" />
            <Link href="/login"
                class="flex text-body-3 my-6 font-medium text-primary500 justify-center items-center hover:underline">
                Back to Sign In Page
            </Link>
        </div>
        <div v-if="isSuccess" class="pt-28">
            <div>
                <h3 class="text-heading-3 font-medium">Change Password Success</h3>
                <p class="text-content font-normal text-textScondary py-4">Your password has been change successfully. Try sign in again</p>
            </div>
            <div class="pt-14">
                <Button title="Sign In" @click="backToLogin" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import Button from '../../Components/Button.vue';
import logoAqi from '../../../../../../public/images/logoaqi.png';
import { Link } from '@inertiajs/vue3';

// const router = useRouter()
const password = ref('')
const showPassword = ref(false)
const showPasswordConfirm = ref(false)
const confirmPassword = ref('')
const isSuccess = ref(false)

const togglePasswordVisibility = computed(() => {
    showPassword.value = !showPassword.value
})

const togglePasswordConfirmVisibility = computed(() => {
    showPasswordConfirm.value = !showPasswordConfirm.value
})

const regex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*(),.?":{}|<>]).{8,12}$/
const regexUpperNLower = /^(?=.*[A-Z])(?=.*[a-z])/
const regexNumber = /\d/
const regexLength = /^.{8,12}$/
const regexSpecialChar = /[!@#$%^&*(),.?":{}|<> ]/

const isValidLength = computed(() => {
    return regexLength.test(password.value)
})

const isValidNumber = computed(() => {
    return regexNumber.test(password.value)
})
const isValidSpecialChar = computed(() => {
    return regexSpecialChar.test(password.value)
})

const isValidUpperNLower = computed(() => {
    return regexUpperNLower.test(password.value)
})

const isPasswordValid = computed(() => {
    console.log('password', password.value);

    console.log(regex.test(password.value));
    return regex.test(password.value)
})

function handleSubmit() {
    if (regex.test(password.value) && password.value === confirmPassword.value) {
        isSuccess.value = true;
    } else {
        isSuccess.value = false
    }
}

const backToLogin = ()=>{
    // router.push('/login')
}
</script>

<style scoped>
@reference '../../../../../../css/app.css';

.checkbock{
    @apply h-[14px] w-[14px] text-primary-500 rounded-[4px]
}
</style>