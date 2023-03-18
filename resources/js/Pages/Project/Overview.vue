<template>
  <div class="h-full bg-zinc-100">
    <Head :title="project?.name" />
    <ProjectNav v-if="project" :project="project" />

    <div class="px-4 md:px-0 py-10">
      <BasePage>
        <div class="flex flex-wrap items-center justify-center sm:justify-end gap-4">
          <div class="flex items-center gap-x-2">
            <input class="rounded" id="assigned_to_me" v-model="form.assigned_to_me" type="checkbox" />
            <label for="assigned_to_me">
              Assigned to me
            </label>
          </div>
          <div class="flex items-center gap-x-2">
            <input class="rounded" id="reported_by_me" v-model="form.reported_by_me" type="checkbox" />
            <label for="reported_by_me">
              Reported by me
            </label>
          </div>
          <BaseFormSelect
            clearable
            class="min-w-[10rem]"
            :options="[
                          {id: 'all', name: 'All time'},
                          {id: '7d', name: 'Past 7 days'},
                          {id: '30d', name: 'Past 30 days'},
                          {id: '90d', name: 'Past 90 days'},
                      ]"
            label-field="name"
            v-model="form.period"
            placeholder="Period" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mt-6">
          <div class="col-span-4">
            <BaseCard>
              <template #header>Tasks by Type</template>
              <CodePieChart v-if="chart_data.type?.labels?.length"
                            :chart-data="chart_data.type"></CodePieChart>
              <p class="q-py-lg" v-else>No data available</p>
            </BaseCard>
          </div>

          <div class="col-span-4">
            <BaseCard>
              <template #header>Tasks by Priority</template>
              <CodePieChart v-if="chart_data.priority?.labels?.length"
                            :chart-data="chart_data.priority"></CodePieChart>
              <p class="q-py-lg" v-else>No data available</p>
            </BaseCard>
          </div>

          <div class="col-span-4">
            <BaseCard>
              <template #header>Tasks by Assignee</template>
              <CodePieChart v-if="chart_data.assignee?.labels?.length"
                            :chart-data="chart_data.assignee"></CodePieChart>
              <p class="q-py-lg" v-else>No data available</p>
            </BaseCard>
          </div>

          <div class="col-span-4">
            <BaseCard>
              <template #header>Tasks by Reporter</template>
              <CodePieChart v-if="chart_data.reporter?.labels?.length"
                            :chart-data="chart_data.reporter"></CodePieChart>
              <p class="q-py-lg" v-else>No data available</p>
            </BaseCard>
          </div>
        </div>


      </BasePage>
    </div>
  </div>
</template>

<script setup>

import ProjectNav from "@/Components/Project/ProjectNav.vue";
import BasePage from "@/Components/BasePage.vue";
import { pickBy } from "lodash";
import { router } from "@inertiajs/vue3";
import { ref } from "vue";
import BaseCard from "@/Components/BaseCard.vue";
import CodePieChart from "@/Components/Charts/CodePieChart.vue";
import BaseFormSelect from "@/Components/BaseFormSelect.vue";

const props = defineProps({
  project: Object,
  filters: Object,
  chart_data: Object
});

const form = ref({
  assigned_to_me: false,
  reported_by_me: false,
  period: "all"
});


watch(() => form, () => {
  const params = pickBy(form.value);
  router.get(route("projects.overview", [
    props.project.id
  ]), params, {
    preserveState: true,
    preserveScroll: true,
    onSuccess: () => console.log("Done")
  });
}, { deep: true });
</script>

<style scoped>

</style>