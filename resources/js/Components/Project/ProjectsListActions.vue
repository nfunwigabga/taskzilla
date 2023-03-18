<template>
  <Popover v-slot="{ open, close }">
    <Float enter="transition duration-200 ease-out"
           enter-from="scale-95 opacity-0"
           enter-to="scale-100 opacity-100"
           leave="transition duration-150 ease-in"
           leave-from="scale-100 opacity-100"
           leave-to="scale-95 opacity-0"
           tailwindcss-origin-class
           :offset="15" arrow>
      <PopoverButton class="rounded-full p-1.5">
        <EllipsisHorizontalIcon class="h-5 w-5" />
      </PopoverButton>
      <PopoverPanel
        class="rounded-lg shadow-xl text-gray-700 text-left z-10 w-screen max-w-[14rem]"
      >
        <FloatArrow class="absolute bg-white w-5 h-5 rotate-45 border border-gray-200" />
        <div class="w-full ring-1 ring-black ring-opacity-5">
          <div class="relative rounded-lg grid grid-cols-1 divide-y divide-gray-200 bg-white text-sm">
            <button @click="toggleFavorite(close)"
                    class="w-full flex items-center rounded-t-lg gap-x-1 hover:bg-gray-100 p-2 text-left">
              <template v-if="project.is_faved">
                <FavedIcon class="h-4 text-orange-500" />
                Remove from favorites
              </template>
              <template v-else>
                <StarIcon class="h-4" />
                Add to favorites
              </template>
            </button>
            <template v-if="project.can.manage">
              <Popover v-slot="{ open }">
                <Float enter="transition duration-200 ease-out"
                       enter-from="scale-95 opacity-0"
                       enter-to="scale-100 opacity-100"
                       leave="transition duration-150 ease-in"
                       leave-from="scale-100 opacity-100"
                       leave-to="scale-95 opacity-0"
                       tailwindcss-origin-class
                       :offset="15">
                  <PopoverButton
                    class="w-full flex items-center gap-x-1 hover:bg-gray-100 p-2 text-left">
                    <div :class="`bg-${project.color}-600`" class="h-4 w-4 rounded" />
                    <div class="flex flex-1 items-center justify-between">
                      <span>Set color and icon</span>
                      <ChevronRightIcon class="h-4" />
                    </div>
                  </PopoverButton>
                  <PopoverPanel
                    class="absolute top-0 left-[100%] -ml-12 z-10 w-screen max-w-xs px-4"
                  >
                    <div class="rounded-lg overflow-hidden shadow-lg ring-1 ring-black ring-opacity-5">
                      <div class="relative bg-white grid grid-cols-1 divide-y">
                        <div class="p-4 border-gray-200 grid grid-cols-6 gap-2">
                          <button
                            v-for="color in colorPicker"
                            :key="color.id"
                            :disabled="color.id === project.color"
                            @click="setColor(color.id, close)"
                            :class="`h-6 w-6 flex items-center justify-center border rounded bg-${color.id}-600`">
                            <span v-if="color.id === project.color">
                              <CheckIcon class="text-white h-4 w-4" />
                            </span>
                          </button>
                        </div>
                        <div class="p-4 grid grid-cols-6 gap-2">
                          <button v-for="icon in icons"
                                  :key="icon"
                                  :disabled="icon === project.icon"
                                  @click="setIcon(icon, close)"
                                  :class="icon === project.icon ? 'border-primary-500' : 'border-gray-300'"
                                  class="h-8 w-8 disabled:border-2 flex items-center justify-center border rounded">
                            <component :is="iconPicker[icon]" class="h-5 w-5" />
                          </button>
                        </div>
                      </div>
                    </div>
                  </PopoverPanel>
                </Float>
              </Popover>
              <button @click="$inertia.visit(route('projects.edit', project.id))"
                      class="w-full flex items-center gap-x-1 hover:bg-gray-100 p-2 text-left">
                <PencilIcon class="h-4" />
                Edit details
              </button>

              <button @click="toggleArchive(close)"
                      class="w-full flex rounded-b-lg items-center gap-x-1 text-red-700 hover:bg-red-50 p-2 text-left">
                <ArchiveBoxIcon class="h-4" />
                {{ project.is_archived ? "Unarchive project" : "Archive project" }}
              </button>
            </template>
          </div>
        </div>
      </PopoverPanel>
    </Float>
  </Popover>
</template>

<script setup>
import { Float, FloatArrow } from "@headlessui-float/vue";
import {
  StarIcon,
  ArchiveBoxIcon,
  PencilIcon,
  ChevronRightIcon,
  EllipsisHorizontalIcon,
  CheckIcon
} from "@heroicons/vue/24/outline";
import { StarIcon as FavedIcon } from "@heroicons/vue/24/solid";
import { iconPicker } from "@/Helpers/icons";
import { colorPicker } from "@/Helpers/helpers";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import { Popover, PopoverButton, PopoverPanel } from "@headlessui/vue";

import { useConfirm } from "v3confirm";

const props = defineProps({
  project: Object
});

const form = useForm({
  color: props.project?.color,
  icon: props.project?.icon
});
const confirm = useConfirm();
const icons = Object.keys(iconPicker);

function toggleFavorite(close) {
  router.put(route("projects.favorite", [
    props.project.id
  ]), {}, {
    preserveScroll: true,
    onError: (error) => console.log(error),
    success: (_) => close()
  });
}

function toggleArchive(close) {
  close();
  confirm.show("Are you sure?").then((ok) => {
    if (ok) {
      router.put(route("projects.archive", [
        props.project.id
      ]), {}, {
        preserveScroll: true,
        onError: (error) => console.log(error),
        success: (_) => close()
      });
    } else {
      console.log("Declined");
    }
  });

}

function setColor(color, close = null) {
  form
    .transform((data) => ({
      ...data,
      color: color
    })).put(route("projects.update", [props.project.id]), {
    preserveScroll: true,
    onError: (error) => console.log(error),
    onSuccess: (_) => {
      form.color = props.project?.color;
      form.icon = props.project?.icon;
      close ? close() : null;
    }
  });
}

function setIcon(icon, close = null) {
  form
    .transform((data) => ({
      ...data,
      icon: icon
    })).put(route("projects.update", [props.project.id]), {
    preserveScroll: true,
    onError: (error) => console.log(error),
    onSuccess: (_) => {
      form.color = props.project?.color;
      form.icon = props.project?.icon;
      close ? close() : null;
    }
  });
}
</script>

<style scoped>
.dropdown-item {
  @apply rounded-full p-1.5;
  /*@apply hover:bg-gray-100;*/
  /*@apply hover:text-black;*/
  /*@apply group-focus-within/root:bg-gray-100;*/
  /*@apply group-focus-within/root:text-black;*/
}

.dropdown-nav-item {
  @apply w-full flex items-center gap-x-1;
  @apply hover:bg-gray-100 py-2 px-2 text-left;
  @apply text-sm font-medium transition-all text-gray-800;
}
</style>