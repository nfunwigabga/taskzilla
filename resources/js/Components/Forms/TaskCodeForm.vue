<template>
  <div v-if="disabled">
    <slot />
  </div>

  <Popper
    v-else
    arrow
    :show="showPopper"
    @close:popper="showPopper=false">
    <button @click.prevent="showPopper=true">
      <slot />
    </button>

    <template #content="{ close }">
      <div class="min-w-[20rem] p-4">
        <form @submit.prevent="submit(close)" class="space-y-4">
          <BaseFormColorPicker
            class="capitalize"
            :label="codeType"
            :options="codes[codeType]"
            v-model="form[codeType]"
            value-field="id"
            label-field="display"
            color-field="color"
            :placeholder="`Select task ${codeType}`"
            :error="form.errors ? form.errors[codeType] : ''" />

          <div class="flex items-center justify-end gap-x-2">
            <button @click.prevent="cancel(close)"
                    type="button"
                    class="px-2 py-1 bg-danger-100 border border-danger-200 rounded-md text-xs">
              Cancel
            </button>
            <BaseFormButton
              class="text-xs px-2 py-1"
              :disabled="!form.isDirty"
              :block="false"
              :loading="form.processing">
              Save
            </BaseFormButton>
          </div>
        </form>
      </div>
    </template>
  </Popper>
</template>

<script setup>
import Popper from "vue3-popper";
import BaseFormButton from "@/Components/BaseFormButton.vue";
import { ref } from "vue";
import BaseFormColorPicker from "@/Components/BaseFormColorPicker.vue";

const props = defineProps({
  codeValue: String,
  task: Object,
  codeType: String,
  codes: Object,
  readonly: Boolean
});
const showPopper = ref(false);
const disabled = computed(() => props.readonly || props.task.project?.is_archived || !props.task.project.can?.manage);

const form = useForm({
  field: props.codeType,
  [props.codeType]: props.codeValue
});

function cancel(close) {
  close();
  form.reset();
  form.clearErrors();
}

function submit(close) {
  form.transform((data) => ({
    ...data,
    due_date: data.due_date === "" ? null : data.due_date
  })).put(route("tasks.update", [
    props.task.project.id,
    props.task.id
  ]), {
    preserveScroll: true,
    preserveState: true,
    onError: (e) => console.log(e),
    onSuccess: (_) => {
      close();
    }
  });
}

</script>

<style scoped>

</style>