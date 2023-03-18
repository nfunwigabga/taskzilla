<template>
  <Switch
    :model-value="modelValue"
    @update:modelValue="($event) => emit('update:modelValue', $event)"
    :class="modelValue ? 'bg-primary-600' : 'bg-slate-300'"
    v-bind="$attrs"
    class="relative inline-flex h-[22px] w-[38px] shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
  >
    <span
      aria-hidden="true"
      :class="modelValue ? 'translate-x-4' : 'translate-x-0'"
      class="pointer-events-none inline-block h-[18px] w-[18px] transform rounded-full bg-white shadow-lg ring-0 transition duration-200 ease-in-out"
    />
  </Switch>
</template>

<script setup>
import { Switch } from "@headlessui/vue";

defineProps({
  modelValue: Boolean
});

const emit = defineEmits(["update:modelValue"]);
</script>

<style></style>
