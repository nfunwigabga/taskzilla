<template>
  <div class="flex -space-x-1 overflow-hidden">
    <Tooltip v-for="user in users" :key="user.id" :label="user.name">
      <img
        class="inline-block h-8 w-8 rounded-full ring-2 ring-white"
        :src="user.avatar"
        alt="">
    </Tooltip>
  </div>
</template>

<script setup>
import { Tooltip } from "@spartez/vue-atlaskit-next";

defineProps({
  users: Array
});
</script>

<style scoped>

</style>