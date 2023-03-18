<template>
  <div class="rounded-lg bg-white shadow">
    <div class="px-5 py-2 text-lg font-semibold text-dark-600">
      <slot name="header" />
    </div>
    <TabGroup :defaultIndex="0">
      <TabList class="border-b border-gray-200 flex gap-x-4 px-4">
        <slot name="tabs" />
      </TabList>
      <TabPanels class="mt-2" v-bind="$attrs">
        <slot />
      </TabPanels>
    </TabGroup>
  </div>
</template>

<script setup>
import { useSlots } from "vue";
import { TabGroup, TabList, TabPanels } from "@headlessui/vue";

const slots = useSlots();
</script>

<style scoped>

</style>