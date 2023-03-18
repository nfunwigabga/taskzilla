<template>
  <Teleport to="#header-left" v-if="isMounted">
    <div class="font-bold text-2xl">
      {{ user.name }}
    </div>
  </Teleport>
  <div class="px-4 md:px-0 py-10">
    <BasePage class="space-y-4">
      <div class="flex items-center space-x-5">
        <div class="flex-shrink-0">
          <div class="relative">
            <BaseAvatar :avatar="user.avatar" class="h-20 w-20" />
          </div>
        </div>
        <div>
          <h1 class="text-2xl font-bold text-gray-900">
            {{ user.name }}
          </h1>
          <p v-if="user.title" class="text-base font-medium text-gray-600 mt-1">
            {{ user.title }}
          </p>
          <p v-if="user.email" class="text-base flex items-center gap-x-1 font-medium text-gray-600 mt-1">
            <EnvelopeIcon class="h-5" />
            <a :href="`mailto:${ user.email }`">{{ user.email }}</a>
          </p>
        </div>
      </div>

      <div class="grid grid-cols-5 gap-4">
        <div class="col-span-5 md:col-span-3 space-y-4">
          <BaseCard class="p-0 overflow-x-auto">
            <template #header>
              Open tasks
            </template>

            <div class="text-center px-3 py-8 text-gray-500" v-if="tasks.data.length === 0">
              No open assigned tasks
            </div>
            <template v-else>
              <table class="min-w-full">
                <thead class="border-b border-dark-400">
                <tr>
                  <th scope="col"
                      class="py-2 pl-4 pr-3 text-left text-xs uppercase font-semibold text-gray-900 sm:pl-6">Key
                  </th>
                  <th scope="col" class="px-3 py-2 text-left text-xs uppercase font-semibold text-gray-900">Title</th>
                  <th scope="col" class="px-3 py-2 text-left text-xs uppercase font-semibold text-gray-900">Type</th>
                  <th scope="col" class="px-3 py-2 text-left text-xs uppercase font-semibold text-gray-900">Project</th>
                </tr>
                </thead>
                <tbody class="bg-white">
                <tr v-for="(task, idx) in tasks.data" :key="task.id"
                    :class="[idx === 0 ? 'border-dark-300' : 'border-gray-200', 'border-t']">
                  <td class="whitespace-nowrap py-1 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                    <Link class="text-primary-600 font-semibold" :class="{'line-through' : task.resolved}"
                          :href="task._links.self">
                      {{ task.key }}
                    </Link>
                  </td>
                  <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">{{ task.title }}</td>

                  <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">
                    <TaskCodeForm :codes="task.project.codes"
                                  :task="task" code-type="type"
                                  :code-value="task.type?.id">
                      <Tooltip label="Type">
                        <TaskTypeBadge :type="task.type" />
                      </Tooltip>
                    </TaskCodeForm>
                  </td>
                  <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">
                    {{ task.project?.title }}
                  </td>
                </tr>
                </tbody>
              </table>
              <div
                class="grid px-4 py-2 border-t text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-50 sm:grid-cols-9">
              <span class="flex items-center col-span-3">
                  Showing {{ meta.from }}-{{ meta.to }} of {{ meta.total }}
              </span>
                <span class="col-span-2"></span>
                <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                <BasePagination :links="meta.links" />
              </span>
              </div>
            </template>
          </BaseCard>

          <BaseCard>
            <template #header>
              Projects
            </template>
            <div v-if="!projects.length" class="text-gray-500 text-sm italic">
              Not assigned to any projects yet
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-x-3">
              <ProjectsListItem
                v-for="project in projects"
                :project="project"
                :show-actions="false"
                :key="project.id" />
            </div>
          </BaseCard>
        </div>

        <div class="col-span-5 md:col-span-2">
          <BaseCard>
            <template #header>
              About me
            </template>
            <p class="leading-relaxed" v-if="user.about">{{ user.about }}</p>
            <p v-else class="text-gray-400">No information provided</p>
          </BaseCard>
        </div>
      </div>
    </BasePage>
  </div>
</template>

<script setup>

import { useMounted } from "@/Composables/useMounted";
import BasePage from "@/Components/BasePage.vue";
import BaseAvatar from "@/Components/BaseAvatar.vue";
import { EnvelopeIcon } from "@heroicons/vue/24/outline";
import BaseCard from "@/Components/BaseCard.vue";
import { ref, watch } from "vue";
import { debounce, pickBy } from "lodash";
import BasePagination from "@/Components/BasePagination.vue";
import ProjectsListItem from "@/Components/Project/ProjectsListItem.vue";
import TaskCodeForm from "@/Components/Forms/TaskCodeForm.vue";
import TaskTypeBadge from "@/Components/Tasks/TaskTypeBadge.vue";
import { Tooltip } from "@spartez/vue-atlaskit-next";

const props = defineProps({
  user: Object,
  tasks: Object,
  projects: Object,
  filters: Object
});
const { isMounted } = useMounted();
const { meta } = props.tasks;

const params = ref({
  q: props.filters.q || null
});


watch(() => params, () => {
  search();
}, { deep: true });


const search = debounce(() => {
  let search_params = pickBy(params.value);
  router.get(route("users.show", [props.user.id]), search_params, {
    replace: true,
    preserveState: true,
    preserveScroll: true
  });
}, 150);
</script>

<style scoped>

</style>