<template>
  <div class="rounded-lg bg-white shadow">
    <div v-if="slots.header || slots['header-right']"
         class="text-gray-700 border-b px-5 py-2 flex flex-col md:flex-row justify-between items-center">
      <div class="text-lg font-semibold">
        <slot name="header" />
      </div>
      <template v-if="slots['header-right']">
        <slot name="header-right" />
      </template>
    </div>

    <div class="p-5" v-bind="$attrs">
      <slot />
    </div>
    <div class="bg-gray-50 px-5 py-3" v-if="slots.footer">
      <div class="text-sm">
        <slot name="footer" />
      </div>
    </div>
  </div>
</template>

<script setup>
import { useSlots } from "vue";

const slots = useSlots();
</script>

<style scoped>

</style>