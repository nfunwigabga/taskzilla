<template>
  <div>
    <Head title="Forgot password" />

    <Teleport to="#title" v-if="isMounted">
      Forgotten Password
    </Teleport>


    <BaseAlert title="Status" v-if="status">{{ status }}</BaseAlert>

    <div class="mb-2 text-sm text-gray-600">
      Forgot your password? No problem. Just let us know your email address and
      we will email you a password reset link that will allow you to choose a
      new one.
    </div>

    <form @submit.prevent="submit" class="mt-3 space-y-6">
      <BaseFormInput
        required
        label="Email address"
        placeholder="Email"
        id="email-address"
        :autofocus="true"
        v-model="form.email"
        :error="form.errors?.email"
      />

      <div>
        <BaseFormButton :loading="form.processing">
          Email Password Reset Link
        </BaseFormButton>
      </div>

      <div class="my-6 relative">
        <div class="absolute inset-0 flex items-center" aria-hidden="true">
          <div class="w-full border-t border-gray-300" />
        </div>
        <div class="relative flex justify-center text-sm">
          <span class="px-3 py-1 bg-white text-gray-600"> OR </span>
        </div>
      </div>
      <div class="text-xs text-center">
        <Link
          :href="route('login')"
          class="font-bold uppercase text-primary-500 hover:text-primary-800"
        >
          Go to login
        </Link>
      </div>
    </form>
  </div>
</template>
<script setup>
import { useMounted } from "@/Composables/useMounted";
import AuthLayout from "@/Layouts/AuthLayout.vue";
import BaseFormButton from "@/Components/BaseFormButton.vue";
import BaseAlert from "@/Components/BaseAlert.vue";
import BaseFormInput from "@/Components/BaseFormInput.vue";


defineProps({
  status: String
});

defineOptions({
  layout: AuthLayout
});

const form = useForm({
  email: ""
});

const { isMounted } = useMounted();

const submit = () => {
  form.post(route("password.email"));
};
</script>


