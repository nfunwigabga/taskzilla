<template>
  <nav class="mt-5 flex flex-1 flex-col divide-y divide-dark-700 overflow-y-auto" aria-label="Sidebar">
    <div class="space-y-1">
      <a v-for="item in navigation"
         :key="item.route"
         :href="route(item.route_name)"
         :class="[route().current(item.route_name) ? 'bg-dark-800 text-white' : 'text-dark-100 hover:text-white hover:bg-dark-700',
                    'group flex items-center px-2 py-2 text-sm leading-6 font-medium']"
         :aria-current="route().current(item.route_name) ? 'page' : undefined">
        <component :is="item.icon" class="mr-4 h-5 w-5 flex-shrink-0 text-dark-200" aria-hidden="true" />
        {{ item.name }}
      </a>
    </div>

    <div class="mt-3 pt-3" v-if="favorites.length">
      <ProjectSidebarList
        title="Favorites"
        :projects="favorites" />
    </div>

    <div class="mt-3 pt-3">
      <ProjectSidebarList
        title="Projects"
        :projects="$page.props.auth.projects"
        show-active />
    </div>

    <!-- ADMIN NAV -->
    <div class="pt-3 mt-auto" v-if="$page.props.auth.user?.is_admin || $page.props.auth.user?.is_superadmin">
      <div class="flex items-center gap-x-1 px-3 mb-2">
        <h1 class="uppercase text-xs text-slate-500 font-semibold">
          administrator
        </h1>
      </div>
      <div class="space-y-1">
        <a v-for="item in adminNav"
           :key="item.route"
           :href="route(item.route_name)"
           :class="[route().current(item.route_name) ? 'bg-dark-800 text-white' : 'text-dark-100 hover:text-white hover:bg-dark-700',
                    'group flex items-center px-2 py-2 text-sm leading-6 font-medium']"
           :aria-current="route().current(item.route_name) ? 'page' : undefined">
          <component :is="item.icon" class="mr-4 h-5 w-5 flex-shrink-0 text-dark-200" aria-hidden="true" />
          {{ item.name }}
        </a>
      </div>
    </div>
  </nav>
</template>

<script setup>
import ProjectSidebarList from "@/Components/Project/ProjectSidebarList.vue";
import { ClockIcon, CogIcon, HomeIcon, UsersIcon } from "@heroicons/vue/24/outline";
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";

const favorites = computed(() => usePage().props.auth.projects.filter(p => p.is_faved));

const navigation = [
  { name: "Home", route_name: "index", icon: HomeIcon, current: route().current("home") },
  { name: "My Tasks", route_name: "my.tasks", icon: ClockIcon, current: route().current("my.tasks") }
];

const adminNav = [
  {
    name: "Team Members",
    route_name: "admin.users.index",
    icon: UsersIcon,
    current: route().current("admin.users.index")
  },
  {
    name: "Site Settings",
    route_name: "admin.settings",
    icon: CogIcon,
    current: route().current("admin.settings")
  }
];
</script>

<style scoped>

</style>