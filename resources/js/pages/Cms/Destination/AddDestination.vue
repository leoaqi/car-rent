<template>
    <Head>
        <title>
            {{ isEditing? 'Edit' : 'Add New' }} Destination
        </title>
    </Head>
    <div class="bg-white rounded-xl max-w-screen-md mx-auto py-4 border border-natural-200">
        <form class="px-6">
            <div class="mb-4">
                <div class="text-center">
                    <h1 class="text-xl text-text-primary">{{ isEditing ? 'Edit' : 'Add New' }} Destination</h1>
                    <h1 class="text-sm text-text-secondary pt-3">{{ isEditing ? 'Edit a' : 'Create a new' }} destination
                        for
                        content management
                        system
                    </h1>
                </div>
                <label class="label">
                    Destination Name
                </label>
                <input v-model="form.name" type="text" class="text-field"
                    :class="{ 'border-red-500': form.errors.name }" placeholder="Enter car name" />
                <div v-if="form.errors.name" class="text-red-500 text-xs mt-1">
                    {{ form.errors.name }}
                </div>
                <div class="w-full">
                    <label class="label">Region</label>
                    <input type="text" v-model="form.region" class="text-field" placeholder="Enter region" />
                </div>

                <label class="label">Destination Images</label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-4">
                    <input type="file" multiple accept="image/*" class="hidden" ref="fileInput"
                        @change="handleFileChange" />
                    <div class="text-center" @click="$refs.fileInput.click()">
                        <div v-if="!previewImages.length" class="cursor-pointer">
                            <i class="ri-upload-cloud-2-line text-4xl text-gray-400"></i>
                            <p class="text-sm text-gray-500 mt-2">Click to upload images</p>
                        </div>
                        <div v-else class="grid grid-cols-3 gap-4">
                            <div v-for="(image, index) in previewImages" :key="index" class="relative">
                                <img :src="image" class="w-full h-32 object-cover rounded-lg">
                                <i class="ri-close-fill absolute -top-2 -right-2 bg-primary-500 
                                text-white w-5 h-5 rounded-full flex items-center justify-center
                                 hover:bg-primary-600 cursor-pointer" @click="removeImage(index)"></i>
                            </div>
                            <div v-if="previewImages.length < 5"
                                class="border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center cursor-pointer h-32"
                                @click.stop="$refs.fileInput.click()">
                                <i class="ri-add-line text-2xl text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <label class="label">
                    Description
                </label>
                <textarea cols="30" v-model="form.description" rows="3" class="text-field"></textarea>
            </div>
        </form>
        <div class="w-full h-[1px] bg-natural-200 my-3"></div>
        <div class="flex flex-col md:flex-row justify-center py-4 px-6 gap-4 mx-auto max-w-screen-xl">
            <ButtonForm title="Cancel" type="outline-border" class="w-full  md:w-[232px] " @click="back" />
            <ButtonForm :title="isEditing ? 'Edit Destination' : 'Add New Destination'" class="w-full md:w-[254px]"
                @click="handleSubmit" />
        </div>
    </div>
</template>

<script setup>
import AuthanticateLayout from '../Layout/AuthanticateLayout.vue'
import { defineOptions, defineProps, computed, ref, onMounted } from 'vue'
import { useForm, router, Head } from '@inertiajs/vue3'
import ButtonForm from '../Components/ButtonForm.vue'
import { Toast } from '../../../utils/toast'

defineOptions({
    layout: AuthanticateLayout
})

const props = defineProps({
    destination: {
        type: Object,
        default: null
    }
});

onMounted(() => {

    if (props.destination?.images) {
        props.destination.images.forEach(image => {
            previewImages.value.push(`/storage/${image.image_path}`);
        });
    }
});

const toast = new Toast();

const isEditing = computed(() => !!props.destination);

const fileInput = ref(null);
const previewImages = ref([]);

const form = useForm({
    name: props.destination?.name || '',
    region: props.destination?.region || '',
    description: props.destination?.description || '',
    images: props.destination?.images || [],
    new_images: [],
})

const handleFileChange = (event) => {
    const files = Array.from(event.target.files);
    console.log(previewImages.value.length);

    const maxFiles = 5 - (previewImages.value.length + form.images.length);
    const selectedFiles = files.slice(0, maxFiles);

    selectedFiles.forEach(file => {

        if (file.type.startsWith('image/') && !isEditing) {
            const reader = new FileReader();
            reader.onload = (e) => {
                previewImages.value.push(e.target.result);
            };
            reader.readAsDataURL(file);
            form.images.push(file);
        } else {
            const reader = new FileReader();
            reader.onload = (e) => {
                previewImages.value.push(e.target.result);
            };
            reader.readAsDataURL(file);
            form.new_images.push(file);
        }
    });
};

const removeImage = (index) => {

    event.preventDefault();
    event.stopPropagation();

    const existingImagesCount = form.images.length;

    if (index < existingImagesCount) {
        // Removing existing image
        form.images.splice(index, 1);
        previewImages.value.splice(index, 1);
    } else {
        // Removing new image
        const newIndex = index - existingImagesCount;
        form.new_images.splice(newIndex, 1);
        previewImages.value.splice(index, 1);
    }
};

const handleSubmit = () => {
    if (!form.name || !form.region || !form.description) {
        toast.errors({
            name: !form.name ? 'Destination name is required' : null,
            region: !form.region ? 'Region is required' : null,
            description: !form.description ? 'Description is required' : null
        });
        return;
    }
    if (isEditing.value) {

        const formData = new FormData();

        // Append basic form fields
        formData.append('_method', 'PUT');
        formData.append('name', form.name);
        formData.append('description', form.description);
        formData.append('region', form.region);

        // Append existing images
        formData.append('images', JSON.stringify(form.images.map(img => img.id)));

        // Append new images
        if (form.new_images.length > 0) {
            form.new_images.forEach(file => {
                formData.append('new_images[]', file);
            });
        }

        router.post(`/destination/${props.destination.id}`, formData, {
            onSuccess: () => {
                toast.success('Destination updated successfully');
                router.visit('/destination');
            },
            onError: (errors) => {
                form.errors = errors.errors;
            },
        });
    } else {

        form.post('/destination/add', {
            onSuccess: () => {
                toast.success('Destination added successfully');
                router.visit('/destination');
            },
            onError: (errors) => {
                console.log(errors);

                form.errors = errors.errors;
            },
        });
    }
}

const back = () => {
    router.visit('/destination');
}
</script>