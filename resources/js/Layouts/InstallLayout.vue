<template>
  <div class="h-screen px-16 py-12 container">
    <div class="grid grid-cols-4">
      <div class="col-span-1">

        <nav aria-label="Progress">
          <ol role="list" class="overflow-hidden">
            <li v-for="(step, stepIdx) in steps" :key="step.name"
                :class="[stepIdx !== steps.length - 1 ? 'pb-10' : '', 'relative']">
              <template v-if="step.status === 'complete'">
                <div v-if="stepIdx !== steps.length - 1"
                     class="absolute top-4 left-4 -ml-px mt-0.5 h-full w-0.5 bg-primary-600" aria-hidden="true" />
                <div class="group relative flex items-center">
                  <span class="flex h-9 items-center">
                    <span
                      class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full bg-success-500 group-hover:bg-primary-800">
                      <CheckIcon class="h-5 w-5 text-white" aria-hidden="true" />
                    </span>
                  </span>
                  <span class="ml-4 flex min-w-0 flex-col">
                    <span class="text-base font-medium">{{ step.name }}</span>
                  </span>
                </div>
              </template>
              <template v-else-if="step.status === 'current'">
                <div v-if="stepIdx !== steps.length - 1"
                     class="absolute top-4 left-4 -ml-px mt-0.5 h-full w-0.5 bg-gray-300" aria-hidden="true" />

                <div class="group relative flex items-center" aria-current="step">
                  <span class="flex h-9 items-center" aria-hidden="true">
                    <span
                      class="relative z-10 flex h-9 w-9 items-center justify-center rounded-full p-px bg-white">
                      <span class="absolute flex h-9 w-9 p-px" aria-hidden="true">
                        <span class="h-full w-full rounded-full bg-indigo-200" />
                      </span>
                      <span class="relative block h-4 w-4 rounded-full bg-indigo-600/40" aria-hidden="true" />
                    </span>
                  </span>
                  <span class="ml-4 flex min-w-0 flex-col">
                    <span class="text-base font-medium text-primary-600">{{ step.name }}</span>
                  </span>
                </div>
              </template>
              <template v-else>
                <div v-if="stepIdx !== steps.length - 1"
                     class="absolute top-4 left-4 -ml-px mt-0.5 h-full w-0.5 bg-gray-300" aria-hidden="true" />
                <div class="group relative flex items-center">
                  <span class="flex h-9 items-center" aria-hidden="true">
                    <span
                      class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full border-2 border-gray-300 bg-white group-hover:border-gray-400">
                      <span class="h-2.5 w-2.5 rounded-full bg-transparent group-hover:bg-gray-300" />
                    </span>
                  </span>
                  <span class="ml-4 flex min-w-0 flex-col">
                    <span class="text-base font-medium text-gray-500">{{ step.name }}</span>
                  </span>
                </div>
              </template>
            </li>
          </ol>
        </nav>
      </div>
      <div class="col-span-3 h-full pb-4">
        <transition name="page" mode="out-in" appear :key="route().current()">
          <BaseCard class="h-full ">
            <slot />
          </BaseCard>
        </transition>
      </div>
    </div>
  </div>
</template>

<script setup>
import { CheckIcon } from "@heroicons/vue/20/solid";
import BaseCard from "@/Components/BaseCard.vue";
import { computed, watch } from "vue";

const props = defineProps({
  step: Number
});
//
// watch(() => props.step, (value) => {
//   console.log(value);
// });

const steps = computed(() => [
  { id: 0, name: "Start", status: getStatus(0) },
  {
    id: 1,
    name: "System requirements",
    status: getStatus(1)
  },
  {
    id: 2,
    name: "Database settings",
    status: getStatus(2)
  },
  {
    id: 3,
    name: "Mail settings",
    status: getStatus(3)
  },
  {
    id: 4,
    name: "Admin user",
    status: getStatus(4)
  }
]);

function getStatus(index) {
  let status = "complete";
  if (index === props.step) {
    status = "current";
  } else if (index > props.step) {
    status = "upcoming";
  }

  return status;
}

</script>

<style scoped>

</style>