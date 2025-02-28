<template>
    <button @click="handleClick"
        class="bg-primary-500 hover:bg-primary400 text-white p-3 rounded-md">
        <slot/>
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
    if (!props.disabled) {
        emit('click');
    }
};
</script>