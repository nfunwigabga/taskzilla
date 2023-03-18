<template>
  <Menu as="div" class="relative z-10 ml-3">
    <div>
      <MenuButton
        class="rounded-full bg-white p-1 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
        <span class="group rounded-full flex items-center p-2">
            <BellIcon class="h-6 w-6" aria-hidden="true" />
            <span class="sr-only">Notifications</span>
        </span>
        <template v-if="notifications.length > 0">
          <span
            class="absolute top-3 right-3 inline-block w-2 h-2 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full"></span>
        </template>
      </MenuButton>
    </div>
    <transition
      enter-active-class="transition duration-100 ease-out"
      enter-from-class="transform scale-95 opacity-0"
      enter-to-class="transform scale-100 opacity-100"
      leave-active-class="transition duration-75 ease-in"
      leave-from-class="transform scale-100 opacity-100"
      leave-to-class="transform scale-95 opacity-0">
      <MenuItems
        class="absolute right-0 mt-2 w-96 origin-top-right rounded-b-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
        <template v-if="notifications.length > 0">
          <div class="px-1 py-2 h-52 overflow-y-auto">
            <MenuItem v-for="notification in notifications"
                      :key="notification.id"
                      v-slot="{ active }">
              <a @click="markAsRead(notification.id)"
                 :href="notification.link"
                 :class="active ? 'bg-gray-100' : 'bg-white'"
                 class="flex items-center select-none gap-x-2 w-full px-2 py-3 text-sm font-medium text-gray-700">
                <component :is="getIcon(notification.category)" class="h-4 w-4 flex-none text-slate-400" />
                <span class="flex-auto truncate" v-html="notification.subject" />
              </a>
            </MenuItem>
          </div>
          <MenuItem>
            <button @click="markAllAsRead" class="w-full py-2 px-3 bg-dark-100">Mark all as read</button>
          </MenuItem>
        </template>
        <template v-else>
          <div class="px-1  py-2 h-52 flex items-center justify-center text-slate-400 overflow-y-auto">
            <p>No unread notifications</p>
          </div>
        </template>
      </MenuItems>
    </transition>
  </Menu>
</template>

<script setup>
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
import { BellIcon } from "@heroicons/vue/24/outline";
import {
  BellAlertIcon,
  BriefcaseIcon,
  DocumentCheckIcon,
  ChatBubbleLeftIcon
} from "@heroicons/vue/24/solid";
import axios from "axios";
import { onBeforeMount, onMounted, ref } from "vue";
import { usePage } from "@inertiajs/vue3";

const notifications = ref([]);
const page = usePage();

async function fetchNotifications() {
  try {
    const { data } = await axios.get(route("notifications.index"));
    notifications.value = data;
  } catch (e) {
    console.log(e);
  }
}

async function markAsRead(id) {
  try {
    await axios.put(route("notifications.read", [id]));
    notifications.value = notifications.value.filter(n => n.id !== id);
  } catch (e) {
    console.log(e);
  }
}

async function markAllAsRead() {
  try {
    await axios.put(route("notifications.readall"));
    notifications.value = [];
  } catch (e) {
    console.log(e);
  }
}

function getIcon(type) {
  switch (type) {
    case "PROJECT":
      return BriefcaseIcon;
    case "COMMENT":
      return ChatBubbleLeftIcon;
    case "TASK":
      return DocumentCheckIcon;
    default:
      return BellAlertIcon;
  }
}

onMounted(() => {
  // window.Echo.private('notifications.' + page.props.value.auth.user?.id)
  //   .notification((notification) => {
  //     fetchNotifications()
  //   });
});

onBeforeMount(() => {
  fetchNotifications();
});
</script>

<style scoped>

</style>