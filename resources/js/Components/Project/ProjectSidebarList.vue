<template>
  <div>
    <Disclosure v-slot="{ open }" defaultOpen>
      <DisclosureButton class="flex w-full justify-between items-center px-2 py-2 text-left text-sm">
        <div class="flex items-center gap-x-1">
          <ChevronUpIcon
            :class="open ? 'rotate-180 transform' : 'rotate-90'"
            class="h-3 w-3 text-slate-500"
          />
          <h1 class="uppercase text-xs text-slate-500 font-semibold">{{ title }}</h1>
        </div>
        <ProjectCreateForm v-if="showActive" />
      </DisclosureButton>
      <DisclosurePanel class="text-sm">
        <div class="flex justify-between items-center pl-5 pr-2 py-1 duration-200 hover:bg-slate-800/90"
             :class="{'bg-dark-800 text-white' : showActive && route().current('projects.*') && route().params.project === project.id}"
             v-for="project in projects" :key="project.id">
          <div class="flex items-center justify-start gap-x-2">
            <span :class="`bg-${project.color}-600`" class="h-2.5 w-2.5 rounded-full" />
            <a :href="project._links?.list"
               class="w-40 truncate text-white">
              {{ project.name }}
            </a>
          </div>
          <ProjectsListActions class="!text-white ml-auto !hover:bg-slate-700" :project="project" />
        </div>
      </DisclosurePanel>
    </Disclosure>
  </div>
</template>

<script setup>

import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";
import { ChevronUpIcon } from "@heroicons/vue/24/outline";
import ProjectCreateForm from "@/Components/Forms/ProjectCreateForm.vue";
import ProjectsListActions from "@/Components/Project/ProjectsListActions.vue";

const props = defineProps({
  title: String,
  projects: Array,
  showActive: Boolean
});
</script>

<style scoped>

</style>