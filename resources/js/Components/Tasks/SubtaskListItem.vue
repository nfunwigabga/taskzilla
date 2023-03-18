<template>
  <li>
    <Link :href="task._links.self" class="flex group gap-x-2 text-sm items-center py-2 px-2 hover:bg-gray-100">
      <CompletedIcon v-if="task.resolved" class="h-4 text-green-600" />
      <CheckCircleIcon v-else class="h-4" />
      <strong :class="[{'line-through': task.resolved}, `text-${task.type?.color}-600`]">{{ task.key }}:</strong>
      <span>{{ task.title }}</span>
      <div class="flex gap-x-3 items-center ml-auto">
        <span class="opacity-0 group-hover:opacity-100" v-if="relatedId">
          <Tooltip label="Unlink task">
              <button @click.prevent="unlink">
                <XMarkIcon class="h-4" />
              </button>
           </Tooltip>
        </span>
      </div>
    </Link>
  </li>
</template>

<script setup>
import { CheckCircleIcon as CompletedIcon } from "@heroicons/vue/24/solid";
import { CheckCircleIcon, XMarkIcon, CalendarIcon, UserIcon } from "@heroicons/vue/24/outline";
import { Tooltip } from "@spartez/vue-atlaskit-next";
import { useConfirm } from "v3confirm";


const confirm = useConfirm();

const props = defineProps({
  task: Object,
  codes: Object,
  project: Object,
  members: Array,
  relatedId: String
});

function unlink() {
  confirm.show("Are you sure?").then((ok) => {
    if (ok) {
      router.delete(route("tasks.unrelate", {
        project: route().params.project,
        task: props.task?.id,
        related: props.relatedId
      }), {
        preserveScroll: true,
        onSuccess: () => null
      });
    } else {
      console.log("Declined!");
    }
  });


}
</script>

<style scoped>

</style>