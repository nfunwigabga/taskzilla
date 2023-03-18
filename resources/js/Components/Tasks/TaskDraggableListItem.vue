<template>
  <li
    class="flex  py-2x items-center group px-2 hover:bg-gray-100 focus-within:!bg-blue-50 border-gray-200">
    <button class="cursor-grab handle mr-4 opacity-0 group-hover:opacity-100">
      <DragHandleIcon class="h-4 w-4" />
    </button>
    <div class="border-b flex flex-1 py-2 items-start sm:items-center">
      <div class="icon text-icon mr-2">
        <CompletedIcon v-if="element.resolved" class="h-6 w-6 sm:h-4 sm:w-4 text-green-600" />
        <IncompleteIcon v-else class="h-6 w-6 sm:h-4 sm:w-4" />
      </div>

      <div class="w-full md:flex items-center justify space-y-1.5 md:space-y-0">
        <div class="flex-1">
          <Link :href="element._links?.self"
                class="flex flex-1 gap-3 sm:gap-2 flex-col justify-start items-start sm:flex-row sm:items-center sm:flex-1 sm:justify-between text-black cursor-pointer text-md">
          <span>
            <span class="font-semibold text-gray-500 uppercase">{{ element.key }}:</span>
            {{ element.title }}
          </span>
          </Link>
        </div>
        <div class="flex gap-x-3 items-center">
          <Tooltip label="Subtasks" v-if="element.children_count > 0">
            <span class="flex items-center">
                <button
                  class="hover:text-gray-800 hover:bg-gray-100 w-5 h-5 rounded-full flex items-center justify-center">
                  <SubtaskIcon class="h-3 w-3" />
                </button>
                <span class="text-xs">{{ element.children_count }}</span>
            </span>
          </Tooltip>
          <Tooltip label="Comments" v-if="element.total_comments > 0">
            <span class="flex items-center">
                <button
                  class="hover:text-gray-800 hover:bg-gray-100 w-5 h-5 rounded-full flex items-center justify-center">
                  <ChatBubbleOvalLeftIcon class="h-3 w-3" />
                </button>
                <span class="text-xs">{{ element?.total_comments }}</span>
            </span>
          </Tooltip>

          <TaskDueDateForm
            :element="element"
            :task-id="element.id" />

          <TaskAssigneeForm
            :members="element.project?.members"
            :assignee="element.assignee"
            :task="element" />

          <TaskCodeForm
            :codes="element.project.codes"
            :task="element" code-type="type"
            :code-value="element.type?.id">
            <Tooltip label="Type">
              <TaskTypeBadge :type="element.type" />
            </Tooltip>
          </TaskCodeForm>

          <TaskCodeForm
            :codes="element.project.codes"
            :task="element"
            code-type="priority"
            :code-value="element.priority?.id">
            <Tooltip label="Priority">
              <TaskTypeBadge :type="element.priority" />
            </Tooltip>
          </TaskCodeForm>
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
  element: Object
});
const disabled = computed(() => props.element.project?.is_archived || !props.element.project.can?.manage);

</script>

<style scoped>

</style>