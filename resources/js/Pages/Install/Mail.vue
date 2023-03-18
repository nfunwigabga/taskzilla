<template>
  <div class="gap-4 px-20 py-4">

    <form @submit.prevent="submit" class="mt-2 space-y-2 px-28">
      <BaseAlert type="info" title="SMTP Mail Settings">
        SMTP mails are used to send emails from the system (eg when a new member is invited to the system).
        Please provide valid mail settings here to avoid lost emails or errors.

        <p>We recommend that you use a third-party service like
          <a href="https://www.smtper.net">SMTPer.net</a>
          to test your smtp connection
        </p>
      </BaseAlert>
      <BaseFormInput
        required
        label="SMTP Host"
        placeholder="smtp.google.com"
        id="smtp_host"
        :autofocus="true"
        v-model="form.smtp_host"
        :error="form.errors?.smtp_host"
      />

      <BaseFormInput
        required
        label="SMTP Port"
        placeholder="587"
        id="smtp_port"
        v-model="form.smtp_port"
        :error="form.errors?.smtp_port"
      />

      <BaseFormInput
        label="SMTP Username"
        placeholder="Username"
        id="smtp_username"
        v-model="form.smtp_username"
        :error="form.errors?.smtp_username"
      />

      <BaseFormInput
        label="SMTP Password"
        type="password"
        id="smtp_password"
        v-model="form.smtp_password"
        :error="form.errors?.smtp_password"
      />

      <BaseFormInput
        required
        label="Mail From address"
        placeholder="eg admin@mysite.com"
        id="mail_from_address"
        v-model="form.mail_from_address"
        :error="form.errors?.mail_from_address"
      />

      <BaseFormInput
        required
        label="Mail From name"
        placeholder="eg John Doe"
        id="mail_from_name"
        v-model="form.mail_from_name"
        :error="form.errors?.mail_from_name"
      />

      <div class="flex items-center gap-x-2">
        <BaseFormSwitch v-model="form.smtp_use_encryption" />
        <span>Use mail encryption</span>
      </div>

      <BaseFormSelect
        :error="form.errors?.smtp_encryption"
        v-if="form.smtp_use_encryption"
        label="Select encryption type"
        placeholder="Pick encryption"
        v-model="form.smtp_encryption"
        :options="mailEncryption" />

      <div class="flex items-center justify-between pt-6">
        <div>
          <BaseFormButton
            @click="$inertia.get(route('install.database'), {}, {preserveScroll: true})"
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
import BaseFormSwitch from "@/Components/BaseFormSwitch.vue";
import BaseFormSelect from "@/Components/BaseFormSelect.vue";
import { mailEncryption } from "@/Helpers/helpers";

defineOptions({
  layout: InstallLayout
});

const props = defineProps({
  data: Object
});

const form = useForm({
  smtp_host: props.data.smtp_host,
  smtp_port: props.data.smtp_port,
  smtp_username: props.data.smtp_username,
  smtp_password: props.data.smtp_password,
  mail_from_address: props.data.mail_from_address,
  mail_from_name: props.data.mail_from_name,
  smtp_use_encryption: props.data.smtp_use_encryption,
  smtp_encryption: props.data.smtp_encryption
});


function submit() {
  form.post(route("install.mail"), {
    preserveScroll: true,
    onSuccess: () => console.log("done"),
    onError: (e) => console.log(e)
  });
}
</script>

<style scoped>

</style>