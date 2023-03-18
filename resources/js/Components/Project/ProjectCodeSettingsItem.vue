<template>
  <div class="my-4 border">
    <Disclosure v-slot="{ open }">
      <div class="w-full flex items-center justify-between gap-x-2 bg-dark-50 py-1 px-2 rounded">
        <DisclosureButton class="font-semibold flex flex-1 items-center justify-start gap-x-1 uppercase text-xs">
          <ChevronRightIcon
            :class="open ? 'rotate-90 transform' : ''"
            class="h-4 w-4 text-primary-500"
          />
          <span>Task {{ code }}</span>
        </DisclosureButton>
        <ProjectCodeForm by="admin"
                         :type="codeType"
                         v-if="!$page.props.project.is_archived">
          <BaseFormButton
            color="lightgreen"
            class="!font-semibold !text-xs gap-x-1 flex items-center">
            <PlusSmallIcon class="h-3" />
            <span>Add task {{ code }}</span>
          </BaseFormButton>
        </ProjectCodeForm>
      </div>
      <DisclosurePanel>
        <div class="max-h-[20rem] overflow-y-auto mt-2">
          <table class="w-full whitespace-no-wrap">
            <thead>
            <tr
              class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-100"
            >
              <th class="px-2 py-1">Name</th>
              <th class="px-2 py-1">Color</th>
              <th class="px-2 py-1">Available for subtasks</th>
              <th class="px-2 py-1">Status</th>
              <th class="px-2 py-1"></th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y">
            <ProjectCodesFormItem v-for="item in codes" :code="item" />
            </tbody>
          </table>
        </div>
      </DisclosurePanel>
    </Disclosure>
  </div>

</template>

<script setup>
import { PlusSmallIcon, ChevronRightIcon } from "@heroicons/vue/24/outline";
import { Disclosure, DisclosurePanel, DisclosureButton } from "@headlessui/vue";
import ProjectCodeForm from "@/Components/Forms/ProjectCodeForm.vue";
import BaseFormButton from "@/Components/BaseFormButton.vue";
import ProjectCodesFormItem from "@/Components/Forms/ProjectCodesFormItem.vue";

const props = defineProps({
  code: String,
  codes: Object
});

const codeType = computed(() => `TASK_${props.code.toUpperCase()}`);
</script>

<style scoped>

</style>