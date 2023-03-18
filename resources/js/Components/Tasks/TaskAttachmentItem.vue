<template>
  <Menu as="div" class="relative inline-block text-left">
    <div>

      <MenuButton
        class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white px-4 py-2 text-sm text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
        <div class="max-w-[6rem] truncate ellipsis">
          {{ attachment.file_name }}
        </div>
        <ChevronDownIcon class="-mr-1 h-5 w-5 text-gray-400" aria-hidden="true" />
      </MenuButton>

    </div>

    <transition
      enter-active-class="transition ease-out duration-100"
      enter-from-class="transform opacity-0 scale-95"
      enter-to-class="transform opacity-100 scale-100"
      leave-active-class="transition ease-in duration-75"
      leave-from-class="transform opacity-100 scale-100"
      leave-to-class="transform opacity-0 scale-95">
      <MenuItems
        class="absolute left-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
        <div class="py-1">
          <MenuItem v-slot="{ active }">
            <a :href="route('media.download', [
                route().params.project,
                attachment.model_id,
                props.attachment.id
            ])"
               :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">
              Download attachment
            </a>
          </MenuItem>
          <MenuItem v-slot="{ active }">
            <button
              @click="handleDelete"
              :class="[active ? 'bg-red-50 text-red-600' : 'text-red-600', 'block w-full text-left px-4 py-2 text-sm']">
              Delete attachment
            </button>
          </MenuItem>
        </div>
      </MenuItems>
    </transition>
  </Menu>
</template>

<script setup>
import { Menu, MenuItem, MenuItems, MenuButton } from "@headlessui/vue";
import { ChevronDownIcon } from "@heroicons/vue/24/outline";
import { useConfirm } from "v3confirm";

const confirm = useConfirm();
const props = defineProps({
  attachment: Object
});
const emits = defineEmits(["deleted"]);

function handleDelete() {
  confirm.show("Are you sure?").then((ok) => {
    if (ok) {
      router.delete(route("media.destroy", [
        route().params.project,
        props.attachment.model_id,
        props.attachment.id
      ]), {
        preserveScroll: true,
        onSuccess: () => {
          emits("deleted");
        }
      });
    } else {
      console.log("Declined");
    }
  });


}
</script>

<style scoped>

</style>