<template>
  <div
    class="bg-white shadow rounded px-3 py-4 border border-white group">
    <div class="relative -mt-2 -mr-2">
      <button
        class="cursor-move handle absolute top-0 right-0 p-2 bg-white rounded-full opacity-100 md:opacity-0 group-hover:opacity-100">
        <DragHandleIcon class="h-4 w-4" />
      </button>
    </div>


    <Link :href="element?._links.self">
      <div class="flex items-start mb-3 text-base">
        <div class="line-clamp-1 text-md text-dark-700">
          <span class="text-xs font-bold" :class="{'line-through' : element.resolved}">
            {{ element.key }}
          </span> - {{ element?.title }}
        </div>
      </div>
    </Link>
    <!-- Badges -->
    <div class="flex flex-wrap gap-2">
      <TaskCodeForm :codes="element.project.codes" :task="element" code-type="type"
                    :code-value="element.type?.id">
        <Tooltip label="Type">
          <TaskTypeBadge :type="element.type" />
        </Tooltip>
      </TaskCodeForm>

      <TaskCodeForm :codes="element.project.codes" :task="element" code-type="priority"
                    :code-value="element.priority?.id">
        <Tooltip label="Priority">
          <TaskTypeBadge :type="element.priority" />
        </Tooltip>
      </TaskCodeForm>
    </div>

    <div class="flex items-center gap-x-2 mt-3">
      <TaskAssigneeForm :members="element.project?.members" :assignee="element.assignee" :task="element" />

      <TaskDueDateForm :element="element" :task-id="element.id" />

      <div class="ml-auto flex items-center gap-x-2 transition-all">
        <div class="flex items-center" v-if="element?.total_comments > 0">
          <Tooltip label="Comments">
              <span class="flex items-center">
                <button
                  class="hover:text-gray-800 hover:bg-gray-100 w-5 h-5 rounded-full flex items-center justify-center">
                  <ChatBubbleOvalLeftIcon class="h-4 w-4" />
                </button>
                <span class="text-xs">{{ element?.total_comments }}</span>
              </span>
          </Tooltip>
        </div>
        <div class="flex items-center" v-if="element.children_count > 0">
          <Tooltip label="Subtasks">
              <span class="flex items-center">
                  <button
                    class="hover:text-gray-800 hover:bg-gray-100 w-5 h-5 rounded-full flex items-center justify-center">
                    <SubtaskIcon class="h-3 w-3" />
                  </button>
                  <span class="text-xs">{{ element.children_count }}</span>
              </span>
          </Tooltip>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import {
  UserIcon,
  CalendarIcon,
  ChatBubbleOvalLeftIcon
} from "@heroicons/vue/24/outline";
import TaskCodeForm from "@/Components/Forms/TaskCodeForm.vue";
import TaskTypeBadge from "@/Components/Tasks/TaskTypeBadge.vue";
import TaskAssigneeForm from "@/Components/Forms/TaskAssigneeForm.vue";
import TaskDueDateForm from "@/Components/Forms/TaskDueDateForm.vue";
import SubtaskIcon from "@/Components/Icons/SubtaskIcon.vue";
import DragHandleIcon from "@/Components/Icons/DragHandleIcon.vue";
import { Tooltip } from "@spartez/vue-atlaskit-next";

const props = defineProps({
  element: Object
});


</script>

<style scoped>

</style>