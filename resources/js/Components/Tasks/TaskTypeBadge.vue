<template>
  <span class="flex cursor-pointer items-center">
      <span :class="`bg-${type?.color}-100 text-${type?.color}-700`"
            class="max-h-5 flex gap-x-1 items-center px-2 py-1 rounded-full font-semibold leading-tight text-xxs">
        <span class="h-1.5 w-1.5 rounded-full" :class="`bg-${type?.color}-400`" />
        {{ type?.display }}
      </span>
  </span>

</template>

<script setup>


defineProps({
  type: Object,
  size: {
    type: String,
    default: "14px"
  }
});
</script>

<style scoped>

</style>