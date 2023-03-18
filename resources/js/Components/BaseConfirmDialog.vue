<template>
  <div class="fixed h-screen w-screen bg-red-400">
    <!-- The modal component body -->
    <button @click="emit('confirm')">Confirm</button>
    <button @click="emit('cancel')">Cancel</button>
  </div>
</template>

<script setup>
const emit = defineEmits(["confirm", "cancel"]);
</script>

<style scoped>

</style>