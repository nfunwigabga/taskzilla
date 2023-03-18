<template>
  <Head>
    <title>{{project?.name}} </title>
  </Head>
  <div class="flex flex-col flex-1 bg-zinc-100">
    <ProjectNav v-if="project" :project="project" />
    <div class="flex-1 p-6 overflow-x-auto">
      <section class="grid grid-cols-1 sm:grid-cols-12 gap-4">
        <div class="col-span-12 md:col-span-6">
          <BaseCard class="h-full">
            <template #header>Project Info</template>
            <template #header-right v-if="project.can?.manage">
              <ProjectsListActions :project="project" type="button" />
            </template>
            <div class="grid grid-cols-3 text-sm">
              <span class="col-span-1 font-semibold">Start date</span>
              <span class="col-span-2" :class="{'italic text-xs': !project.due_date}">
                  {{ project.start_date || "Not set" }}
                </span>
              <span class="col-span-1 font-semibold">Due date</span>
              <span class="col-span-2" :class="{'italic text-xs': !project.due_date}">
                  {{ project.due_date || "Not set" }}
              </span>

            </div>
            <div v-if="project.description" v-html="project.description" class="py-1" />
            <div v-else class="italic text-sm">No project description provided</div>
          </BaseCard>
        </div>

        <div class="col-span-12 md:col-span-6">
          <BaseCard class="h-full">
            <template #header>Project Members</template>
            <ul class="divide-y divide-gray-200 border-t border-b border-gray-200">
              <ProjectMemberListItem
                v-for="user in project.members"
                :key="user.id"
                :user="user" />
            </ul>

            <div class="my-8" v-if="otherUsers.length > 0">
              <h3 class="text-sm font-semibold text-gray-600">Other team members</h3>
              <ul role="list" class="mt-1 divide-y divide-gray-200 border-t border-b border-gray-200">
                <ProjectMemberListItem
                  v-for="user in otherUsers"
                  :key="user.id"
                  :user="user"
                  can-add />
              </ul>
            </div>
          </BaseCard>
        </div>

        <div class="col-span-12">
          <BaseCard class="h-full">
            <template #header>Manage Project Codes</template>
            <ProjectCodeSettingsItem
              v-for="code in Object.keys(project.codes)"
              :key="code"
              :code="code"
              :codes="project.codes[code]" />
          </BaseCard>
        </div>
      </section>
    </div>
  </div>
</template>

<script setup>

import BaseCard from "@/Components/BaseCard.vue";
import ProjectCodeSettingsItem from "@/Components/Project/ProjectCodeSettingsItem.vue";
import ProjectMemberListItem from "@/Components/Project/ProjectMemberListItem.vue";
import ProjectsListActions from "@/Components/Project/ProjectsListActions.vue";
import ProjectNav from "@/Components/Project/ProjectNav.vue";
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";

const props = defineProps({
  project: Object,
  codes: Object,
  sections: Array,
  users: Object
});

const otherUsers = computed(() => {
  const memberIds = props.project.members.map(member => member.id);
  return props.users.data.filter(u => !memberIds.includes(u.id));
});

</script>

<style scoped>

</style>