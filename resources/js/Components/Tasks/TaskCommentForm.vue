<template>
  <div class="bg-gray-100 p-6 border-t border-gray-200">
    <div class="flex">
      <BaseAvatar :avatar="$page.props.auth.user.avatar" class="h-8 w-8" />
      <form @submit.prevent="submit" class="group mt-0 ml-2 w-full relative block">
        <textarea :disabled="disabled"
                  v-model="form.body"
                  placeholder="Ask a question or post an update.."
                  required
                  class="transition-all focus:ring-primary-500 disabled:bg-gray-100/80 block peer bg-white w-full border border-gray-300 group-focus-within:border-gray-500 group-focus-within:h-[7rem] valid:h-[7rem] valid:pb-12 group-focus-within:pb-12 rounded-md resize-none w-full h-[2.85rem] text-sm outline-none p-3"></textarea>
        <div
          class="bg-white h-12 px-2 rounded-b-md absolute bottom-px left-px right-px opacity-0 transition-all invisible peer-valid:opacity-100 group-focus-within:opacity-100 peer-valid:visible group-focus-within:visible flex justify-between items-center">
          <div>&nbsp;</div>

          <div class="flex items-center gap-x-2 text-xs">
            <button v-if="isEditing" @click="emit('cancel')"
                    type="button"
                    class="px-2 py-2 bg-danger-100 border border-danger-200 rounded-md text-xs">
              Cancel
            </button>
            <BaseFormButton :block="false" class="text-xs" :loading="form.processing">
              {{ comment ? "Update" : "Post comment" }}
            </BaseFormButton>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>

import BaseAvatar from "@/Components/BaseAvatar.vue";
import BaseFormButton from "@/Components/BaseFormButton.vue";

const props = defineProps({
  task: Object,
  comment: Object,
  isEditing: Boolean,
  disabled: Boolean
});


const emit = defineEmits(["focused", "cancel"]);

const form = useForm({
  body: props.comment?.body || ""
});

function submit() {
  if (!form.isDirty) {
    return;
  }
  if (props.comment) {
    handleUpdate();
  } else {
    handleCreate();
  }

}

function handleCreate() {
  form.post(route("comments.store", [
    route().params.project,
    props.task.id
  ]), {
    preserveScroll: true,
    onSuccess: () => form.reset(),
    onError: (error) => console.log(error)
  });
}

function handleUpdate() {
  form.put(route("comments.update", [
    route().params.project,
    props.task?.id,
    props.comment?.id
  ]), {
    preserveScroll: true,
    onSuccess: () => {
      emit("cancel");
    },
    onError: (error) => console.log(error)
  });
}

</script>

<style scoped>

</style>