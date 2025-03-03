// utils/use_dropdown.js
import { ref } from 'vue'

// Create a symbol for the global state key
const globalDropdownKey = Symbol('dropdown')

// Create a single instance of the state
const state = {
  activeDropdown: ref(null)
}

export function useDropdown() {
  const setActiveDropdown = (id) => {
    if (state.activeDropdown.value === id) {
      state.activeDropdown.value = null
    } else {
      state.activeDropdown.value = id
    }
  }

  const closeAll = () => {
    state.activeDropdown.value = null
  }

  return {
    activeDropdown: state.activeDropdown,
    setActiveDropdown,
    closeAll
  }
}