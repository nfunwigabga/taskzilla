<template>
  <div class="px-4 md:px-0 py-10">
    <BasePage>
      <Head>
        <title>{{title}}</title>
      </Head>
      <Teleport to="#header-left" v-if="isMounted">
        <h2 class="font-bold text-xl">Admin - {{ title || "Settings" }}</h2>
      </Teleport>

      <Menu as="div" class="relative inline-block md:hidden mb-4 w-full text-left">
        <div>
          <MenuButton
            class="inline-flex w-full justify-between gap-x-1.5 rounded-md bg-white px-3 py-3 text-base font-semibold text-gray-800 shadow-sm ring-1 ring-inset ring-gray-100 hover:bg-gray-50">
            {{ currentRoute?.name }}
            <ChevronDownIcon class="-mr-1 h-5 w-5 text-gray-400" aria-hidden="true" />
          </MenuButton>
        </div>

        <transition enter-active-class="transition ease-out duration-100"
                    enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
                    leave-active-class="transition ease-in duration-75"
                    leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
          <MenuItems
            class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
            <div class="py-1">
              <MenuItem v-for="item in navigation" :key="item.route_name" v-slot="{ active }">
                <Link :href="route(item.route_name)"
                      :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'flex justify-between items-center px-4 py-3 text-md']">
                  <span>{{ item.name }}</span>
                  <CheckIcon class="h-4" v-if="item.current" />
                </Link>
              </MenuItem>
            </div>
          </MenuItems>
        </transition>
      </Menu>

      <div class="grid grid-cols-4 gap-4">
        <nav class="hidden md:block space-y-1 col-span-1" aria-label="Sidebar">
          <Link v-for="item in navigation" :key="item.route_name" :href="route(item.route_name)"
                :class="[item.current ? 'bg-zinc-200 text-gray-900' : 'text-gray-600 hover:bg-zinc-200 hover:bg-opacity-40 hover:text-gray-900', 'group flex items-center px-3 py-2 text-sm font-medium rounded-md transition duration-300']"
                :aria-current="item.current ? 'page' : undefined">
            <component :is="item.icon"
                       :class="[item.current ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500', 'flex-shrink-0 -ml-1 mr-3 h-6 w-6']"
                       aria-hidden="true" />
            <span class="truncate">{{ item.name }}</span>
          </Link>
        </nav>
        <BaseCard class="col-span-4 md:col-span-3">
          <slot />
        </BaseCard>
      </div>

    </BasePage>
  </div>
</template>

<script setup>

import BasePage from "@/Components/BasePage.vue";
import { useMounted } from "@/Composables/useMounted";
import BaseCard from "@/Components/BaseCard.vue";
import {
  CodeBracketSquareIcon,
  ChevronDownIcon,
  CogIcon,
  EnvelopeIcon,
  RectangleGroupIcon,
  CheckIcon
} from "@heroicons/vue/24/outline";
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
import { computed } from "vue";

const props = defineProps({
  title: String
});

const { isMounted } = useMounted();


const navigation = [
  {
    name: "Site Settings",
    route_name: "admin.settings",
    icon: CogIcon,
    current: route().current("admin.settings")
  }
  // {
  //   name: "Task Codes",
  //   route_name: "admin.settings.codes",
  //   icon: RectangleGroupIcon,
  //   current: route().current("admin.settings.codes")
  // },
  // {
  //   name: "App Update",
  //   route_name: "admin.settings.updates",
  //   icon: CodeBracketSquareIcon,
  //   current: route().current("admin.settings.updates")
  // }
];

const currentRoute = computed(() => navigation.find(n => n.current));
</script>

<style scoped>

</style>