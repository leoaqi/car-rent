<template>

    <Head>
        <title>{{ isEditing ? 'Edit' : 'Add New' }} Tour Package</title>
    </Head>
    <div class="bg-white rounded-xl max-w-screen-md mx-auto py-4 border border-natural-200">
        <form class="px-6">
            <div class="mb-4">
                <div class="text-center">
                    <h1 class="text-xl text-text-primary">{{ isEditing ? 'Edit' : 'Add New' }} Tour Package</h1>
                    <h1 class="text-sm text-text-secondary pt-3">{{ isEditing ? 'Edit a' : 'Create a new' }} tour
                        package
                        for
                        content management
                        system
                    </h1>
                </div>
                <label class="label">
                    Tour Name
                </label>
                <input v-model="form.name" type="text" class="text-field" placeholder="Enter tour name" />
                <div class="flex flex-col lg:flex-row gap-4">
                    <div class="w-full lg:w-1/2">
                        <label class="label">
                            Price
                        </label>
                        <input :value="formatToIDR(form.price)" @input="formatPrice($event)" class="text-field"
                            type="text" @keypress="onlyNumber" placeholder="Enter duration in day" />

                    </div>
                    <div class="w-full lg:w-1/2">
                        <label class="label">
                            Duration
                        </label>
                        <input v-model="form.duration" type="number" class="text-field"
                            placeholder="Enter duration in day" />

                    </div>
                </div>
                <div class="w-full mt-4">
                    <label class="label">Facilities</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div v-for="facility in facilities" :key="facility.value" class="flex items-center gap-2">
                            <input type="checkbox" :id="facility.value" v-model="form.facilities"
                                :value="facility.value"
                                class="bg-primary w-4 h-4 text-primary-500 border-gray-300 rounded focus:ring-primary-500 accent-primary">
                            <label :for="facility.value" class="text-sm text-gray-700">{{ facility.label }}</label>
                        </div>
                    </div>
                </div>
                <div class="w-full mt-4">
                    <label class="label">Destinations</label>
                    <div class="space-y-4">
                        <div v-for="(dest, index) in form.destinations" :key="index" class="flex gap-4 items-start">
                            <div class="flex-1">
                                <DropdownCustom v-model="dest.destination_id" :options="getAvailableDestinations(index)"
                                    placeholder="Select destination" header="Destination" labelKey="name" valueKey="id"
                                    :id="`destination_${index}`" />
                            </div>
                            <button @click.prevent="removeDestination(index)"
                                class="mt-2 text-red-500 hover:text-red-700">
                                <i class="ri-delete-bin-line text-xl"></i>
                            </button>
                        </div>
                    </div>
                    <button @click.prevent="addDestination" v-if="form.destinations.length < props.destination.length"
                        class="mt-4 text-primary-500 hover:text-primary-600 flex items-center gap-2">
                        <i class="ri-add-line"></i>
                        Add Destination
                    </button>
                </div>
            </div>
            <label class="label">
                Status
            </label>
            <div class="flex items-center gap-2">
                <input v-model="form.status" type="checkbox" :value="'active'" :true-value="'active'"
                    :false-value="'inactive'" class="accent-primary" />
                <label class="text-sm text-gray-700">
                    {{ form.status === 'active' ? 'Active' : 'Inactive' }}
                </label>
            </div>
            <label class="label">
                Description
            </label>
            <textarea cols="30" v-model="form.description" rows="3" class="text-field"></textarea>
        </form>
        <div class="w-full h-0.5 bg-natural-200 my-3"></div>
        <div class="flex flex-col md:flex-row justify-center py-4 px-6 gap-4 mx-auto max-w-screen-xl">
            <ButtonForm title="Cancel" type="outline-border" class="w-full  md:w-[232px] " @click="back" />
            <ButtonForm :title="isEditing ? 'Edit Tour Package' : 'Add New Tour Package'" class="w-full md:w-[254px]"
                @click="handleSubmit" />
        </div>
    </div>
</template>

<script setup>
import AuthanticateLayout from '../Layout/AuthanticateLayout.vue'
import { router, useForm, Head } from '@inertiajs/vue3'
import { computed, ref } from 'vue'
import DropdownCustom from '../Components/DropdownCustom.vue'
import ButtonForm from '../Components/ButtonForm.vue'
import { onlyNumber, formatToIDR } from '../../../utils/format'
import { Toast } from '../../../utils/toast'

defineOptions({
    layout: AuthanticateLayout
})

const props = defineProps({
    data: {
        type: Object,
        default: null
    },
    destination: {
        type: Object,
        default: null
    }
});

const toast = new Toast();
const selectedDestination = ref(null);

const isEditing = computed(() => !!props.data);

const form = useForm({
    name: props.data?.name || '',
    description: props.data?.description || '',
    price: props.data?.price || '',
    duration: props.data?.duration_days || '',
    type: props.data?.type || '',
    status: props.data?.status || '',
    facilities: props.data?.facilities ? JSON.parse(props.data.facilities) : [],
    destinations: props.data?.destination_list.map(dest => ({
        destination_id: dest
    })) || [{ destination_id: null }],
})

const facilities = [
    { value: 'hotel', label: 'Hotel' },
    { value: 'meals', label: 'Meals' },
    { value: 'transport', label: 'Transport' },
    { value: 'ticket', label: 'Ticket' }
];

const addDestination = () => {
    console.log(form.destinations);

    form.destinations.push({ destination_id: null });
}

const removeDestination = (index) => {
    if (form.destinations.length > 1) {
        form.destinations.splice(index, 1);
    }
}

const getAvailableDestinations = (currentIndex) => {
    if (form.destinations.length === 0) {
        return props.destination;
    }
    const selectedIds = form.destinations
        .map((dest, index) => index !== currentIndex ? dest.destination_id : null)
        .filter(Boolean);
    return props.destination.filter(dest => !selectedIds.includes(dest));
};

const formatPrice = (event) => {
    const value = event.target.value.replace(/[^\d]/g, '');
    form.price = value;
};

const back = () => {
    router.visit('/car');
}

const handleSubmit = () => {
    const formData = {
        ...form,
        facilities: JSON.stringify(form.facilities)
    };

    if (isEditing.value) {
        form.put(`/tour/${props.data.id}`, {
            data: formData,
            onSuccess: () => {
                toast.success('Tour package updated successfully');
                router.visit('/tour');
            },
            onError: (errors) => {
                toast.errors(errors);
                form.errors = errors.errors;
            },
        })
    } else {
        form.post('/tour/add', {
            data: formData,
            onSuccess: () => {
                toast.success('Tour package added successfully');
                router.visit('/tour');
            },
            onError: (errors) => {
                toast.errors(errors);
                form.errors = errors.errors;
            },
        })
    }

}
</script>