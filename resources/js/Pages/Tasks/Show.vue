<template>
  <ShowTaskModal>
    <template #title>
      <div class="h-18 flex items-center gap-x-4 justify-between">
        <Tooltip :label="resolvedLabel">
          <button @click.prevent="resolve"
                  :disabled="isUpdatingStatus || project.is_archived || !can_resolve"
                  :class="task.resolved ? 'border-green-600 text-green-600' : 'border-gray-300 text-gray-600'"
                  class="h-7 transition-colors font-medium text-xs flex items-center gap-x-1 px-2 rounded border hover:border-green-600 hover:!bg-green-50 hover:!text-green-600">
            <ArrowPathIcon v-if="isUpdatingStatus" class="h-4 animate-spin" />
            <CompletedIcon v-else-if="task.resolved" class="h-4" />
            <CheckCircleIcon v-else class="h-4" />
            {{ task.resolved ? "Resolved" : "Mark as resolved" }}
          </button>
        </Tooltip>
      </div>
    </template>
    <div class="text-md font-semibold text-gray-500 px-4 mb-2" v-if="task.parent">
      Is sub-task of
      <Link :href="route('tasks.show', [task.parent?.project, task.parent?.key])"
            class="text-primary-700">
        {{ task.parent.key }}:
        {{ task.parent.title }}
      </Link>
    </div>
    <div class="text-2xl font-semibold px-4 mb-2">
      <TaskTitleEditorForm :task="task" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-0 md:gap-y-1 px-4 py-4">
      <div class="col-span-1 flex items-center">
        <label class="heading-label">
          Created
        </label>
        <Tooltip :label="task.dates?.created_at_long">
          <span class="text-sm">{{ task.dates?.created_at_human }}</span>
        </Tooltip>
      </div>
      <div class="col-span-1 flex items-center">
        <label class="heading-label">
          Last updated
        </label>
        <Tooltip :label="task.dates?.updated_at_long">
          <span class="text-sm">{{ task.dates?.updated_at_human }}</span>
        </Tooltip>
      </div>
      <div class="col-span-1 flex items-center">
        <label class="heading-label">
          Reported by
        </label>
        <span class="flex items-center gap-x-2 cursor-pointer text-sm">
            <button class="rounded-full outline-none border p-0.5 border-gray-400 border-dashed">
              <BaseAvatar :avatar="task.reporter?.avatar" class="h-5 w-5" />
            </button>
            {{ task.reporter?.name }}
        </span>
      </div>
      <div class="col-span-1 flex items-center">
        <label class="heading-label">
          Assignee
        </label>
        <TaskAssigneeForm show-name :members="task.project?.members" :assignee="task.assignee" :task="task" />
      </div>
      <div class="col-span-1 flex items-center">
        <label class="heading-label">
          Due date
        </label>
        <TaskDueDateForm :element="task" :task-id="task.id">
          <button class="rounded-full outline-none border p-1 border-gray-400 border-dashed">
                <span class="text-xs" v-if="task.due_date?.mmddyyyy">
                  {{ task.due_date?.mmddyyyy }}
                </span>
            <CalendarIcon v-else class="h-4 w-4 text-gray-500" />
          </button>
        </TaskDueDateForm>
      </div>
      <div class="col-span-1 flex items-center">
        <label class="heading-label">
          Priority
        </label>
        <TaskCodeForm :codes="task.project.codes" :task="task" code-type="priority"
                      :code-value="task.priority?.id">
          <TaskTypeBadge :type="task.priority" />
        </TaskCodeForm>
      </div>
      <div class="col-span-1 flex items-center">
        <label class="heading-label">
          Type
        </label>
        <TaskCodeForm :codes="task.project.codes" :task="task" code-type="type"
                      :code-value="task.type?.id">
          <TaskTypeBadge :type="task.type" />
        </TaskCodeForm>
      </div>

    </div>

    <section class="mb-2 py-2 border-b text-sm">
      <TabGroup>
        <TabList class="border-b border-gray-200 flex gap-x-4 px-4">
          <Tab
            v-for="tab in tabs"
            :key="tab.id"
            as="template"
            v-slot="{ selected }">
            <button :aria-current="selected ? 'page' : undefined"
                    :class="[selected ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300', 'outline-0 whitespace-nowrap pb-2 px-1 border-b-2 font-medium text-sm']">
              {{ tab.name }}
            </button>
          </Tab>
        </TabList>
        <TabPanels class="mt-2">
          <TabPanel class="p-4">
            <TaskDescriptionForm :task="task" />
          </TabPanel>
          <TabPanel class="p-4">
            <TaskAttachmentForm
              :task="task"
              :endpoint="route('tasks.upload', [route().params.project, props.task.id])"
              @upload-successful="handleUploadSuccess"
            />

            <div class="flex items-start flex-wrap gap-3">
              <TaskAttachmentItem
                v-for="attachment in task.attachments"
                :key="attachment.id"
                :attachment="attachment"
                @deleted="handleOnDelete" />
            </div>
          </TabPanel>
          <TabPanel class="p-8 max-h-60 overflow-y-auto">
            <TaskActivityFeed :activities="activities" />
          </TabPanel>
        </TabPanels>
      </TabGroup>
    </section>


    <!-- CHILDREN-->
    <section class="sections">
      <Disclosure v-slot="{ open }" default-open>
        <div class="w-full gap-x-2 flex text-left items-center  mb-2">
          <DisclosureButton class="section-heading flex flex-1 items-center gap-x-2">
            <ChevronUpIcon
              :class="open ? 'rotate-180 transform' : 'rotate-90'"
              class="h-3 w-3 text-slate-500"
            />
            <span>Subtasks</span>
            <span v-if="task.children.length"
                  class="bg-dark-200 text-gray-900 py-0.5 px-2.5 rounded-full text-xs font-medium md:inline-block">
              {{ task.children.length }}
            </span>
          </DisclosureButton>
          <div v-if="!project.is_archived" class="ml-auto">
            <button @click.prevent="showSubtaskForm=true"
                    class="h-7 rounded-full text-gray-900 hover:text-black hover:bg-gray-100 flex items-center text-xxs uppercase font-semibold px-1">
              <PlusIcon class="h-4" />
              <span>Add subtask</span>
            </button>
            <BaseModal class="p-5 sm:p-10"
                       @close="showSubtaskForm=false"
                       :is-open="showSubtaskForm">
              <template #title>Create Sub-Task</template>
              <TaskForm
                :close="() => showSubtaskForm=false"
                :section="task.section.id"
                :codes="task.project.codes"
                :parent-id="task.id" />
            </BaseModal>
          </div>
        </div>
        <DisclosurePanel class="max-h-[10rem] overflow-y-auto">
          <template v-if="task.children.length">
            <ul class="section-scrollable-content">
              <SubtaskListItem
                v-for="subtask in task.children"
                :task="subtask"
                :key="subtask.id"
                :codes="project.codes"
                :members="project.members" />
            </ul>
          </template>
        </DisclosurePanel>
      </Disclosure>
    </section>

    <!-- RELATED TASKS -->
    <section class="sections">
      <Disclosure v-slot="{ open }">
        <div class="w-full gap-x-2 flex text-left items-center  mb-2">
          <DisclosureButton class="section-heading flex flex-1 items-center gap-x-2">
            <ChevronUpIcon
              :class="open ? 'rotate-180 transform' : 'rotate-90'"
              class="h-3 w-3 text-slate-500"
            />
            <span>Linked (related) tasks</span>
            <span v-if="totalRelated"
                  class="bg-dark-200 text-gray-900 py-0.5 px-2.5 rounded-full text-xs font-medium md:inline-block">
              {{ totalRelated }}
            </span>
          </DisclosureButton>
          <div class="ml-auto" v-if="!project.is_archived">
            <button
              :disabled="showRelatedForm"
              @click="showRelatedForm=true"
              class="h-7 rounded-full text-gray-900 hover:text-black hover:bg-gray-100 flex items-center text-xxs uppercase font-semibold px-1">
              <PlusIcon class="h-4" />
              Add related task
            </button>
            <BaseModal
              class="max-w-mdx min-h-[20rem]"
              @close="showRelatedForm=false"
              :is-open="showRelatedForm">
              <template #title>Link related task</template>
              <RelatedTasksSearchForm
                :relations="relations"
                :title="task.display"
                :task-id="task.id"
                @cancel="showRelatedForm=false" />
            </BaseModal>
          </div>
        </div>

        <DisclosurePanel>

          <div class="section-scrollable-content" v-if="Object.keys(relatedTasks).length">
            <div class="px-6" v-for="related in Object.keys(relatedTasks)" :key="related">
              <div class="font-semibold text-xxs uppercase">{{ related }}</div>
              <ul>
                <SubtaskListItem
                  v-for="relatedItem in relatedTasks[related]"
                  :key="relatedItem.id"
                  :task="relatedItem"
                  :related-id="task.id"
                  :codes="project.codes"
                  :members="project.members" />
              </ul>
            </div>
          </div>
        </DisclosurePanel>
      </Disclosure>
    </section>

    <!-- COMMENTS -->
    <section class="sections !border-0">
      <h4 class="section-heading mb-2 flex items-center">
        Comments
      </h4>
      <p class="text-gray-500" v-if="!task.comments?.length">No comments yet</p>
      <TaskComments :task="task" v-else />
    </section>

    <template #footer>
      <TaskCommentForm :task="task" :disabled="isEditing || project.is_archived" />
    </template>
  </ShowTaskModal>

</template>

<script setup>
import {
  CheckCircleIcon,
  ChevronUpIcon,
  PlusIcon,
  CalendarIcon,
  PaperClipIcon,
  ArrowPathIcon
} from "@heroicons/vue/24/outline";
import { CheckCircleIcon as CompletedIcon } from "@heroicons/vue/24/solid";
import {
  Disclosure,
  DisclosureButton,
  DisclosurePanel,
  TabGroup, TabList, TabPanels, TabPanel, Tab
} from "@headlessui/vue";
import TaskDescriptionForm from "@/Components/Forms/TaskDescriptionForm.vue";
import TaskComments from "@/Components/Tasks/TaskComments.vue";
import SubtaskIcon from "@/Components/Icons/SubtaskIcon.vue";
import ShowTaskModal from "@/Components/Tasks/ShowTaskModal.vue";
import BaseAvatar from "@/Components/BaseAvatar.vue";
import TaskAssigneeForm from "@/Components/Forms/TaskAssigneeForm.vue";
import TaskDueDateForm from "@/Components/Forms/TaskDueDateForm.vue";
import TaskCodeForm from "@/Components/Forms/TaskCodeForm.vue";
import TaskTypeBadge from "@/Components/Tasks/TaskTypeBadge.vue";
import BaseModal from "@/Components/BaseModal.vue";
import TaskForm from "@/Components/Forms/TaskForm.vue";
import SubtaskListItem from "@/Components/Tasks/SubtaskListItem.vue";
import RelatedTasksSearchForm from "@/Components/Forms/RelatedTasksSearchForm.vue";
import TaskCommentForm from "@/Components/Tasks/TaskCommentForm.vue";
import { computed, ref } from "vue";
import { useComment } from "@/Composables/useComment";
import TaskActivityFeed from "@/Components/Tasks/TaskActivityFeed.vue";
import { Tooltip } from "@spartez/vue-atlaskit-next";
import TaskTitleEditorForm from "@/Components/Forms/TaskTitleEditorForm.vue";
import TaskAttachmentForm from "@/Components/Forms/TaskAttachmentForm.vue";
import TaskAttachmentItem from "@/Components/Tasks/TaskAttachmentItem.vue";

const props = defineProps({
  task: Object,
  project: Object,
  relations: Array,
  relatedTasks: Object,
  activities: Object,
  can_resolve: Boolean
});
const showSubtaskForm = ref(false);
const showRelatedForm = ref(false);
const { isEditing } = useComment();
const isUpdatingStatus = ref(false);
const attachments = ref(props.task?.attachments);

const tabs = [
  { id: "details", name: "Details" },
  { id: "attachments", name: "Attachments" },
  { id: "activities", name: "Activities" }
];

const totalRelated = computed(() => {
  let total = 0;

  Object.keys(props.relatedTasks).forEach(key => {
    total = total + (props.relatedTasks[key]?.length || 0);
  });

  return total;
});
const resolvedLabel = computed(() => {
  if (!props.can_resolve) {
    return "There are unresolved subtasks";
  }
  return props.task.resolved ? "Re-open" : "Mark as resolved";
});

function resolve() {
  isUpdatingStatus.value = true;
  router.put(route("tasks.resolve", [
    route().params.project,
    props.task.id
  ]), {}, {
    onFinish: () => isUpdatingStatus.value = false
  });
}

function handleUploadSuccess(data) {
  attachments.value.push(data);
}

function handleOnDelete() {
  attachments.value = props.task?.attachments;
}
</script>

<style scoped>
.heading-label {
  @apply font-semibold;
  @apply w-28 h-9 flex items-center text-xxs;
  @apply text-gray-700 uppercase;
}

.sections {
  @apply mt-2 px-4 py-2;
  @apply border-b;
}

.section-scrollable-content {
  @apply max-h-[10rem] overflow-y-auto;
}

.section-heading {
  @apply font-semibold text-gray-800 text-xs uppercase;
}
</style>