<template>
  <div class="text-sm pb-4">
    <h4 class="text-xs">Profile photo</h4>
    <AvatarUploadForm />

    <form @submit.prevent="submit" class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-6">
      <div class="col-span-2">
        <BaseFormInput
          type="email"
          required
          readonly
          label="Email address"
          id="email"
          v-model="form.email"
          :error="form.errors.email"
        />
      </div>
      <div class="col-span-1">
        <BaseFormInput
          required
          label="First Name"
          id="first_name"
          v-model="form.first_name"
          :error="form.errors.first_name"
        />
      </div>
      <div class="col-span-1">
        <BaseFormInput
          required
          label="Last Name"
          id="last_name"
          v-model="form.last_name"
          :error="form.errors.last_name"
        />
      </div>
      <div class="col-span-2">
        <BaseFormInput
          label="Job title"
          placeholder="Enter your job title"
          id="job-title"
          v-model="form.job_title"
          :error="form.errors.job_title"
        />
      </div>

      <div class="col-span-1 md:col-span-2">
        <BaseFormTextArea
          label="About me"
          placeholder="Tell your teammates something about you!"
          v-model="form.about"
          :error="form.errors.about"
        />
      </div>

      <div class="col-span-2 text-right">
        <BaseFormButton :block="false" :disabled="!form.isDirty" :loading="form.processing">
          Save
        </BaseFormButton>
      </div>

    </form>
  </div>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import AvatarUploadForm from "@/Components/Forms/AvatarUploadForm.vue";
import BaseFormInput from "@/Components/BaseFormInput.vue";
import BaseFormTextArea from "@/Components/BaseFormTextArea.vue";
import BaseFormButton from "@/Components/BaseFormButton.vue";

const props = defineProps({
  user: Object
});

const form = useForm({
  first_name: props.user?.first_name,
  last_name: props.user?.last_name,
  email: props.user?.email,
  job_title: props.user?.job_title,
  about: props.user?.about
});

function submit() {
  form.put(route("profile.update"), {
    onSuccess: () => null,
    onError: () => null
  });
}
</script>

<style scoped>

</style>