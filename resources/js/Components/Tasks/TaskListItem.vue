<template>
  <li
    class="flex  items-center group px-2 hover:bg-gray-100 focus-within:!bg-blue-50 border-gray-200">
    <div class="border-b flex flex-1 py-2 items-start sm:items-centerx">
      <div class="icon text-icon mr-2">
        <CompletedIcon v-if="task.resolved" class="h-6 w-6 sm:h-4 sm:w-4 text-green-600" />
        <IncompleteIcon v-else class="h-6 w-6 sm:h-4 sm:w-4" />
      </div>
      <div class="w-full md:flex items-start justify space-y-1 md:space-y-0">
        <div class="flex-1">
          <Link :href="task._links?.self"
                class="flex flex-1 leading-5 gap-2 sm:gap-2 flex-col justify-start items-start md:flex-row md:flex-1 md:justify-between text-black cursor-pointer text-md">
          <span>
            <span class="font-semibold text-gray-500 uppercase">{{ task.key }}:</span>
            {{ task.title }}
          </span>
          </Link>
          <span v-if="task.due_date?.mmddyyyy"
                class="flex items-center gap-x-1 text-xs">
            Due: {{ task.due_date?.mmddyyyy }}
            <span v-if="task.is_late"
                  class="text-xxs bg-danger-200/60 px-1 text-danger-700 font-bold rounded leading-3">LATE</span>
          </span>
        </div>
        <div>

          <Tooltip :label="`Project: ${task.project.title}`">
            <div
              :class="`bg-${task.project.color}-50 text-${task.project.color}-800 rounded-full text-xs px-1 py-0.5 max-w-[8rem] truncate`">
              {{ task.project.title }}
            </div>
          </Tooltip>
        </div>
      </div>
    </div>
  </li>
</template>

<script setup>
import {
  CheckCircleIcon as IncompleteIcon,
  ChatBubbleOvalLeftIcon
} from "@heroicons/vue/24/outline";

import { CheckCircleIcon as CompletedIcon } from "@heroicons/vue/24/solid";
import DragHandleIcon from "@/Components/Icons/DragHandleIcon.vue";
import SubtaskIcon from "@/Components/Icons/SubtaskIcon.vue";
import TaskDueDateForm from "@/Components/Forms/TaskDueDateForm.vue";
import TaskAssigneeForm from "@/Components/Forms/TaskAssigneeForm.vue";
import TaskCodeForm from "@/Components/Forms/TaskCodeForm.vue";
import TaskTypeBadge from "@/Components/Tasks/TaskTypeBadge.vue";
import { Tooltip } from "@spartez/vue-atlaskit-next";

const props = defineProps({
  task: Object
});
const disabled = computed(() => props.task.project?.is_archived || !props.task.project.can?.manage);

</script>

<style scoped>

</style>