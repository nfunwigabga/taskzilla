<template>
  <div class="px-4 md:px-0 py-10">
    <BasePage>
      <Head>
        <title>My Tickets </title>
      </Head>
      <Teleport to="#header-left" v-if="isMounted">
        <h2 class="font-bold text-xl">My Tickets</h2>
      </Teleport>

      <BaseCard v-if="tasks.data?.length" class="p-0 max-h-[40rem] overflow-y-auto">
        <template #header>
          Reported by or assigned to me
        </template>
        <template #header-right>
          <BaseFormInput class="w-full min-w-[14rem] md:max-w-sm " placeholder="Search..." v-model="params.q" />
        </template>
        <table class="min-w-full">
          <thead class="border-b border-dark-400">
          <tr>
            <th scope="col"
                class="py-2 pl-4 pr-3 text-left text-xs uppercase font-semibold text-gray-900 sm:pl-6">Key
            </th>
            <th scope="col" class="px-3 py-2 text-left text-xs uppercase font-semibold text-gray-900">Title</th>
            <th scope="col"
                class="px-3 py-2 text-left text-xs uppercase font-semibold text-gray-900 hidden md:table-cell">Type
            </th>
            <th scope="col" class="px-3 py-2 text-left text-xs uppercase font-semibold text-gray-900">Priority
            </th>
            <th scope="col"
                class="px-3 py-2 text-left text-xs uppercase font-semibold text-gray-900 hidden md:table-cell">Project
            </th>
            <th scope="col"
                class="px-3 py-2 text-left text-xs uppercase font-semibold text-gray-900 hidden md:table-cell">Reporter
            </th>
            <th scope="col"
                class="px-3 py-2 text-left text-xs uppercase font-semibold text-gray-900 hidden md:table-cell">Assignee
            </th>
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

            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500 hidden md:table-cell">
              <TaskCodeForm :codes="task.project.codes"
                            :task="task" code-type="type"
                            :code-value="task.type?.id">
                <Tooltip label="Type">
                  <TaskTypeBadge :type="task.type" />
                </Tooltip>
              </TaskCodeForm>
            </td>
            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">
              <TaskCodeForm :codes="task.project.codes" :task="task" code-type="priority"
                            :code-value="task.priority?.id">
                <Tooltip label="Priority">
                  <TaskTypeBadge :type="task.priority" />
                </Tooltip>
              </TaskCodeForm>
            </td>
            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500 hidden md:table-cell">
              {{ task.project?.title }}
            </td>
            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500 hidden md:table-cell">
              <div class="flex items-center gap-x-2">
                <BaseAvatar :avatar="task.reporter?.avatar" class="h-5" />
                <span>{{ task.reporter.name }}</span>
              </div>
            </td>
            <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500 hidden md:table-cell">
              <div class="flex items-center gap-x-2">
                <TaskAssigneeForm
                  :members="task.project?.members"
                  :assignee="task.assignee"
                  :task="task"
                  show-name />
              </div>
            </td>
          </tr>
          </tbody>
        </table>
        <div
          class="grid border px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t bg-gray-50 sm:grid-cols-9">
          <span class="flex items-center col-span-3">
              Showing {{ meta.from }}-{{ meta.to }} of {{ meta.total }}
          </span>
          <span class="col-span-2"></span>
          <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
            <BasePagination :links="meta.links" />
          </span>
        </div>
      </BaseCard>

      <div class="text-center py-12" v-else>
        <RectangleStackIcon class="mx-auto h-12 w-12 text-gray-300" />
        <h3 class="mt-2 text-base font-semibold text-gray-600">No tasks</h3>
        <p class="mt-1 text-sm text-gray-500">You've not been assigned to or created any tasks</p>
      </div>


    </BasePage>

  </div>
</template>

<script setup>
import { RectangleStackIcon } from "@heroicons/vue/24/outline";
import { useMounted } from "@/Composables/useMounted";
import BasePage from "@/Components/BasePage.vue";
import BaseCard from "@/Components/BaseCard.vue";
import BaseAvatar from "@/Components/BaseAvatar.vue";
import TaskAssigneeForm from "@/Components/Forms/TaskAssigneeForm.vue";
import TaskCodeForm from "@/Components/Forms/TaskCodeForm.vue";
import TaskTypeBadge from "@/Components/Tasks/TaskTypeBadge.vue";
import { Tooltip } from "@spartez/vue-atlaskit-next";
import BaseFormInput from "@/Components/BaseFormInput.vue";
import { ref, watch } from "vue";
import BasePagination from "@/Components/BasePagination.vue";
import { debounce, pickBy } from "lodash";

const props = defineProps({
  tasks: Object,
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
  router.get(route("my.tasks"), search_params, {
    replace: true,
    preserveState: true,
    preserveScroll: true
  });
}, 150);
</script>

<style>

</style>