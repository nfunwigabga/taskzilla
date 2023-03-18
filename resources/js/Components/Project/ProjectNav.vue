<template>
  <Teleport to="#header-left" v-if="isMounted">
    <div class="flex items-center gap-x-2">
      <div :class="`bg-${project.color}-600`"
           class="h-6 w-6 rounded flex items-center justify-center text-white">
        <component :is="iconPicker[project.icon]" class="h-4 w-4" />
      </div>
      <div class="flex flex-1 gap-x-2 items-center justify-between">
        <div class="flex items-center gap-x-1">
          <h2 class="font-bold text-lg">{{ project.name }}</h2>
        </div>
        <ProjectsListActions :project="project" type="button" />
      </div>
    </div>
  </Teleport>

  <div class="bg-white border-b pt-4 shadow px-4 md:px-0">
    <nav class="flex gap-x-6 mx-auto max-w-6xl">
      <Link :href="project._links?.overview"
            :class="route().current('projects.overview') ? 'active' : 'inactive'"
            class="navlink">
        Overview
      </Link>

      <Link :href="project._links?.list"
            :class="route().current('projects.list') ? 'active' : 'inactive'"
            class="navlink">
        List
      </Link>

      <Link :href="project._links?.board"
            :class="route().current('projects.board') ? 'active' : 'inactive'"
            class="navlink">
        Board
      </Link>

      <Link :href="project._links?.settings"
            v-if="project.can?.manage"
            :class="route().current('projects.settings') ? 'active' : 'inactive'"
            class="navlink">
        Project Settings
      </Link>
    </nav>
  </div>


  <div v-if="project.is_archived"
       class="flex border border-orange-200 my-1 px-6 py-3 items-center justify-between bg-orange-50">
    <div class="flex gap-x-1 items-center text-sm">
      <ArchiveBoxIcon class="h-4 text-gray-500" />
      This project has been archived. You can no longer create tasks.
    </div>
    <div>
      <button @click="toggleArchive"
              class="rounded-md text-xs px-3 font-bold py-1 bg-white hover:bg-gray-100 border border-gray-300">Restore
      </button>
    </div>
  </div>
</template>

<script setup>
import { LockClosedIcon } from "@heroicons/vue/24/outline";
import { useMounted } from "@/Composables/useMounted";
import { iconPicker } from "@/Helpers/icons";
import { ArchiveBoxIcon } from "@heroicons/vue/24/solid";
import ProjectsListActions from "@/Components/Project/ProjectsListActions.vue";
import { Tooltip } from "@spartez/vue-atlaskit-next";

const { isMounted } = useMounted();
const props = defineProps({
  project: Object
});

function toggleArchive() {
  router.put(route("projects.archive", [
    props.project.id
  ]), {}, {
    preserveScroll: true,
    onError: (error) => console.log(error),
    success: (_) => console.log("Done")
  });
}
</script>

<style lang="scss" scoped>

</style>