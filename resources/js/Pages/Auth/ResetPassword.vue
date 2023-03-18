<template>
  <div>
    <Head title="Reset Password" />

    <Teleport to="#title" v-if="isMounted">
      Reset Password
    </Teleport>

    <form @submit.prevent="submit" class="mt-4 space-y-6">
      <BaseFormInput
        required
        label="Email address"
        placeholder="Email"
        id="email-address"
        :autofocus="true"
        readonly
        v-model="form.email"
        :error="form.errors?.email"
      />

      <BaseFormInput
        required
        label="New Password"
        placeholder="Enter new password"
        id="password"
        type="password"
        :autofocus="true"
        v-model="form.password"
        :error="form.errors.password"
      />

      <BaseFormInput
        required
        label="Confirm new password"
        placeholder="Confirm new password"
        id="password-confirmation"
        type="password"
        v-model="form.password_confirmation"
        :error="form.errors.password_confirmation"
      />

      <div>
        <BaseFormButton :loading="form.processing">Reset Password</BaseFormButton>
      </div>
    </form>
  </div>
</template>

<script setup>
import { useMounted } from "@/Composables/useMounted";
import AuthLayout from "@/Layouts/AuthLayout.vue";
import BaseFormInput from "@/Components/BaseFormInput.vue";
import BaseFormButton from "@/Components/BaseFormButton.vue";


const props = defineProps({
  email: String,
  token: String
});

defineOptions({
  layout: AuthLayout
});

const form = useForm({
  token: props.token,
  email: props.email,
  password: "",
  password_confirmation: ""
});
const { isMounted } = useMounted();
const submit = () => {
  form.post(route("password.update"), {
    onFinish: () => form.reset("password", "password_confirmation")
  });
};
</script>

