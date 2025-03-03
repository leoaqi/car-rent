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
</style>