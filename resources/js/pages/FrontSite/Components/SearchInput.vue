<template>
    <div class="relative w-full lg:w-xl">
        <div class="absolute left-4 top-1/2 -translate-y-1/2">
            <i class="ri-search-line text-gray-500"></i>
        </div>
        <input type="text" :placeholder="hint" :value="modelValue" @input="updateValue" @keyup.enter="handleSearch"
            class="w-full px-4 py-3 text-content font-normal text-gray-600
        placeholder-gray-500 bg-white border border-gray-200 rounded-lg 
        focus:outline-none overflow-hidden truncate pl-12 pr-10
        focus:border-primary-500 focus:ring-0 focus:ring-primary-500" aria-label="Search" />
        <!-- Close Icon Right -->
        <div class="absolute right-4 top-1/2 -translate-y-1/2">
            <i class="ri-equalizer-2-line text-natural-600 hover:text-natural-200 cursor-pointer" @click="handleFilter"></i>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
  hint: {
    type: String,
    default: 'Search...', // Default placeholder text
  },
  modelValue: {
    type: String,
    default: ''
  },
});

const emit = defineEmits(['update:modelValue', 'search', 'filter'])

const updateValue = (event) => {
  emit('update:modelValue', event.target.value)
}

const handleSearch = () => {
  emit('search', props.modelValue)
}

const handleFilter = () => {
  emit('filter')
}</script>