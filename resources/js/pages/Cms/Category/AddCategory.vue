<template>
    <div class="bg-white rounded-xl max-w-screen-md mx-auto py-4 border border-natural-200">
        <form @submit.prevent="submit" class="px-6">
            <div class="mb-4">
                <div class="text-center">
                    <h1 class="text-xl text-text-primary">{{ isEditing ? 'Edit' : 'Add New'}} Category</h1>
                    <h1 class="text-sm text-text-secondary pt-3">{{ isEditing ? 'Edit a' : 'Create a new'}}  category for content management
                        system
                    </h1>
                </div>
                <label class="block text-sm font-medium text-gray-700 mb-2 pt-3.5">
                    Category Name
                </label>
                <input v-model="form.name" type="text"
                    class="text-field"
                    :class="{ 'border-red-500': form.errors.name }" placeholder="Enter category name" />
                <div v-if="form.errors.name" class="text-red-500 text-xs mt-1">
                    {{ form.errors.name }}
                </div>
            </div>
        </form>

        <div class="horizontal-divider"></div>
        <div class="flex flex-col md:flex-row justify-center py-4 px-6 gap-4 mx-auto max-w-screen-xl">
            <ButtonForm title="Cancel" type="outline-border" class="w-full md:w-[232px]"
                @click="router.visit('/category')" />
            <ButtonForm @click="submit" :title=" isEditing ? 'Edit Category' : 'Add New Category' " class="w-full md:w-[232px]" type="block" />
        </div>
    </div>
</template>

<script setup>
import { defineProps, defineOptions, computed } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import AuthanticateLayout from '../Layout/AuthanticateLayout.vue';
import ButtonForm from '../Components/ButtonForm.vue';
import { Toast } from '../../../utils/toast'

const props = defineProps({
    category: {
        type: Object,
        default: null
    }
});

const isEditing = computed(() => !!props.category);

defineOptions({
    layout: AuthanticateLayout
});

const toast = new Toast();

const form = useForm({
    name: props.category?.name || ''
});

const submit = () => {
    if(!form.name) {
        form.errors.name = 'Category name is required';
        return;
    }
    if (isEditing.value) {
        form.put('/category/' + props.category.id);
    } else {
        form.post('/category/add', {
            preserveScroll: true,
            onSuccess: () => {
                toast.success('Category added successfully');
                router.visit('/category');
            },
            onError: () => {
                if (form.errors.name) {
                    form.errors.name = 'Category name is required';
                }
            }
        });
    }
};
</script>