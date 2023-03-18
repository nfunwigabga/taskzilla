<template>
  <form @submit.prevent="submit" class="space-y-4 z-50">
    <BaseFormInput
      required
      label="Task title"
      placeholder="Enter descriptive task title"
      id="title"
      v-model="form.title"
      :error="form.errors?.title"
    />

    <div class="grid grid-cols-2 gap-4">
      <div class="grid-col-2 md:grid-col-1">
        <BaseFormColorPicker
          label="Task type"
          :options="parentId ? filtered(type) : type"
          v-model="form.type"
          value-field="id"
          label-field="display"
          color-field="color"
          placeholder="Select task type"
          :error="form.errors?.type"
        />
      </div>
      <div class="grid-col-2 md:grid-col-1">
        <BaseFormColorPicker
          label="Priority"
          :options="parentId ? filtered(priority) : priority"
          v-model="form.priority"
          value-field="id"
          label-field="display"
          color-field="color"
          placeholder="Select task priority"
          :error="form.errors?.priority"
        />
      </div>
      <div class="grid-col-2 md:grid-col-1">
        <BaseFormColorPicker
          :disabled="!!section"
          label="Section"
          :options="section"
          v-model="form.section"
          value-field="id"
          label-field="display"
          color-field="color"
          placeholder="Select task section"
          :error="form.errors?.section"
        />
      </div>

      <div class="grid-col-2 md:grid-col-1">
        <BaseFormUserPicker
          label="Assign to"
          :options="assignees"
          v-model="form.assignee"
          value-field="id"
          label-field="name"
          placeholder="Assign to"
          :error="form.errors?.assignee"
        />
      </div>
    </div>

    <BaseFormRichTextEditor
      placeholder="Description"
      label="Description"
      v-model="form.description"
      :error="form.errors?.description" />

    <div class="flex items-center justify-end gap-x-2">
      <button @click="cancel(close)"
              type="button"
              class="px-2 py-1 bg-danger-100 border border-danger-200 rounded-md text-xs">
        Cancel
      </button>
      <BaseFormButton class="text-xs px-2 py-1" :block="false" :loading="form.processing">
        Create task
      </BaseFormButton>
    </div>
  </form>
</template>

<script setup>
import { useForm, usePage } from "@inertiajs/vue3";

import { unassigned } from "@/Helpers/helpers";
import BaseFormInput from "@/Components/BaseFormInput.vue";
import BaseFormButton from "@/Components/BaseFormButton.vue";
import BaseFormRichTextEditor from "@/Components/BaseFormRichTextEditor.vue";
import { computed } from "vue";
import BaseFormColorPicker from "@/Components/BaseFormColorPicker.vue";
import BaseFormUserPicker from "@/Components/BaseFormUserPicker.vue";

const props = defineProps({
  section: String,
  codes: Object,
  parentId: {
    type: String,
    default: null
  },
  close: {
    type: Function,
    default: () => null
  }
});

const { type, priority, section } = props.codes;


const form = useForm({
  title: "",
  description: "",
  priority: "",
  section: props.section || "",
  type: "",
  assignee: null,
  parent: props.parentId
});

const assignees = computed(() => [unassigned, ...usePage().props?.project?.members]);

function filtered(codes) {
  return codes.filter(c => c.available_in_subtask);
}

function cancel() {
  form.reset();
  props.close();
}

function submit() {
  form.post(route("tasks.store", [
    route().params.project
  ]), {
    preserveScroll: true,
    onSuccess: () => {
      props.close();
      form.reset();
    },
    onError: (error) => console.log(error)
  });
}

</script>

<style scoped>

</style>