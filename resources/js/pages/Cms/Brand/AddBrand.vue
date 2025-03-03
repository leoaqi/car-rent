<template>
    <div class="bg-white rounded-xl max-w-screen-md mx-auto py-4 border border-natural-200">
        <form @submit.prevent="submit" class="px-6">
            <div class="mb-4">
                <div class="text-center">
                    <h1 class="text-xl text-text-primary">{{ isEditing ? 'Edit' : 'Add New'}} Brand</h1>
                    <h1 class="text-sm text-text-secondary pt-3">{{ isEditing ? 'Edit a' : 'Create a new'}}  brand for content management
                        system
                    </h1>
                </div>
                <label class="block text-sm font-medium text-gray-700 mb-2 pt-3.5">
                    Brand Name
                </label>
                <input v-model="form.name" type="text"
                    class="w-full px-3 py-2 border border-natural-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500"
                    :class="{ 'border-red-500': form.errors.name }" placeholder="Enter brand name" />
                <div v-if="form.errors.name" class="text-red-500 text-xs mt-1">
                    {{ form.errors.name }}
                </div>
            </div>
        </form>

        <div class="horizontal-divider"></div>
        <div class="flex flex-col md:flex-row justify-center py-4 px-6 gap-4 mx-auto max-w-screen-xl">
            <ButtonForm title="Cancel" type="outline-border" class="w-full md:w-[232px]"
                @click="router.visit('/brand')" />
            <ButtonForm @click="submit" :title=" isEditing ? 'Edit Brand' : 'Add New Brand' " class="w-full md:w-[232px]" type="block" />
        </div>
    </div>
</template>

<script setup>
import { defineProps, defineOptions, computed } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import AuthanticateLayout from '../Layout/AuthanticateLayout.vue';
import ButtonForm from '../Components/ButtonForm.vue';

const props = defineProps({
    brand: {
        type: Object,
        default: null
    }
});

const isEditing = computed(() => !!props.brand);

defineOptions({
    layout: AuthanticateLayout
});

const form = useForm({
    name: props.brand?.name || ''
});

const submit = () => {
    if (isEditing.value) {
        form.put('/brand/' + props.brand.id);
    } else {
        form.post('/brand/add', {
            preserveScroll: true,
            onSuccess: () => {
                router.visit('/brand');
            },
            onError: () => {
                if (form.errors.name) {
                    form.errors.name = 'Brand name is required';
                }
            }
        });
    }
};
</script>