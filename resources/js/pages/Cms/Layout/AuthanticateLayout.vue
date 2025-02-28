<template>
    <div class="flex flex-col lg:flex-row h-screen ">
      <!-- Sidebar -->
      <Sidebar class="hidden lg:flex flex-col" />
  
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
      <Sidebar class="flex flex-row bottom-0 lg:hidden" />
    </div>
  </template>
  
  <script setup>
  import Sidebar from '../Components/Sidebar.vue';
  import Header from '../Components/Header.vue';
  </script>