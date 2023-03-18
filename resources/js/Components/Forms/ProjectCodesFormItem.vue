<template>
  <tr class="text-gray-700 text-xs md:text-sm">
    <td class="px-2 py-1">{{ code.display }}</td>
    <td class="px-2 py-1">
      <div class="flex items-center gap-x-2 capitalize">
        <div class="h-2 w-2 rounded-full" :class="`bg-${code.color}-600`"></div>
        {{ code.color }}
      </div>
    </td>
    <td class="px-2 py-1">
      <CheckCircleIcon v-if="code.available_in_subtask" class="h-5 text-green-600" />
      <XCircleIcon v-else class="h-5 text-red-600" />
    </td>
    <td class="px-2 py-1">
      <span v-if="code.is_active" class="text-green-800">Active</span>
      <span v-else class="text-gray-500">Disabled</span>
    </td>
    <td>
      <Tooltip v-if="!$page.props.project.is_archived" label="Edit">
        <ProjectCodeForm by="admin" :element="code" :type="code.type">
          <button>
            <PencilSquareIcon class="h-4" />
          </button>
        </ProjectCodeForm>
      </Tooltip>
    </td>
  </tr>
</template>

<script setup>
import { CheckCircleIcon, PencilSquareIcon, XCircleIcon } from "@heroicons/vue/24/outline";
import ProjectCodeForm from "@/Components/Forms/ProjectCodeForm.vue";
import { Tooltip } from "@spartez/vue-atlaskit-next";

const props = defineProps({
  code: Object
});

</script>

<style scoped>

</style>