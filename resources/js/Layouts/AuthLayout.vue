<template>
  <div class="flex bg-dark-100 min-h-screen flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <img class="mx-auto h-12 w-auto" src="/logo-sm.png"
           alt="Your Company" />
      <h2 class="mt-0 text-center text-3xl font-bold tracking-tight text-gray-900">
        <span id="title" />
      </h2>
    </div>
    <div class="mt-4 sm:mx-auto sm:w-full sm:max-w-md">
      <transition name="page" mode="out-in" appear :key="route().current()">
        <div class="bg-white py-8 px-4 shadow-md sm:rounded-lg sm:px-10">
          <slot />
        </div>
      </transition>

    </div>
  </div>
</template>

<script setup>
defineOptions({
  name: "AuthLayout"
});

</script>

<style scoped>

</style>