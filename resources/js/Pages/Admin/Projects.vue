<template>
  <div class="px-4 md:px-0 py-10">
    <BasePage>
      <Head>
        <title>Team Projects</title>
      </Head>
      <Teleport to="#header-left" v-if="isMounted">
        <h2 class="font-bold text-xl">Admin - Team Projects</h2>
      </Teleport>

      <BaseCard class="p-0">
        <template #header>
          <Link :href="route('projects.create')"
                class="bg-primary-600 hover:bg-primary-700 px-2 py-1.5 text-white rounded font-normal text-sm">
            Create project
          </Link>
        </template>

        <template #header-right>
          <BaseFormInput class="min-w-[14rem]" placeholder="Search..." v-model="params.q" />
        </template>

        <table class="min-w-full">
          <thead class="border-b border-dark-400">
          <tr>
            <th scope="col"
                class="py-2 pl-4 pr-3 text-left text-xs uppercase font-semibold text-gray-900 sm:pl-6">NAME
            </th>
            <th scope="col"
                class="px-3 hidden md:table-cell py-2 text-left text-xs uppercase font-semibold text-gray-900">
              Created by
            </th>
            <th scope="col"
                class="px-3 hidden md:table-cell py-2 text-left text-xs uppercase font-semibold text-gray-900">Members
            </th>
            <th scope="col" class="px-3 py-2 text-left text-xs uppercase font-semibold text-gray-900">
            </th>
          </tr>
          </thead>
          <tbody class="bg-white">
          <tr v-for="(project, idx) in projects.data" :key="project.id"
              :class="[idx === 0 ? 'border-dark-300' : 'border-gray-200', 'border-t']">
            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                    <span
                      :class="[`bg-${project.color}-600`, 'inline-flex items-center justify-center h-10 w-10 rounded-lg']">
                      <component :is="iconPicker[project.icon]" class="h-6 w-6 text-white" aria-hidden="true" />
                    </span>
                </div>

                <div class="ml-4">
                  <div class="font-medium text-gray-900">
                    {{ project.name }}
                    <span
                      :class="[!project.is_archived ? 'text-green-700 bg-green-100' : 'text-gray-500 bg-gray-100', 'inline-flex rounded-full px-2 ml-1 text-xs font-semibold leading-5']">
                      {{ project.is_archived ? "Archived" : "Active" }}
                    </span>
                  </div>
                </div>
              </div>
            </td>

            <td class="whitespace-nowrap hidden md:table-cell px-3 py-4 text-sm text-gray-500">
              <div class="inline-flex items-center gap-x-2" :label="project.owner.name">
                <BaseAvatar class="h-7 w-7" :avatar="project.owner?.avatar" />
                <span>{{ project.owner.name }}</span>
              </div>

            </td>

            <td class="whitespace-nowrap hidden md:table-cell px-3 py-4 text-sm text-gray-500">
              <BaseAvatarGroup :users="project.members" />
            </td>

            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">

              <Menu as="div" class="relative inline-block text-left">
                <div>
                  <MenuButton
                    class="inline-flex items-center w-full justify-center rounded bg-white px-2 py-1 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 focus:ring-offset-gray-100">
                    Actions
                    <ChevronDownIcon class="-mr-1 ml-2 h-4 w-4" aria-hidden="true" />
                  </MenuButton>
                </div>

                <transition enter-active-class="transition ease-out duration-100"
                            enter-from-class="transform opacity-0 scale-95"
                            enter-to-class="transform opacity-100 scale-100"
                            leave-active-class="transition ease-in duration-75"
                            leave-from-class="transform opacity-100 scale-100"
                            leave-to-class="transform opacity-0 scale-95">
                  <MenuItems
                    class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                    <div class="py-1">
                      <MenuItem v-slot="{ active }">
                        <a :href="project._links.list"
                           :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                          View project
                        </a>
                      </MenuItem>

                      <MenuItem v-slot="{ active }">
                        <button @click="toggleStatus(project.id)"
                                :class="[{'bg-red-50': active && !project.is_archived}, {'bg-green-50': active && project.is_archived}, !project.is_archived ? 'text-red-700':'text-green-700']"
                                class="block w-full text-left px-4 py-2 text-sm">
                          {{ project.is_archived ? "Unarchive" : "Archive" }} Project
                        </button>
                      </MenuItem>
                    </div>
                  </MenuItems>
                </transition>
              </Menu>
            </td>
          </tr>
          </tbody>
        </table>

        <div
          class="grid border px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
          <span class="flex items-center col-span-3">
              Showing {{ meta.from }}-{{ meta.to }} of {{ meta.total }}
          </span>
          <span class="col-span-2"></span>
          <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
            <BasePagination :links="meta.links" />
          </span>
        </div>
      </BaseCard>
    </BasePage>
  </div>
</template>

<script setup>


import { useMounted } from "@/Composables/useMounted";
import { ref, watch } from "vue";
import { debounce, pickBy } from "lodash";
import BasePage from "@/Components/BasePage.vue";
import BaseCard from "@/Components/BaseCard.vue";
import BaseFormInput from "@/Components/BaseFormInput.vue";
import BasePagination from "@/Components/BasePagination.vue";
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";
import { ChevronDownIcon } from "@heroicons/vue/20/solid";
import { router } from "@inertiajs/vue3";
import { iconPicker } from "@/Helpers/icons";
import BaseAvatar from "@/Components/BaseAvatar.vue";
import { Tooltip } from "@spartez/vue-atlaskit-next";
import BaseAvatarGroup from "@/Components/BaseAvatarGroup.vue";
import { useConfirm } from "v3confirm";

const props = defineProps({
  projects: Object,
  filters: Object
});

const { isMounted } = useMounted();
const { meta } = props.projects;
const params = ref({
  q: props.filters.q || null
});

const confirm = useConfirm();

watch(() => params, () => {
  search();
}, { deep: true });


const search = debounce(() => {
  let search_params = pickBy(params.value);
  router.get(route("admin.projects.index"), search_params, {
    replace: true,
    preserveState: true,
    preserveScroll: true
  });
}, 150);


function toggleStatus(projectId) {
  confirm.show("Are you sure?").then((ok) => {
    if (ok) {
      router.put(route("projects.archive", [
        projectId
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

</script>

<style scoped>

</style>