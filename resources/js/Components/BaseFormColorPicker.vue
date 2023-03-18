<template>
  <FieldGroup :errors="[error]"
              :label="label">
    <Select :options="options"
            open-on-focus
            v-bind="$attrs"
            :placeholder="placeholder || ''"
            :is-invalid="!!error"
            :model-value="modelValue"
            :is-clearable="clearable"
            :class="[disabled ? 'bg-slate-100 pointer-events-none' : 'bg-slate-50/50']"
            @update:modelValue="handleChange">
      <template #option="{option, isCurrent}">
        <div class="flex items-center gap-x-1 select-none">
          <div :class="`h-3 w-3 rounded-full bg-${option[colorField]}-600`" />
          <span
            :class="[ option[valueField] === modelValue ? 'font-extrabold !text-primary-500' : 'font-normal', 'block truncate']">
            {{ option[labelField] }}
          </span>
        </div>
      </template>

      <template #selected="{selected}">
        <div class="flex items-center gap-x-1">
          <div :class="`h-3 w-3 rounded-full bg-${selectedOption[colorField]}-600`" />
          <span>{{ selectedOption[labelField] }}</span>
        </div>
      </template>
    </Select>
  </FieldGroup>
</template>

<script setup>
import { FieldGroup, Select } from "@spartez/vue-atlaskit-next";
import { computed } from "vue";

const props = defineProps({
  modelValue: String,
  options: Array,
  label: String,
  type: String,
  disabled: Boolean,
  required: Boolean,
  placeholder: String,
  clearable: Boolean,
  error: { type: String, default: null },
  labelField: { type: String, default: "label" },
  valueField: { type: String, default: "id" },
  colorField: { type: String, default: "id" }
});

const emit = defineEmits(["update:modelValue"]);

const selectedOption = computed(() =>
  props.options.find((option) => option[props.valueField] === props.modelValue)
);

function handleChange($event) {
  emit("update:modelValue", $event[props.valueField]);
}
</script>

<style scoped>

</style>