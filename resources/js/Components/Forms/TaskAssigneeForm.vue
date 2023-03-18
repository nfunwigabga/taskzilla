<template>
  <Tooltip v-if="disabled" :label="`Assignee: ${assignee?.name}`">
    <div class="flex items-center gap-x-2 cursor-pointer text-sm">
      <div class="rounded-full cursor-default outline-none border p-0.5 border-gray-400 border-dashed">
        <UserIcon v-if="!assignee?.id" class="h-4 w-4 text-gray-500" />
        <img v-else class="rounded-full h-5 w-5" alt="" :src="assignee?.avatar" />
      </div>
      <span v-if="showName">
          {{ assignee?.name }}
      </span>
    </div>
  </Tooltip>

  <Popper v-else
          arrow
          :show="showPopper"
          @close:popper="showPopper=false">
    <Tooltip :label="`Assignee: ${assignee?.name}`">
      <span class="flex items-center gap-x-2 cursor-pointer text-sm">
        <button @click.prevent="showPopper=true"
                class="rounded-full outline-none border p-0.5 border-gray-400 border-dotted">
          <UserIcon v-if="!assignee?.id" class="h-4 w-4 text-gray-500" />
          <img v-else class="rounded-full h-5 w-5" alt="" :src="assignee?.avatar" />
        </button>
        <span v-if="showName">
          {{ assignee?.name }}
        </span>
      </span>
    </Tooltip>

    <template #content="{ close }">
      <div class="min-w-[20rem] p-4">
        <form @submit.prevent="submit(close)" class="space-y-4">
          <BaseFormUserPicker
            label="Assign to"
            :options="assignees"
            v-model="form.assignee"
            value-field="id"
            label-field="name"
            placeholder="Assign to"
            :error="form.errors?.assignee" />

          <div class="flex items-center justify-end gap-x-2">
            <button @click.prevent="close"
                    type="button"
                    class="px-2 py-1 bg-danger-100 border border-danger-200 rounded-md text-xs">
              Cancel
            </button>
            <BaseFormButton
              class="text-xs px-2 py-1"
              :disabled="!form.isDirty"
              :block="false"
              :loading="form.processing">
              Save
            </BaseFormButton>
          </div>
        </form>
      </div>
    </template>

  </Popper>
</template>

<script setup>
import { unassigned } from "@/Helpers/helpers";
import { UserIcon } from "@heroicons/vue/24/outline";
import Popper from "vue3-popper";
import { computed, ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import BaseFormButton from "@/Components/BaseFormButton.vue";
import { Tooltip } from "@spartez/vue-atlaskit-next";
import BaseFormUserPicker from "@/Components/BaseFormUserPicker.vue";

const props = defineProps({
  assignee: Object,
  task: Object,
  members: Array,
  readonly: Boolean,
  showName: Boolean
});

const showPopper = ref(false);

const form = useForm({
  assignee: props.assignee?.id || null,
  field: "assignee"
});

const disabled = computed(() => props.readonly || props.task.project?.is_archived || !props.task.project.can?.manage);

const assignees = computed(() => [unassigned, ...props.members]);

function submit(close) {
  form.put(route("tasks.update", [
    props.task.project.id,
    props.task.id
  ]), {
    preserveScroll: true,
    preserveState: true,
    onError: (e) => console.log(e),
    onSuccess: (_) => {
      close();
    }
  });
}

</script>

<style scoped>

</style>