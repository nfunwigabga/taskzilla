<template>
  <div class="gap-4 px-40 py-4">
    <BaseAlert v-if="errors === 0" title="Looking good!">
      Your system seems to meet the requirements for running the application.
    </BaseAlert>
    <BaseAlert type="danger" title="Something's not right!" v-else>
      Your system does not meet the full requirements to
      run the application.
    </BaseAlert>

    <ul class="divide-y divide-dashed divide-dark-300 mt-2">
      <li class="flex items-center justify-between text-sm" v-for="(key,index) in Object.keys(requirements)">
        <div class="flex-1">
          {{ key }}
          <div v-if="requirements[key].status === 'FAILED'" class="text-danger-600 text-xs">
            {{ requirements[key].message }}
          </div>
        </div>
        <div>
          <CheckCircleIcon class="h-6 text-success-500" v-if="requirements[key].status === 'OK'" />
          <XCircleIcon class="h-6 text-danger-400" v-else />
        </div>
      </li>
    </ul>

    <div class="flex items-center justify-between mt-4">
      <div>
        <BaseFormButton
          @click="$inertia.get(route('install.start'), {}, {preserveScroll: true})"
          color="light"
          type="button">
          <ArrowLeftIcon class="h-4 mr-1" />
          Back
        </BaseFormButton>
      </div>
      <div>
        <BaseFormButton
          @click="$inertia.get(route('install.database'), {}, {preserveScroll: true})"
          type="button"
          :color="errors > 0 ? 'light' : 'primary'"
          :disabled="errors > 0">
          Proceed
          <ArrowRightIcon class="h-4 ml-1" />
        </BaseFormButton>
      </div>
    </div>
  </div>
</template>

<script setup>

import InstallLayout from "@/Layouts/InstallLayout.vue";
import BaseAlert from "@/Components/BaseAlert.vue";
import { CheckCircleIcon, ArrowLeftIcon, ArrowRightIcon, XCircleIcon } from "@heroicons/vue/24/solid";
import BaseFormButton from "@/Components/BaseFormButton.vue";

defineOptions({
  layout: InstallLayout
});

const props = defineProps({
  data: Object
});

const { requirements, errors } = props.data;
</script>

<style scoped>

</style>