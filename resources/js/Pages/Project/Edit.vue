<template>
  <BaseModalPage>
    <template #title>Edit {{ project.name }}</template>
    <div class="px-3">
      <form @submit.prevent="submit" class="p-4 space-y-4">
        <BaseFormInput
          required
          label="Project name"
          placeholder="Enter a project name"
          id="project-name"
          :autofocus="true"
          v-model="form.name"
          :error="form.errors?.name"
        />

        <div class="grid grid-cols-2 gap-x-4">
          <div class="col-span-1">
            <BaseFormInput
              type="date"
              label="Start date"
              id="start-date"
              v-model="form.start_date"
              :error="form.errors?.start_date"
            />
          </div>
          <div class="col-span-1">
            <BaseFormInput
              type="date"
              label="Due date"
              id="due-date"
              v-model="form.due_date"
              :error="form.errors?.due_date"
            />
          </div>
        </div>
        <BaseFormRichTextEditor
          label="Description"
          placeholder="Enter short project description"
          v-model="form.description"
          :error="form.errors?.description" />

        <div class="py-2">
          <h6 class="font-semibold text-sm">Project Members</h6>
          <ul>
            <li class="mt-2" v-for="user in users.data" :key="user.id">
              <label
                :class="{'bg-dark-100':user.id === auth.user?.id}"
                class="flex border text-sm w-full hover:bg-gray-100 justify-between items-center px-3 py-2 rounded-md cursor-pointer">
              <span class="flex items-center gap-x-2">
                <BaseAvatar class="h-6" :avatar="user.avatar" />
                {{ user.name }}
              </span>
                <input
                  :id="user.id"
                  :disabled="user.id === auth.user?.id"
                  class="rounded-full appearance-none checked:bg-primary-600 text-primary-600 focus:ring-primary-600 h-5 w-5"
                  :value="user.id"
                  v-model="form.members"
                  type="checkbox" />
              </label>
            </li>
          </ul>
        </div>

        <div class="mt-4">
          <BaseFormButton color="dark" :loading="form.processing">Update Project</BaseFormButton>
        </div>
      </form>
    </div>
  </BaseModalPage>
</template>

<script setup>
import BaseModalPage from "@/Components/BaseModalPage.vue";
import BaseFormButton from "@/Components/BaseFormButton.vue";
import BaseFormRichTextEditor from "@/Components/BaseFormRichTextEditor.vue";
import BaseFormInput from "@/Components/BaseFormInput.vue";
import BaseAvatar from "@/Components/BaseAvatar.vue";
import { useForm, usePage } from "@inertiajs/vue3";

const props = defineProps({
  users: Object,
  project: Object
});


const form = useForm({
  source: "full",
  name: props.project?.name,
  description: props.project?.description,
  due_date: props.project?.due_date,
  start_date: props.project?.start_date,
  members: props.project?.members?.map(m => m.id) || []
});

const { auth } = usePage().props;

function submit() {
  form.put(route("projects.update", [props.project?.id]), {
    preserveScroll: true,
    onError: (error) => console.log(error),
    onSuccess: (_) => isOpen.value = false
  });
}
</script>

<style scoped>

</style>