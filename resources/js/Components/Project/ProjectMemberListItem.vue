<template>
  <li class="flex items-center justify-between space-x-3 py-2">
    <div class="flex min-w-0 flex-1 items-center space-x-3">
      <div class="flex-shrink-0">
        <img class="h-9 w-9 rounded-full" :src="user.avatar" alt="" />
      </div>
      <div class="min-w-0 flex-1">
        <p class="truncate text-sm font-medium text-gray-900">
          {{ user.name }}
          <span class="text-xxs inline-flex px-1 bg-orange-300 rounded-xl" v-if="user.is_owner">Owner</span>
          <span class="text-xxs inline-flex px-1 bg-teal-300 rounded-xl" v-else-if="user.is_admin">Admin</span>
        </p>
        <p class="truncate text-xs font-medium text-gray-500">{{ user.email }}</p>
        
      </div>
    </div>

    <div class="flex-shrink-0">
      <template v-if="canAdd">
        <button type="button"
                @click="toggleMembership()"
                class="inline-flex items-center rounded-full border border-transparent bg-gray-100 py-2 px-3 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
          <UserPlusIcon class="h-4" />
          <span class="text-xs ml-1 font-medium text-gray-900">
            Add to project
          </span>
        </button>
      </template>

      <div class="flex items-center gap-x-2" v-else-if="!user.is_owner">
        <button @click="toggleMembership()"
                class="flex items-center text-danger-500 hover:text-danger-600 gap-x-1 text-xs">
          <UserMinusIcon class="h-4" />
          Remove from project
        </button>
        <button v-if="user.is_admin && user.id !== $page.props.auth.user.id" @click="setAdminStatus()"
                class="flex items-center text-danger-500 hover:text-danger-600 gap-x-1 text-xs">
          <UserMinusIcon class="h-4" />
          Remove admin
        </button>
        <button v-else-if="!user.is_admin" @click="setAdminStatus()"
                class="flex items-center text-green-700 hover:text-green-800 gap-x-1 text-xs">
          <UserPlusIcon class="h-4" />
          Make project admin
        </button>
      </div>
    </div>
  </li>
</template>

<script setup>
import { UserMinusIcon, UserPlusIcon } from "@heroicons/vue/24/outline";

const props = defineProps({
  user: Object,
  canAdd: Boolean
});

function setAdminStatus() {
  router.put(route("projects.role", [
    route().params.project,
    props.user.id
  ]), {}, {
    preserveScroll: true,
    onSuccess: () => null,
    onError: (e) => console.log(e)
  });
}

function toggleMembership() {
  router.put(route("projects.members", [
    route().params.project,
    props.user.id
  ]), {}, {
    preserveScroll: true,
    onSuccess: () => null,
    onError: (e) => console.log(e)
  });
}
</script>

<style scoped>

</style>