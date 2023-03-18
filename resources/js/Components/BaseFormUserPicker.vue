<template>
  <FieldGroup :errors="[error]"
              :label="label">
    <Select :options="options"
            :is-invalid="!!error"
            :model-value="modelValue"
            :is-clearable="clearable"
            @update:modelValue="handleChange">

      <template #option="{option, isCurrent}">
        <div class="flex items-center gap-x-2 select-none">
          <Avatar size="sm" class="h-7 w-7" :avatar="option[avatarField]" />
          <span
            :class="[ option[valueField] === modelValue ? 'font-extrabold !text-primary-500' : 'font-normal', 'block truncate']">
            {{ option[labelField] }}
          </span>
        </div>
      </template>

      <template #selected="{selected}">
        <div class="flex items-center gap-x-2">
          <BaseAvatar :avatar="selectedOption[avatarField]" class="h-5 w-5" />
          <span>{{ selectedOption[labelField] }}</span>
        </div>
      </template>
    </Select>
  </FieldGroup>
</template>

<script setup>
import { FieldGroup, Avatar, Select } from "@spartez/vue-atlaskit-next";
import { computed } from "vue";
import BaseAvatar from "@/Components/BaseAvatar.vue";

const props = defineProps({
  modelValue: String,
  options: Array,
  label: String,
  disabled: Boolean,
  required: Boolean,
  placeholder: String,
  clearable: Boolean,
  error: { type: String, default: null },
  labelField: { type: String, default: "label" },
  valueField: { type: String, default: "id" },
  avatarField: { type: String, default: "avatar" }
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