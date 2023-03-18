<template>
  <Tooltip label="Due date" v-if="disabled">
    <div class="rounded-full cursor-default outline-none border p-1 border-gray-400 border-dashed">
                  <span class="text-xs" v-if="element.due_date?.mmddyyyy">
                    {{ element.due_date?.mmddyyyy }}
                  </span>
      <CalendarIcon v-else class="h-4 w-4 text-gray-500" />
    </div>
  </Tooltip>

  <Popper v-else
          arrow
          :show="showPopper"
          @close:popper="showPopper=false">
    <Tooltip label="Due date">
      <button @click.prevent="showPopper=true"
              :class="{'border-dashed border-gray-400 border' : !element.due_date?.mmddyyyy}"
              class="rounded-full outline-none p-1">
                  <span class="text-xs" v-if="element.due_date?.mmddyyyy">
                    {{ element.due_date?.mmddyyyy }}
                  </span>
        <CalendarIcon v-else class="h-4 w-4 text-gray-500" />
      </button>
    </Tooltip>
    <template #content="{ close }">
      <div class="min-w-[20rem] p-4">
        <form @submit.prevent="submit(close)" class="space-y-4">
          <BaseFormInput
            type="date"
            label="Due date"
            id="due-date"
            :autofocus="true"
            v-model="form.due_date"
            :error="form.errors?.due_date"
          />
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
import { CalendarIcon } from "@heroicons/vue/24/outline";
import Popper from "vue3-popper";
import BaseFormInput from "@/Components/BaseFormInput.vue";
import BaseFormButton from "@/Components/BaseFormButton.vue";
import { computed, ref } from "vue";
import { Tooltip } from "@spartez/vue-atlaskit-next";
import { useForm } from "@inertiajs/vue3";

import { InlineDialog } from "@spartez/vue-atlaskit-next";

const props = defineProps({
  element: Object,
  taskId: String,
  readonly: Boolean
});
// const dialog = ref(null);
const showPopper = ref(false);
const disabled = computed(() => props.readonly || props.element.project?.is_archived || !props.element.project.can?.manage);

const form = useForm({
  field: "due_date",
  due_date: props.element?.due_date?.yyyymmd || null
});

// function cancel() {
//   dialog.value?.onTriggerClick();
//   form.reset();
//   form.clearErrors();
// }

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
    props.element.project.id,
    props.taskId
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