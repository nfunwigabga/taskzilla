<template>
  <div class="grid grid-cols-12">
    <div class="col-span-12">
      <TaskCommentItem
        v-for="comment in task.comments"
        :key="comment.id"
        :task="task"
        :comment="comment" />
    </div>
  </div>
</template>

<script setup>
import TaskCommentItem from "@/Components/Tasks/TaskCommentItem.vue";

defineProps({
  task: Object
});
</script>

<style scoped>

</style>