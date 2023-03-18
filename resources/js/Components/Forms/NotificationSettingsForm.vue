<template>
  <form @submit.prevent="submit">
    <ul role="list" class="mt-2 divide-y divide-gray-200">
      <SwitchGroup
        v-for="(setting, index) in settings"
        :key="setting.id"
        as="li"
        class="flex items-center justify-between py-4">
        <div class="flex flex-col">
          <SwitchLabel as="p" class="text-sm font-medium text-gray-900" passive>
            {{ setting.title }}
          </SwitchLabel>
          <SwitchDescription class="text-sm text-gray-500">
            {{ setting.description }}
          </SwitchDescription>
        </div>
        <Switch v-model="form[setting.id]"
                :class="[form[setting.id] ? 'bg-primary-500' : 'bg-gray-200', 'relative ml-4 inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2']">
            <span aria-hidden="true"
                  :class="[form[setting.id] ? 'translate-x-5' : 'translate-x-0', 'inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out']" />
        </Switch>
      </SwitchGroup>
    </ul>
    <div class="text-end mt-4">
      <BaseFormButton
        class="px-4"
        :disabled="!form.isDirty"
        :block="false"
        :loading="form.processing"
      >
        Save settings
      </BaseFormButton>
    </div>
  </form>
</template>

<script setup>
import { Switch, SwitchDescription, SwitchGroup, SwitchLabel } from "@headlessui/vue";
import BaseFormButton from "@/Components/BaseFormButton.vue";

const props = defineProps({
  user: Object
});

const form = useForm({
  email_when_invited: props.user.notification?.email_when_invited,
  email_when_invited_responded: props.user.notification?.email_when_invited_responded,
  email_when_assigned: props.user.notification?.email_when_assigned,
  email_on_comment_assignee: props.user.notification?.email_on_comment_assignee,
  email_on_comment_reporter: props.user.notification?.email_on_comment_reporter,
  email_on_project_add: props.user.notification?.email_on_project_add,
  email_on_task_resolved: props.user.notification?.email_on_task_resolved
});

async function submit() {
  await form.put(route("profile.notifications"), {
    onSuccess: () => null,
    onError: () => null
  });
}


const settings = [
  {
    id: "email_when_invited",
    title: "Email on new invitation",
    description:
      "Send me an email notification I am invited to a new team."
  },
  {
    id: "email_when_invited_responded",
    title: "Email on invitation response",
    description:
      "Send me an email when someone responds to my team invitation."
  },
  {
    id: "email_when_assigned",
    title: "Email when task assigned",
    description:
      "Send me an email notification when a task is assigned to me."
  },
  {
    id: "email_on_comment_assignee",
    title: "Email on new comment when I am assignee",
    description: "Send me an email when someone comments on a task assigned to me."
  },
  {
    id: "email_on_comment_reporter",
    title: "Email on new comment when I am reporter",
    description: "Send me an email when someone comments on a task reported by me."
  },
  {
    id: "email_on_project_add",
    title: "Email when I am added to a project",
    description: "Email me when I am added to any new project."
  },
  {
    id: "email_on_task_resolved",
    title: "Email when task is resolved",
    description: "Email me a task I reported is marked as resolved."
  }
];
</script>

<style scoped>

</style>