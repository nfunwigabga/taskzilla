<template>
  <FieldGroup
    :label="label"
    :errors="[error]"
    class="!pt-1"
    data-cy="field-group">
    <Input :value="modelValue"
           :type="type"
           :maxlength="max"
           :required="required"
           :autofocus="autofocus"
           :readonly="readonly"
           :is-invalid="!!error"
           v-bind="$attrs"
           :class="[readonly ? 'bg-slate-100 pointer-events-none' : 'bg-slate-50/50']"
           should-fit-container
           @input="$emit('update:modelValue', $event.target.value)"
           :placeholder="placeholder" />
  </FieldGroup>
</template>

<script setup>

import { FieldGroup, Input } from "@spartez/vue-atlaskit-next";

defineEmits(["update:modelValue"]);
defineProps({
  id: String,
  max: {
    type: Number,
    default: undefined
  },
  modelValue: { type: [String, Number], default: "" },
  error: { type: String, default: null },
  required: { type: Boolean, default: false },
  autofocus: { type: Boolean, default: false },
  placeholder: { type: String, default: "" },
  label: { type: String, default: "" },
  type: { type: String, default: "text" },
  readonly: { type: Boolean, default: false }
});
</script>

<style scoped>

</style>
