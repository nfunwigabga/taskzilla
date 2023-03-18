<template>
  <Head>
    <title>Register</title>
  </Head>
  <div>
    <Teleport to="#title" v-if="isMounted">
      Sign up
    </Teleport>

    <BaseAlert title="Status" v-if="status">{{ status }}</BaseAlert>

    <template v-if="!invitation || !form.email">
      <BaseAlert title="Invalid invitation" type="danger">
        <p class="leading-relaxed">You need a valid invitation to join this platform.
          Ask the site admin to resend the invitation link.</p>
      </BaseAlert>
    </template>

    <form @submit.prevent="submit" v-else class="mt-2 space-y-4">
      <div class="grid grid-cols-2 gap-3">
        <div class="col-span-2">
          <BaseFormInput
            required
            :readonly="!!email"
            label="Email Address"
            placeholder="Email"
            id="user-email"
            v-model="form.email"
            :error="form.errors.email"
          />
        </div>
        <div class="col-span-2 md:col-span-1">
          <BaseFormInput
            autofocus
            required
            label="First Name"
            placeholder="Enter first name"
            id="first-name"
            v-model="form.first_name"
            :error="form.errors.first_name"
          />
        </div>
        <div class="col-span-2 md:col-span-1">
          <BaseFormInput
            required
            label="Last Name"
            placeholder="Enter last name"
            id="last-name"
            v-model="form.last_name"
            :error="form.errors.last_name"
          />
        </div>

        <div class="col-span-2 md:col-span-1">
          <BaseFormInput
            required
            label="Password"
            placeholder="Password"
            id="password"
            type="password"
            v-model="form.password"
            :error="form.errors.password"
          />
        </div>

        <div class="col-span-2 md:col-span-1">
          <BaseFormInput
            required
            label="Confirm Password"
            placeholder="Comfirm Password"
            id="password-confirmation"
            type="password"
            v-model="form.password_confirmation"
            :error="form.errors.password_confirmation"
          />
        </div>

        <div class="col-span-2 mt-2">
          <BaseFormButton :loading="form.processing">
            Create Account
          </BaseFormButton>
        </div>
      </div>


      <div class="mb-4 relative">
        <div class="absolute inset-0 flex items-center" aria-hidden="true">
          <div class="w-full border-t border-gray-300" />
        </div>
        <div class="relative flex justify-center text-sm">
          <span class="px-3 py-1 bg-white text-gray-600">
            Already a member?
          </span>
        </div>
      </div>

      <div class="text-xs text-center">
        <Link :href="route('login')"
              class="font-bold uppercase text-primary-500 hover:text-primary-800">
          Login
        </Link>
      </div>
    </form>
  </div>
</template>

<script setup>
import AuthLayout from "@/Layouts/AuthLayout.vue";
import { useMounted } from "@/Composables/useMounted";
import BaseAlert from "@/Components/BaseAlert.vue";
import BaseFormInput from "@/Components/BaseFormInput.vue";
import BaseFormButton from "@/Components/BaseFormButton.vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
  status: String,
  invitation: String,
  email: String
});

defineOptions({
  layout: AuthLayout
});

const form = useForm({
  last_name: "",
  first_name: "",
  email: props.email,
  password: "",
  password_confirmation: "",
  invitation: props.invitation
});

const { isMounted } = useMounted();

const submit = () => {
  form.post(route("register"), {
    onError: (error) => console.log(error),
    onFinish: (_) => form.reset("password", "password_confirmation")
  });
};
</script>


