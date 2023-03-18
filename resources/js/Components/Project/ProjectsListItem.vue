<template>
  <div
    class="group col-span-2 relative flex items-center space-x-3 py-2 px-2 hover:bg-gray-100 rounded-xl transition-all duration-500">
    <div class="flex-shrink-0">
      <span :class="[`bg-${project.color}-600`, 'inline-flex items-center justify-center h-10 w-10 rounded-lg']">
        <component :is="iconPicker[project.icon]" class="h-6 w-6 text-white" aria-hidden="true" />
      </span>
    </div>
    <div class="min-w-0 flex-1">
      <div class="text-sm flex-auto truncate font-medium text-gray-900">
        <Link v-if="project.can.view" :href="project._links.list">
          {{ project.name }}
        </Link>
        <div v-else>
          {{ project.name }}
        </div>
      </div>
    </div>
    <div class="flex-shrink-0 self-center">
      <ProjectsListActions v-if="showActions" :project="project" />
    </div>
  </div>
</template>

<script setup>
import { iconPicker } from "@/Helpers/icons";
import ProjectsListActions from "@/Components/Project/ProjectsListActions.vue";

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