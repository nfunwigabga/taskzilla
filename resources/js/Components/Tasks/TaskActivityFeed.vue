<template>
  <nav aria-label="Progress">
    <ol role="list" class="overflow-hidden">
      <template v-for="activity in activities" :key="activity.id">
        <li v-for="(change, changeIdx) in activity.changes" :key="changeIdx" class="relative pb-5">
          <div class="absolute top-4 left-4 -ml-px mt-0.5 h-full w-0.5 bg-gray-200" aria-hidden="true" />
          <div class="group relative flex items-start">
            <span class="flex h-9 items-center">
              <span
                class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full overflow-hidden group-hover:bg-indigo-800">
                <img :src="activity.causer?.avatar" class="h-8 w-8" alt="" />
              </span>
            </span>
            <span class="ml-4 flex flex-col min-w-0 items-centerx gap-x-2">
              <span class="text-xm font-medium">
                <a href="#" class="text-primary-600">{{ activity.causer?.name }}:</a>
                {{ change }}
              </span>
              <span class="text-xs text-gray-500">{{ activity.created_at }}</span>
            </span>
          </div>
        </li>
      </template>
    </ol>
  </nav>
</template>

<script setup>
import { CheckIcon } from "@heroicons/vue/20/solid";
import BaseAvatar from "@/Components/BaseAvatar.vue";

const props = defineProps({
  activities: Array
});


const steps = [
  { name: "Create account", description: "Vitae sed mi luctus laoreet.", href: "#", status: "complete" },
  {
    name: "Profile information",
    description: "Cursus semper viverra facilisis et et some more.",
    href: "#",
    status: "current"
  },
  { name: "Business information", description: "Penatibus eu quis ante.", href: "#", status: "upcoming" },
  { name: "Theme", description: "Faucibus nec enim leo et.", href: "#", status: "upcoming" },
  { name: "Preview", description: "Iusto et officia maiores porro ad non quas.", href: "#", status: "upcoming" }
];
</script>

<style scoped>

</style>