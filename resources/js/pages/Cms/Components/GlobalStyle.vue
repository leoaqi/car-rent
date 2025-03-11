<template></template>


<style>
@reference "../../../../css/app.css";

.border-form{
    @apply border border-gray-300 rounded-lg focus:outline-none focus:ring-primary-500 focus:border-primary-500
}

.btnPrimary{
    @apply text-3xl font-medium bg-primary-500 hover:bg-primary-400 text-white py-[12px] px-[12px] rounded-[10px] w-full
}

.horizontal-divider{
  @apply w-full h-[1px] bg-natural-200 my-3
}

.text-field{
  @apply w-full px-3 py-2 border border-natural-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500
}

.label{
  @apply block text-sm font-medium text-gray-700 mb-2 pt-3.5
}

.text-field-disabled{
  @apply bg-natural-100 border border-natural-200 p-2 rounded-sm text-neutral-500
}

.checkbock {
    @apply h-[14px] w-[14px] text-primary-500 rounded-[4px] accent-primary-500;
}

/* Override default disabled styles */
input[type="checkbox"]:disabled {
    opacity: 1 !important;
}

input[type="checkbox"]:disabled:checked {
    background-color: theme('colors.primary.500') !important;
    border-color: theme('colors.primary.500') !important;
}
</style>