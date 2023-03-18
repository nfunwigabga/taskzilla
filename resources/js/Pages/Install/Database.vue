<template>
  <div class="gap-4 px-20 py-4">

    <form @submit.prevent="submit" class="mt-2 space-y-2 px-28">
      <BaseAlert type="info" title="Database Connection">
        Note that the database will be completely wiped clean during this installation.
      </BaseAlert>
      <BaseFormInput
        required
        label="Database Host"
        placeholder="localhost"
        id="db_host"
        :autofocus="true"
        v-model="form.db_host"
        :error="form.errors?.db_host"
      />

      <BaseFormInput
        required
        label="Database Name"
        placeholder="mysitedb"
        id="db_name"
        v-model="form.db_name"
        :error="form.errors?.db_name"
      />

      <BaseFormInput
        required
        label="Database Username"
        placeholder="root"
        id="db_username"
        v-model="form.db_username"
        :error="form.errors?.db_username"
      />

      <BaseFormInput
        required
        label="Database Password"
        type="password"
        id="db_password"
        v-model="form.db_password"
        :error="form.errors?.db_password"
      />

      <BaseFormInput
        required
        label="Database Port"
        id="db_port"
        v-model="form.db_port"
        :error="form.errors?.db_port"
      />

      <div class="flex items-center justify-between pt-6">
        <div>
          <BaseFormButton
            @click="$inertia.get(route('install.requirements'), {}, {preserveScroll: true})"
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

const props = defineProps({
  data: Object
});
const form = useForm({
  db_host: props.data.db_host,
  db_name: props.data.db_name,
  db_username: props.data.db_username,
  db_password: props.data.db_password,
  db_port: props.data.db_port
});


function submit() {
  form.post(route("install.database"), {
    preserveScroll: true,
    onSuccess: () => console.log("done"),
    onError: (e) => console.log(e)
  });
}
</script>

<style scoped>

</style>