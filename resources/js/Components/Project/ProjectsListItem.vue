<template>
  <div
    :class="{'cursor-pointer': project.can.view}"
    class="col-span-2 p-2 flex justify-between items-center gap-x-2 hover:bg-gray-100 rounded-xl transition-all duration-500">
    <Link v-if="project.can.view" :href="project._links.list" class="flex items-center gap-x-2 flex-1">
      <span
        :class="`bg-${project.color}-600`"
        class="h-12 w-12 rounded-xl text-white flex items-center justify-center">
        <component :is="iconPicker[project.icon]" class="h-6 w-6" />
      </span>
      <span class="truncate">{{ project.name }}</span>
    </Link>
    <div v-else class="flex items-center gap-x-2 flex-1">
      <span
        :class="`bg-${project.color}-600`"
        class="h-12 w-12 rounded-xl text-white flex items-center justify-center">
        <component :is="iconPicker[project.icon]" class="h-6 w-6" />
      </span>
      <span class="truncate">{{ project.name }}</span>
    </div>

    <div v-if="showActions" class="text-sm text-gray-500 font-semibold">
      <ProjectsListActions :project="project" />
    </div>
  </div>
</template>

<script setup>
import { iconPicker } from "@/Helpers/icons";

const props = defineProps({
  project: Object,
  showActions: {
    type: Boolean,
    default: true
  }
});
</script>

<style scoped>

</style>