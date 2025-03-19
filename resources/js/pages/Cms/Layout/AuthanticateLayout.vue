<template>
    <div class="flex flex-col lg:flex-row h-screen ">
      <!-- Sidebar -->
      <CustomSidebar class="hidden lg:flex lg:flex-col" />
  
      <!-- Main Content Area -->
      <div class="flex-1 flex flex-col overflow-y-auto [&::-webkit-scrollbar]:hidden">
        <!-- Header -->
        <Header />
  
        <!-- Content -->
        <div class="flex-1 bg-foreground overflow-y-auto">
          <main class="m-4 lg:m-8 ">
            <slot />
          </main>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import CustomSidebar from '../Components/CustomSidebar.vue';
  import Header from '../Components/Header.vue';
  </script>