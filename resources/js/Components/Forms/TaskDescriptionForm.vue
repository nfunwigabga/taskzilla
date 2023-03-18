<template>
  <div v-if="!isEditing || task.project.is_archived" class="min-h-[4rem] rounded-md text-sm cursor-pointer"
       v-html="task.description"
       @click="isEditing = true" />

  <form v-else @submit.prevent="submit">
    <BaseFormRichTextEditor focus v-model="form.description" />
    <div class="flex justify-end gap-x-2 mt-4">
      <button @click="isEditing=false"
              type="button"
              class="px-2 py-1 bg-danger-100 border border-danger-200 rounded-md text-xs">
        Cancel
      </button>
      <BaseFormButton :block="false" :loading="form.processing">Save</BaseFormButton>
    </div>
  </form>
</template>

<script setup>
import BaseFormRichTextEditor from "@/Components/BaseFormRichTextEditor.vue";
import BaseFormButton from "@/Components/BaseFormButton.vue";

const props = defineProps({
  task: Object
});

const isEditing = ref(false);
const form = useForm({
  description: props.task.description
});

function handleBlur() {
  isEditing.value = false;
}

function submit() {
  form.put(route("tasks.update", [route().params.project, props.task.id]), {
    onSuccess: () => isEditing.value = false,
    preserveState: true,
    preserveScroll: true

  });
}
</script>

<style scoped>

</style>