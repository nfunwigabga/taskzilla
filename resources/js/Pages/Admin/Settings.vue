<template>
  <Head>
    <title>{{title}}</title>
  </Head>
  <Teleport to="#header-left" v-if="isMounted">
    <h2 class="font-bold text-xl">Admin - {{ title || "Settings" }}</h2>
  </Teleport>

  <div class="w-full mt-12 max-w-2xl container">
    <BaseCard class="w-full ">
      <template #header>
        Site Settings
      </template>

      <form @submit.prevent="submit" class="w-full px-6 space-y-4">
        <div class="col-span-3 md:col-span-2">
          <BaseFormInput
            required
            label="Site name"
            placeholder="Will appear in emails"
            id="site_name"
            v-model="form.site_name"
            :error="form.errors.site_name"
          />
        </div>
        <!--        <SettingsSectionHeader>-->
        <!--          SMTP Mail Settings-->
        <!--        </SettingsSectionHeader>-->
        <BaseAlert type="info" title="SMTP Mail Settings">
          SMTP mails are used to send emails from the system (eg when a new member is invited to the system).
          Please provide valid mail settings here to avoid lost emails or errors.
        </BaseAlert>

        <div class="grid grid-cols-4 gap-4 space-y-2x">
          <div class="col-span-4 md:col-span-2">
            <BaseFormInput
              required
              label="SMTP Host"
              placeholder="smtp.google.com"
              id="smtp_host"
              v-model="form.smtp_host"
              :error="form.errors?.smtp_host"
            />
          </div>

          <div class="col-span-4 md:col-span-2">
            <BaseFormInput
              required
              label="SMTP Port"
              placeholder="587"
              id="smtp_port"
              v-model="form.smtp_port"
              :error="form.errors?.smtp_port"
            />
          </div>

          <div class="col-span-4 md:col-span-2">
            <BaseFormInput
              label="SMTP Username"
              placeholder="Username"
              id="smtp_username"
              v-model="form.smtp_username"
              :error="form.errors?.smtp_username"
            />
          </div>

          <div class="col-span-4 md:col-span-2">
            <BaseFormInput
              label="SMTP Password"
              type="password"
              id="smtp_password"
              v-model="form.smtp_password"
              :error="form.errors?.smtp_password"
            />
          </div>

          <div class="col-span-4 md:col-span-2">
            <BaseFormInput
              required
              label="Mail From address"
              placeholder="eg admin@mysite.com"
              id="mail_from_address"
              v-model="form.mail_from_address"
              :error="form.errors?.mail_from_address"
            />
          </div>

          <div class="col-span-4 md:col-span-2">
            <BaseFormInput
              required
              label="Mail From name"
              placeholder="eg John Doe"
              id="mail_from_name"
              v-model="form.mail_from_name"
              :error="form.errors?.mail_from_name"
            />
          </div>

          <div class="col-span-4 md:col-span-2">
            <div class="flex items-center gap-x-2 mb-4">
              <BaseFormSwitch v-model="form.smtp_use_encryption" />
              <span>Use mail encryption</span>
            </div>

            <BaseFormSelect
              v-if="form.smtp_use_encryption"
              :error="form.errors?.smtp_encryption"
              label="Select encryption type"
              placeholder="Pick encryption"
              v-model="form.smtp_encryption"
              :options="mailEncryption" />
          </div>
        </div>

        <div class="text-end">
          <BaseFormButton
            :block="false"
            :loading="form.processing">
            Save settings
          </BaseFormButton>
        </div>
      </form>
    </BaseCard>
  </div>
</template>

<script setup>
import BaseFormInput from "@/Components/BaseFormInput.vue";
import { useForm } from "@inertiajs/vue3";
import SettingsSectionHeader from "@/Components/Admin/SettingsSectionHeader.vue";
import BaseFormButton from "@/Components/BaseFormButton.vue";
import BaseFormSwitch from "@/Components/BaseFormSwitch.vue";
import { mailEncryption } from "@/Helpers/helpers";
import BaseFormSelect from "@/Components/BaseFormSelect.vue";
import { watch } from "vue";
import BaseCard from "@/Components/BaseCard.vue";
import { useMounted } from "@/Composables/useMounted";
import BaseAlert from "@/Components/BaseAlert.vue";

const props = defineProps({
  site_name: String,
  smtp_host: String,
  smtp_port: String,
  smtp_username: String,
  smtp_password: String,
  mail_from_address: String,
  mail_from_name: String,
  smtp_encryption: String,
  smtp_use_encryption: Boolean
});

const form = useForm({
  site_name: props.site_name,
  smtp_host: props.smtp_host,
  smtp_port: props.smtp_port,
  smtp_username: props.smtp_username,
  smtp_password: props.smtp_password,
  mail_from_address: props.mail_from_address,
  mail_from_name: props.mail_from_name,
  smtp_use_encryption: props.smtp_use_encryption,
  smtp_encryption: props.smtp_encryption
});

const { isMounted } = useMounted();

watch(() => form.smtp_use_encryption, (value) => {
  if (!value) {
    form.smtp_encryption = null;
  }
});

function submit() {
  form.put(route("admin.settings"), {
    preserveScroll: true,
    onSuccess: () => console.log("done"),
    onError: (e) => console.log(e)
  });
}
</script>

<style scoped>

</style>