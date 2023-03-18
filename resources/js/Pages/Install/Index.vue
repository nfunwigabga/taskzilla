<template>
  <div class="flex flex-col gap-4 items-center justify-center px-28 py-12">
    <h1 class="text-4xl text-dark-500">Welcome to the installer</h1>
    <p class="text-xl">Let's walk through the installation process and get you set up.</p>
    <BaseFormButton
      @click="$inertia.visit(route('install.requirements'))"
      :block="false"
      type="button" class="py-6 px-4">
      LET'S START
    </BaseFormButton>
  </div>
</template>

<script setup>

import InstallLayout from "@/Layouts/InstallLayout.vue";
import BaseFormButton from "@/Components/BaseFormButton.vue";

defineOptions({
  layout: InstallLayout
});
</script>

<style scoped>

</style>