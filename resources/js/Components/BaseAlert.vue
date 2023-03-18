<template>
  <SectionMessage :appearance="appearance" :title="title">
    <slot />
  </SectionMessage>
</template>

<script setup>
import { SectionMessage } from "@spartez/vue-atlaskit-next";
import { computed } from "vue";

const props = defineProps({
  type: {
    type: String,
    default: "success"
  },
  title: {
    type: String,
    defaultL: ""
  }
});

const appearance = computed(() => {
  switch (props.type) {
    case "success":
      return "confirmation";
    case "danger":
      return "error";
    case "warning":
      return "warning";
    default:
      return "info";
  }
});
</script>

<style scoped></style>
