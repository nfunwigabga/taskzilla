<template>
  <Menu as="div" class="relative">
    <div>
      <MenuButton
        class="flex max-w-xs items-center rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 lg:rounded-md lg:p-2 lg:hover:bg-gray-50">
        <img class="h-8 w-8 rounded-full ring-1 ring-offset-1 ring-primary-600"
             :src="user.avatar"
             alt="" />
        <span class="ml-3 hidden text-sm font-medium text-gray-700 lg:block"><span
          class="sr-only">Open user menu for </span>{{ user.name }}</span>
        <ChevronDownIcon class="ml-1 hidden h-5 w-5 flex-shrink-0 text-gray-400 lg:block"
                         aria-hidden="true" />
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
        class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-b-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 divide-y divide-gray-200 focus:outline-none">
        <div v-if="user.is_admin">
          <MenuItem v-slot="{active}">
            <Link :href="route('admin.dashboard')"
                  :class="[active ? 'bg-gray-100' : '', 'flex items-center gap-x-1 w-full text-left px-4 py-2 text-sm text-gray-900']">
              Admin panel
            </Link>
          </MenuItem>
        </div>

        <div class="py-1">
          <MenuItem v-slot="{ active }">
            <a :href="route('users.show', $page.props.auth.user.id)"
               :class="[active ? 'bg-gray-100' : '', 'block w-full text-left px-4 py-2 text-sm text-gray-700']">
              View Profile
            </a>
          </MenuItem>
          <MenuItem v-slot="{ active }">
            <button @click="isOpen = true"
                    :class="[active ? 'bg-gray-100' : '', 'block w-full text-left px-4 py-2 text-sm text-gray-700']">
              Profile settings
            </button>
          </MenuItem>
        </div>
        <MenuItem v-slot="{ active }">
          <Link :href="route('logout')"
                method="post"
                as="button"
                :class="[active ? 'bg-gray-100' : '', 'block w-full text-left px-4 py-2 text-sm text-gray-700']">
            Logout
          </Link>
        </MenuItem>

      </MenuItems>
    </transition>
  </Menu>
</template>

<script setup>
import {
  Menu,
  MenuButton,
  MenuItem,
  MenuItems
} from "@headlessui/vue";
import { ChevronDownIcon } from "@heroicons/vue/24/outline";
import { useSettings } from "@/Composables/useSettings";

const props = defineProps({
  user: Object
});

const { isOpen } = useSettings();

</script>

<style scoped>

</style>