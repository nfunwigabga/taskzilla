<template>
  <form @submit.prevent="submit" class="grid grid-cols-12 gap-4">
    <div class="col-span-12">
      <BaseFormInput
        required
        type="password"
        label="Current Password"
        placeholder="Enter your current password"
        :autofocus="true"
        id="current-password"
        v-model="form.current_password"
        :error="form.errors.current_password"
      />
    </div>
    <div class="col-span-12 md:col-span-6">
      <BaseFormInput
        required
        type="password"
        label="New Password"
        placeholder="Enter your new password"
        id="new-password"
        v-model="form.new_password"
        :error="form.errors.new_password"
      />
    </div>
    <div class="col-span-12 md:col-span-6">
      <BaseFormInput
        required
        type="password"
        label="Confirm New Password"
        placeholder="Re-enter your new password"
        id="new-password-confirmation"
        v-model="form.new_password_confirmation"
        :error="form.errors.new_password_confirmation"
      />
    </div>

    <div class="col-span-12 text-end">
      <BaseFormButton class="px-8" :block="false" :loading="form.processing">
        Change Password
      </BaseFormButton>
    </div>
  </form>
</template>

<script setup>
import BaseFormButton from "@/Components/BaseFormButton.vue";
import BaseFormInput from "@/Components/BaseFormInput.vue";

const props = defineProps({
  user: Object
});

const form = useForm({
  current_password: "",
  new_password: "",
  new_password_confirmation: ""
});

function submit() {
  form.put(route("profile.password"), {
    onSuccess: () => form.reset(),
    onError: () => null
  });
}


</script>

<style scoped>

</style>