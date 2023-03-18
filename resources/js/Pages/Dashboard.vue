<template>
  <div class="px-4 md:px-0 py-5">
    <BasePage>
      <Head>
        <title>{{$page.props.auth.user?.name}} Home </title>
      </Head>
      <Teleport to="#header-left" v-if="isMounted">
        <h2 class="font-bold text-xl">Home</h2>
      </Teleport>

      <div class="h-full md:p-6">
        <section class="flex flex-col mb-4 md:mb-12 justify-center items-center">
          <h4 class="font-bold text-xl text-gray-700 mb-3">{{ currentDate() }}</h4>
          <h2 class="text-2xl md:text-4xl font-bold text-gray-600">
            Greetings {{ auth.user?.name }}!
          </h2>
        </section>

        <section class="grid grid-cols-1 md:grid-cols-12 gap-4">
          <div class="col-span-6">
            <BaseCard>
              <template #header>Projects</template>
              <template v-if="!auth.projects?.length">
                <div class="text-center py-4">
                  <FolderPlusIcon class="mx-auto h-12 w-12 text-gray-300" />
                  <h3 class="mt-2 text-sm font-medium text-gray-900">No projects</h3>
                  <p class="mt-1 text-sm text-gray-500">You are not a member of any project yet!</p>
                  <div class="mt-6" v-if="auth.user.is_admin || auth.user.is_superadmin">
                    <button
                      @click.prevent="$inertia.get(route('projects.create'))"
                      type="button"
                      class="inline-flex items-center rounded-md border border-transparent bg-primary-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                      <PlusIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                      New Project
                    </button>
                  </div>
                </div>
              </template>

              <template v-else>
                <div class="grid grid-cols-1 gap-2 sm:grid-cols-4">
                  <ProjectCreateForm type="button" />
                  <ProjectsListItem
                    v-for="project in auth.projects"
                    :project="project"
                    :key="project.id" />
                </div>
              </template>
            </BaseCard>

            <div class="my-4">
              <BaseCard class="py-2 px-2">
                <template #header>Team members</template>
                <ul role="list" class="grid gap-x-4 gap-y-4 grid-cols-1 md:grid-cols-2 md:gap-y-4">
                  <li v-for="user in users" :key="user.id">
                    <Link :href="route('users.show', user.id)"
                          class="flex items-center gap-x-2 md:gap-x-4 hover:bg-dark-100 rounded-md p-2">
                      <img class="h-12 w-12 md:h-16 md:w-16  rounded-full" :src="user.avatar" alt="" />
                      <div>
                        <h3 class="text-base font-semibold leading-4 md:leading-7 tracking-tight text-gray-900">
                          {{ user.name }}</h3>
                        <p class="text-sm font-semibold leading-6 text-indigo-600">{{ user.role }}</p>
                      </div>
                    </Link>
                  </li>
                </ul>
              </BaseCard>
            </div>
          </div>

          <div class="col-span-6">
            <BaseTabsCard>
              <template #header>
                My Tasks
              </template>
              <template #tabs>
                <Tab
                  v-for="tab in tabs"
                  :key="tab.id"
                  as="template"
                  v-slot="{ selected }">
                  <button :aria-current="selected ? 'page' : undefined"
                          :class="[selected ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300', 'outline-0 whitespace-nowrap pb-2 px-1 border-b-2 font-medium text-sm']">
                    {{ tab.name }}
                  </button>
                </Tab>
              </template>
              <TabPanel>
                <ul class="pt-2 px-3 pb-6 max-h-60 overflow-y-auto"
                    v-if="tasks.open?.length">
                  <TaskListItem v-for="task in tasks.open" :task="task" />
                </ul>
                <div class="p-6" v-else>You don't have any open assigned tasks.</div>
              </TabPanel>
              <TabPanel>
                <ul class="pt-2 px-3 pb-6 max-h-60 overflow-y-auto"
                    v-if="tasks.reported?.length">
                  <TaskListItem v-for="task in tasks.reported" :task="task" />
                </ul>
                <div class="p-6" v-else>No reported tasks.</div>
              </TabPanel>
              <TabPanel class="pb-6">
                <ul class="pt-2 px-3 max-h-60 overflow-y-auto"
                    v-if="tasks.resolved?.length">
                  <TaskListItem v-for="task in tasks.resolved" :task="task" />
                </ul>
                <div class="p-6" v-else>No recently closed tickets.</div>
              </TabPanel>
            </BaseTabsCard>
          </div>
        </section>
      </div>
    </BasePage>
  </div>
</template>

<script setup>
import { useMounted } from "@/Composables/useMounted";
import BasePage from "@/Components/BasePage.vue";
import BaseCard from "@/Components/BaseCard.vue";
import ProjectCreateForm from "@/Components/Forms/ProjectCreateForm.vue";
import ProjectsListItem from "@/Components/Project/ProjectsListItem.vue";
import { PlusIcon, FolderPlusIcon } from "@heroicons/vue/24/outline";
import { usePage } from "@inertiajs/vue3";
import { Tab, TabPanel } from "@headlessui/vue";
import BaseTabsCard from "@/Components/BaseTabsCard.vue";
import TaskListItem from "@/Components/Tasks/TaskListItem.vue";
import { computed, watch } from "vue";


const props = defineProps({
  members: Object,
  tasks: [Array, Object],
  projects: Array,
  invitations: Array,
  auth: Object
});


const { isMounted } = useMounted();

const users = computed(() => props.members.data.filter(m => m.id !== props.auth.user.id));

const tabs = [
  { id: "open", name: "Open" },
  { id: "reported", name: "Reported" },
  { id: "closed", name: "Recently resolved" }
];


function currentDate() {
  return new Date()
    .toLocaleDateString("en-us", { weekday: "long", month: "long", day: "numeric", year: "numeric" });
}
</script>

<style>

</style>