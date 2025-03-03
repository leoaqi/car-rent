<template>
    <Teleport to="body">
      <Transition name="modal-fade">
        <div v-if="modelValue" class="modal-overlay" @click="closeOnOverlayClick && $emit('update:modelValue', false)">
          <div @click.stop class="px-4 md:px-0">
            <slot/>
          </div>
        </div>
      </Transition>
    </Teleport>
  </template>
  
  <script setup>
  import { onMounted, onUnmounted } from 'vue'
  
  const props = defineProps({
    modelValue: {
      type: Boolean,
      required: true
    },
    title: {
      type: String,
      default: ''
    },
    showCloseButton: {
      type: Boolean,
      default: true
    },
    closeOnOverlayClick: {
      type: Boolean,
      default: true
    }
  })
  
  defineEmits(['update:modelValue'])
  
  // Handle ESC key to close modal
  const handleEsc = (e) => {
    if (e.key === 'Escape' && props.modelValue) {
      emit('update:modelValue', false)
    }
  }
  
  onMounted(() => {
    document.addEventListener('keydown', handleEsc)
  })
  
  onUnmounted(() => {
    document.removeEventListener('keydown', handleEsc)
  })
  </script>
  
  <style scoped>
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
  }
  
  .modal-container {
    background-color: white;
    border-radius: 8px;
    padding: 20px;
    max-width: 500px;
    width: 90%;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  }
  
  .modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
  }
  
  .modal-title {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 600;
  }
  
  .modal-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    padding: 0;
    color: #666;
    transition: color 0.2s;
  }
  
  .modal-close:hover {
    color: #000;
  }
  
  .modal-body {
    margin-bottom: 20px;
  }
  
  .modal-footer {
    border-top: 1px solid #eee;
    padding-top: 20px;
  }
  
  /* Transition animations */
  .modal-fade-enter-active,
  .modal-fade-leave-active {
    transition: opacity 0.3s ease;
  }
  
  .modal-fade-enter-from,
  .modal-fade-leave-to {
    opacity: 0;
  }
  </style>