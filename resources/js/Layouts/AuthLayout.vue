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
      <ul class="w-full max-w-lg text-sm mt-4 text-gray-400 flex items-center justify-center flex-wrap gap-4">
        <li v-for="link in links" :key="link.id">
          <Link class="transition-colors duration-300 hover:text-gray-600" :href="link.href">{{ link.title }}</Link>
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup>
defineOptions({
  name: "AuthLayout"
});

const links = [
  { id: 1, title: "asana.test", href: "#" },
  { id: 2, title: "Pricing", href: "#" },
  { id: 3, title: "Privacy policy", href: "#" },
  { id: 4, title: "Terms of service", href: "#" }
];
</script>

<style scoped>

</style>