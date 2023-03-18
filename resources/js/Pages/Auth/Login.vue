<template>
  <div>
    <Head title="Log in" />

    <Teleport to="#title" v-if="isMounted">
      Login
    </Teleport>


    <BaseAlert title="Status" v-if="status">{{ status }}</BaseAlert>

    <form @submit.prevent="submit" class="mt-2 space-y-4">
      <BaseFormInput
        label="Email address"
        placeholder="Email"
        id="email-address"
        :autofocus="true"
        v-model="form.email"
        :error="form.errors?.email"
      />
      <BaseFormInput
        required
        label="Password"
        placeholder="Password"
        id="password"
        type="password"
        v-model="form.password"
        :error="form.errors?.password"
      />
      <div>
        <BaseFormButton :loading="form.processing">Sign in</BaseFormButton>
      </div>
      <div class="flex items-center mt-4 justify-center">
        <Link
          class="font-bold text-xs uppercase text-primary-500 hover:text-primary-800"
          :href="route('password.request')"
        >
          Forgot your password?
        </Link>
      </div>
    </form>

    <BaseAlert v-if="demo" class="mt-2" type="info" title="Demo Users">
      <p class="font-semibold">Admin User</p>
      <p>Email: admin@taskzilla.com</p>
      <p>Password: password</p>
      <hr class="my-2" />
      <p class="font-semibold">Regular User</p>
      <p>Email: user@taskzilla.com</p>
      <p>Password: password</p>
    </BaseAlert>

  </div>
</template>

<script setup>
import AuthLayout from "@/Layouts/AuthLayout.vue";
import { useMounted } from "@/Composables/useMounted";
import BaseAlert from "@/Components/BaseAlert.vue";
import BaseFormInput from "@/Components/BaseFormInput.vue";
import BaseFormButton from "@/Components/BaseFormButton.vue";
import { InlineDialog } from "@spartez/vue-atlaskit-next";

defineProps({
  status: String,
  demo: Boolean
});

defineOptions({
  layout: AuthLayout
});

const form = useForm({
  email: "",
  password: "",
  remember: false
});

const { isMounted } = useMounted();

const submit = () => {
  form.post(route("login"), {
    onSuccess: () => console.log("Done"),
    onError: (error) => console.log(error),
    onFinish: () => form.reset("password")
  });
};
</script>

