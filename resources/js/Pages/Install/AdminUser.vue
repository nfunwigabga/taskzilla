<template>
  <div class="gap-4 px-20 py-4">

    <form @submit.prevent="submit" class="mt-2 space-y-2 px-28">
      <BaseAlert type="info" title="Create Admin User">
        Let's create your admin user profile. You're almost done!
      </BaseAlert>

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
      </div>


      <div class="flex items-center justify-between pt-6">
        <div>
          <BaseFormButton
            @click="$inertia.get(route('install.mail'), {}, {preserveScroll: true})"
            color="light"
            type="button">
            <ArrowLeftIcon class="h-4 mr-1" />
            Back
          </BaseFormButton>
        </div>
        <div>
          <BaseFormButton
            :loading="form.processing">
            Proceed
            <ArrowRightIcon class="h-4 ml-1" />
          </BaseFormButton>
        </div>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ArrowRightIcon, ArrowLeftIcon } from "@heroicons/vue/24/outline";
import InstallLayout from "@/Layouts/InstallLayout.vue";
import { useForm } from "@inertiajs/vue3";
import BaseFormInput from "@/Components/BaseFormInput.vue";
import BaseFormButton from "@/Components/BaseFormButton.vue";
import BaseAlert from "@/Components/BaseAlert.vue";

defineOptions({
  layout: InstallLayout
});


const form = useForm({
  last_name: "",
  first_name: "",
  email: "",
  password: "",
  password_confirmation: ""
});


function submit() {
  form.post(route("install.admin"), {
    preserveScroll: true,
    onSuccess: () => console.log("done"),
    onError: (e) => console.log(e)
  });
}
</script>

<style scoped>

</style>