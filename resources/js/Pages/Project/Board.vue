<template>
  <Head>
    <title>{{project.name}}</title>
  </Head>
  <div class="flex flex-col flex-1 bg-white">
    <ProjectNav v-if="project" :project="project" />
    <BasePage class="py-4 w-full flex items-center justify-between"
              v-if="project.can.manage && !project.is_archived">
      <BaseAvatarGroup :users="project.members" />
      <ProjectCodeForm type="TASK_SECTION">
        <button
          class="flex text-primary-100 bg-primary-600 hover:bg-primary-700 items-center justify-center text-sm rounded-md border px-2 py-1">
          <PlusIcon class="h-4" />
          Add section
        </button>
      </ProjectCodeForm>
    </BasePage>

    <div class="flex-1 pb-6 overflow-x-auto"
         :class="{'mt-4': !project.can.manage || project.is_archived }">
      <Draggable
        group="sections"
        itemKey="id"
        ghost-class="border-red-200"
        tag="div"
        handle=".handle"
        class="inline-flex h-full items-start px-4 pb-4 space-x-4"
        :list="tasksData"
        @change="onSectionDrag">
        <template #item="{ element, index }">
          <div class="w-72 bg-slate-100 px-3 py-3 max-h-full flex flex-col rounded-md">
            <div :class="`border-b-${element.color}-600`"
                 class="flex group mb-2 items-center justify-between px-0 pb-2 border-b-2 cursor-move handle">
              <div class="flex items-center gap-x-1">
                <h3 class="text-sm font-semibold text-gray-700">{{ element.display }}</h3>
                <span class="bg-dark-200 text-gray-900 py-0.5 px-2.5 rounded-full text-xs font-medium md:inline-block">
                  {{ element.tasks?.length }}
                </span>
              </div>
              <div class="flex items-center gap-x-1">
                <ArrowsPointingInIcon class="h-4 opacity-0 group-hover:opacity-100 " />
                <ProjectCodeForm :element="element">
                  <button v-if="project.can.manage">
                    <PencilSquareIcon class="w-4 h-4" />
                  </button>
                </ProjectCodeForm>
              </div>
            </div>

            <div
              class="flex flex-col overflow-hidden">
              <div class="flex-1 overflow-y-auto">
                <Draggable
                  :animation="200"
                  group="tasks"
                  itemKey="id"
                  tag="ul"
                  handle=".handle"
                  ghost-class="task-ghost"
                  class="space-y-3 max-h-[calc(100vh-22rem)] py-2 overflow-y-auto"
                  :list="element.tasks"
                  @change="onTaskDrag"
                  @end="onTaskDrag">
                  <template #item="{ element: el, ix }">
                    <TaskDraggableCard :element="el" />
                  </template>
                </Draggable>
              </div>
              <div class="px-3 mt-3 w-full flex items-center justify-center" v-if="!project.is_archived">
                <TaskCreateForm :codes="project.codes" :section="element.id ">
                  <button
                    class="flex transition-all duration-300 gap-x-1 items-center justify-center p-2 text-xs uppercase font-medium text-gray-600 hover:text-black hover:bg-slate-200 w-full rounded-md">
                    <PlusSmallIcon class="h-5 w-5"></PlusSmallIcon>
                    <span>Add Task</span>
                  </button>
                </TaskCreateForm>
              </div>
            </div>
          </div>
        </template>
      </Draggable>
    </div>
  </div>
</template>

<script setup>
import { Menu, MenuButton, MenuItem, MenuItems, PopoverButton } from "@headlessui/vue";
import { useMounted } from "@/Composables/useMounted";
import Draggable from "vuedraggable";
import {
  PlusSmallIcon,
  PlusIcon,
  ArrowsPointingInIcon,
  PencilSquareIcon,
  TrashIcon,
  ArrowLeftIcon,
  ArrowRightIcon,
  EllipsisHorizontalIcon
} from "@heroicons/vue/24/outline";
import { Float, FloatArrow } from "@headlessui-float/vue";
import ProjectCodeForm from "@/Components/Forms/ProjectCodeForm.vue";
import TaskCreateForm from "@/Components/Forms/TaskCreateForm.vue";
import TaskDraggableCard from "@/Components/Tasks/TaskDraggableCard.vue";
import ProjectNav from "@/Components/Project/ProjectNav.vue";
import BasePage from "@/Components/BasePage.vue";
import BaseAvatarGroup from "@/Components/BaseAvatarGroup.vue";

const props = defineProps({
  project: Object,
  codes: Object,
  sections: Array
});

const tasksData = ref(props.sections);

const { isMounted } = useMounted();

watch(() => props.sections, (value) => {
  tasksData.value = value;
});

function onSectionDrag(e) {
  if (e.moved) {
    const data = tasksData.value.map((section, index) => {
      return { sort_order: index + 1, id: section.id };
    });
    router.put(route("projects.draggable", [
      route().params.project
    ]), {
      payload: data,
      type: "section"
    }, {
      preserveScroll: true,
      onSuccess: () => tasksData.value = props.sections
    });
  }
}

function onTaskDrag(e) {
  if (e.added || e.moved) {
    const data = tasksData.value.flatMap(s => s.tasks.map(i => {
      return { task: i.id, section: s.id };
    }));

    router.put(route("projects.draggable", [
      route().params.project
    ]), {
      payload: data,
      type: "task"
    }, {
      preserveScroll: true,
      onSuccess: () => tasksData.value = props.sections
    });
  }
}


</script>

<style lang="scss">
.task-ghost {
  @apply opacity-30;
  @apply bg-primary-100 #{!important};
}
</style>