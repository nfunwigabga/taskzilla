<template>
  <form @submit.prevent="submit" class="space-y-4">
    <div class="py-1 px-1.5 rounded text-sm text-gray-700 font-semibold bg-slate-100">
      {{ title }}
    </div>
    <div class="grid grid-cols-3 gap-x-2">
      <div class="col-span-1">
        <BaseFormSelect
          placeholder="Pick relationship type"
          v-model="form.relation"
          :options="relations" />
      </div>
      <div class="relative col-span-2">
        <Combobox v-model="form.related_task">
          <ComboboxInput
            placeholder="Search related task..."
            class="w-full rounded-sm bg-slate-50/50 border-0 ring-2 ring-gray-300 py-2 px-2 text-sm leading-5 text-gray-900 transition-all focus:ring-primary-600"
            :displayValue="(_) => displaySelection"
            @change="keyword = $event.target.value" />
          <ComboboxOptions
            class="absolute z-50 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
            <div
              v-if="suggestions.length === 0 && keyword !== ''"
              class="relative cursor-default select-none py-2 px-4 text-gray-700"
            >
              No search results
            </div>
            <ComboboxOption
              v-for="suggestion in suggestions"
              as="template"
              :key="suggestion.id"
              :value="suggestion.id"
              v-slot="{ selected, active }"
            >
              <li
                class="relative cursor-pointer select-none py-2 px-2.5"
                :class="{
                    'bg-primary-50 text-primary-600': active,
                    'text-gray-900': !active,
                  }"
              >
                <span
                  class="block flex items-center gap-x-2 truncate"
                  :class="{ 'font-medium': selected, 'font-normal': !selected }"
                >
                    <span>{{ suggestion.key }}</span>
                    <span>{{ suggestion.title }}</span>
                  </span>
              </li>
            </ComboboxOption>
          </ComboboxOptions>
        </Combobox>
      </div>
    </div>

    <div class="flex items-center justify-end">
      <BaseFormButton :block="false" :disabled="!form.isDirty || !form.related_task" :loading="form.processing">Save
      </BaseFormButton>
    </div>

  </form>
</template>

<script setup>
import {
  Combobox,
  ComboboxInput,
  ComboboxOptions,
  ComboboxOption
} from "@headlessui/vue";
import { debounce } from "lodash";
import { computed, ref, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import BaseFormButton from "@/Components/BaseFormButton.vue";
import BaseFormSelect from "@/Components/BaseFormSelect.vue";

const props = defineProps({
  taskId: String,
  relations: Array,
  title: String
});
const emit = defineEmits(["cancel"]);

const keyword = ref("");
const suggestions = ref([]);
const form = useForm({
  relation: props.relations[0]?.id,
  related_task: null
});

const displaySelection = computed(() => {
  if (form.related_task) {
    const needle = suggestions.value.find(s => s.id === form.related_task);
    return needle.display;
  }
  return "";
});

watch(() => keyword.value, (value) => {
  if (value) {
    search();
  }
});

const search = debounce(() => {
  if (keyword.value?.length < 2) return;
  axios.get(route("tasks.unrelated", {
    project: route().params.project,
    task: props.taskId,
    keyword: keyword.value
  })).then(response => {
    suggestions.value = response.data;
  });
}, 500);

function cancel() {
  form.reset();
  emit("cancel");
}

function submit() {
  form.post(route("tasks.relate", {
    project: route().params.project,
    task: props.taskId
  }), {
    preserveScroll: true,
    onSuccess: () => cancel()
  });
}
</script>

<style scoped>

</style>