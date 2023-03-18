<template>
  <StringLineEditableRenderer
    class="px-1"
    data-cy="editable"
    :value="form.title"
    @save-requested="submit" />
</template>

<script setup>
import { StringLineEditableRenderer } from "@spartez/vue-atlaskit-next";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
  task: Object
});

const form = useForm({
  title: props.task?.title || ""
});

function submit(value, callback) {
  if (!value) return;
  form.title = value;
  form.put(route("tasks.update", [
    props.task.project.id,
    props.task.id
  ]), {
    preserveScroll: true,
    preserveState: true,
    onError: (e) => console.log(e),
    onSuccess: (_) => callback()
  });
}
</script>

<style scoped>

</style>