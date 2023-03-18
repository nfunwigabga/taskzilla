<template>
  <Tooltip label="Create Project"
           placement="bottom"
           v-if="type==='icon'">
    <button
      @click.prevent="$inertia.get(route('projects.create'))"
      class="p-0.5 bg-gray-200 transition-all duration-300 hover:bg-gray-300 shadow rounded-full">
      <PlusIcon class="h-4 w-4" />
    </button>
  </Tooltip>
  <button
    v-else
    @click.prevent="$inertia.get(route('projects.create'))"
    class="col-span-2 p-2 flex items-center gap-x-4 hover:bg-gray-100 rounded-xl cursor-pointer transition-all duration-500">
        <span
          class="h-12 w-12 rounded-xl  text-gray-500 border border-gray-400 border-dashed flex items-center justify-center">
          <PlusIcon class="h-4 w-4" />
        </span>
    <span class="text-center text-sm text-gray-500 font-semibold">
      Create Project
    </span>
  </button>

</template>

<script setup>

import { PlusIcon } from "@heroicons/vue/24/outline";
import { Tooltip } from "@spartez/vue-atlaskit-next";

const props = defineProps({
  type: { default: "icon" }
});


</script>

<style scoped>

</style>