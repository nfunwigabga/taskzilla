<template>
  <Head>
    <title>{{project?.name}}</title>
  </Head>

  <ProjectNav v-if="project" :project="project" />
  <div class="px-4 md:px-0 py-10">
    <BasePage>
      <BaseCard>
        <template #header v-if="project.can.manage && !project.is_archived">
          <ProjectCodeForm type="TASK_SECTION">
            <button
              class="flex text-primary-100 bg-primary-600 hover:bg-primary-700 items-center justify-center text-sm rounded-md border px-2 py-1">
              <PlusIcon class="h-4" />
              Add section
            </button>
          </ProjectCodeForm>
        </template>
        <Draggable
          :disabled="project.is_archived"
          group="sections"
          itemKey="id"
          ghost-class="draggable-ghost"
          tag="div"
          handle=".handle"
          class="space-y-2 -ml-4"
          :list="tasksData"
          @change="onSectionDrag">
          <template #item="{ element, index }">
            <div class="rounded-lg border border-dashed border-transparent">
              <Disclosure :defaultOpen="index===0" v-slot="{ open, close }">
                <div
                  class="group flex items-center w-full rounded-lg py-2 text-left text-base font-bold text-gray-900 focus:outline-none focus-visible:ring focus-visible:ring-purple-500 focus-visible:ring-opacity-75">
                  <button class="cursor-grab handle mr-4 opacity-0 group-hover:opacity-100">
                    <DragHandleIcon class="h-4 w-4" />
                  </button>
                  <DisclosureButton>
                    <FullArrowRightIcon
                      :class="open ? 'rotate-90 transform' : ''"
                      class="h-4 w-4 text-gray-900 mr-2" />
                  </DisclosureButton>
                  <span>{{ element.display }}</span>

                  <div class="flex items-center gap-x-4 ml-4" v-if="!project.is_archived">
                    <template v-if="project.can.manage">
                      <ProjectCodeForm :element="element">
                        <button
                          class="bg-slate-100 flex items-center text-xs opacity-100 md:opacity-0 group-hover:opacity-100 p-0.5 border border-gray-100 rounded">
                          <PencilIcon class="h-4 w-4" />
                        </button>
                      </ProjectCodeForm>
                    </template>

                    <TaskCreateForm :codes="project.codes" :section="element.id ">
                      <Tooltip label="Add task">
                        <button
                          class="bg-slate-100 flex items-center text-xs opacity-100 md:opacity-0 group-hover:opacity-100 p-0.5 border border-gray-100 rounded">
                          <PlusIcon class="h-4 w-4" />
                          <span class="sr-only">Add task</span>
                        </button>
                      </Tooltip>
                    </TaskCreateForm>
                  </div>
                </div>

                <DisclosurePanel class="py-2 text-sm text-gray-500">
                  <Draggable
                    :disabled="project.is_archived"
                    group="tasks"
                    itemKey="id"
                    tag="ul"
                    handle=".handle"
                    ghost-class="task-ghost"
                    class="border-gray-200"
                    :list="element.tasks"
                    @change="onTaskDrag"
                    @end="onTaskDrag">
                    <template #item="{ element: el, ix }">
                      <TaskDraggableListItem :element="el" />
                    </template>
                  </Draggable>

                </DisclosurePanel>
              </Disclosure>
            </div>
          </template>
        </Draggable>
      </BaseCard>
    </BasePage>
  </div>
</template>

<script setup>
import {
  Disclosure,
  DisclosureButton,
  DisclosurePanel
} from "@headlessui/vue";

import { unassignedFilter } from "@/Helpers/helpers";
import { useMounted } from "@/Composables/useMounted";
import Draggable from "vuedraggable";
import {
  PlusIcon,
  PencilIcon
} from "@heroicons/vue/24/outline";
import ProjectNav from "@/Components/Project/ProjectNav.vue";
import BasePage from "@/Components/BasePage.vue";
import BaseCard from "@/Components/BaseCard.vue";
import ProjectCodeForm from "@/Components/Forms/ProjectCodeForm.vue";
import DragHandleIcon from "@/Components/Icons/DragHandleIcon.vue";
import FullArrowRightIcon from "@/Components/Icons/FullArrowRightIcon.vue";
import TaskCreateForm from "@/Components/Forms/TaskCreateForm.vue";
import TaskDraggableListItem from "@/Components/Tasks/TaskDraggableListItem.vue";
import { Tooltip } from "@spartez/vue-atlaskit-next";
import { ref, watch } from "vue";

const props = defineProps({
  project: Object,
  codes: Object,
  filters: Object,
  sections: Array
});

const form = ref({
  q: props.filters.q,
  types: props.filters.types || [],
  priorities: props.filters.priorities || [],
  assignee: null,
  reporter: null,
  sort_by: null
});

const searching = ref(false);
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

</style>