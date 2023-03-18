<template>
  <FieldGroup :label="label"
              :errors="[error]"
              class="!pt-0">
    <TextArea
      :model-value="modelValue"
      :required="required"
      :is-focused="autofocus"
      :readonly="readonly"
      :is-invalid="!!error"
      v-bind="$attrs"
      :class="[readonly ? 'bg-slate-100 pointer-events-none' : 'bg-slate-50/50']"
      should-fit-container
      @update:modelValue="$emit('update:modelValue', $event)"
      :placeholder="placeholder"
      :rows="rows ? rows.toString() : ''" />
  </FieldGroup>
</template>

<script setup>

import { FieldGroup, TextArea } from "@spartez/vue-atlaskit-next";

const emit = defineEmits(["update:modelValue"]);
defineProps({
  id: String,
  modelValue: { type: [String, Number], default: "" },
  error: { type: String, default: null },
  autofocus: { type: Boolean, default: false },
  placeholder: { type: String, default: "" },
  label: { type: String, default: "" },
  rows: { type: Number, default: 4 },
  readonly: { type: Boolean, default: false },
  required: Boolean
});

</script>

<style scoped></style>
