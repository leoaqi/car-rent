<template>
    <button @click="handleClick"
        class="text-body font-medium bg-primary-500 hover:bg-primary-400 hover:cursor-pointer text-white py-[12px] px-[12px] rounded-[10px] w-full">
        {{ title }}
    </button>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue';
const props = defineProps({
    title: {
        type: String,
        default: 'Button'
    }
})

const emit = defineEmits(['click']);

const handleClick = () => {
    emit('click');
};
</script>