<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue'
import { useDropdown } from '../../../utils/use_dropdown.js'

const props = defineProps({
  modelValue: {
    type: Object,
    default: null
  },
  id: {
    type: String,
    required: true
  },
  header: {
    type: String,
    default: 'Header'
  },
  options: {
    type: Array,
    default: () => []
  },
  placeholder: {
    type: String,
    default: 'Select Option'
  },
  labelKey: {
    type: String,
    default: 'label'
  },
  valueKey: {
    type: String,
    default: 'id'
  },
  error: {
    type: Boolean,
    default: false
  },
  errorMessage: {
    type: String,
    default: ''
  }
})

const emit = defineEmits(['update:modelValue', 'change'])

const dropdownRef = ref(null)
const { activeDropdown, setActiveDropdown, closeAll } = useDropdown()

const isOpen = computed(() => activeDropdown.value === props.id)

const getOptionLabel = (option) => {
  if (typeof option === 'object') {
    // Handle nested objects using dot notation
    return props.labelKey.split('.').reduce((obj, key) => obj?.[key], option) || ''
  }
  return option
}

const selectedOption = computed({
  get: () => props.modelValue,
  set: (value) => {
    emit('update:modelValue', value)
    emit('change', value)
  }
})

const toggleDropdown = (event) => {
  event.stopPropagation()
  setActiveDropdown(props.id)
}

const selectOption = (option) => {
  selectedOption.value = option
  closeAll()
}

const handleClickOutside = (event) => {
  if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
    closeAll()
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
  document.addEventListener('keydown', closeAll)
})

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside)
  document.removeEventListener('keydown', closeAll)
})
</script>

<template>
  <div class="relative w-full" ref="dropdownRef">
    <button
      type="button"
      @click="toggleDropdown"
      class="w-full px-4 py-3 text-left bg-white rounded-lg border border-natural-200"
      :class="{
        'text-field': !error,
        'error-border': error
      }"
    >
      <span class="block text-text-secondary truncate pr-7">
        {{ selectedOption ? getOptionLabel(selectedOption) : placeholder }}
      </span>
      <span class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
        <svg
          class="w-5 h-5 text-gray-400 transition-transform duration-200"
          :class="{ 'transform rotate-180': isOpen }"
          viewBox="0 0 20 20"
          fill="currentColor"
        >
          <path
            fill-rule="evenodd"
            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
            clip-rule="evenodd"
          />
        </svg>
      </span>
    </button>

    <div
      v-show="isOpen"
      class="absolute z-10 w-full mt-2 bg-white border border-natural-200 rounded-lg shadow-lg"
    >
      <div class="overflow-auto max-h-80">
        <h3 class="px-4 py-2 text-lg font-medium border-b border-natural-200">{{ header }}</h3>
        <div class="p-2">
          <div
            v-for="option in options"
            :key="option[valueKey]"
            @click="selectOption(option)"
            class="px-4 py-3 rounded-lg flex items-center space-x-3 text-text-secondary hover:bg-primary-100 cursor-pointer"
            :class="{'bg-primary-500 text-white hover:bg-primary-600': option[valueKey] === selectedOption?.[valueKey]}"
          >
            <span class="text-sm">{{ getOptionLabel(option) }}</span>
          </div>
        </div>
      </div>
    </div>
    
    <span v-if="error && errorMessage" class="text-red-500 text-sm mt-1 block">
      {{ errorMessage }}
    </span>
  </div>
</template>