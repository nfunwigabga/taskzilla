<template>
  <div>
    <TaskCommentForm
      @cancel="isEditing=false"
      :is-editing="isEditing"
      v-if="isEditing && editingCommentId === comment.id"
      :disabled="editingCommentId !== comment.id || task.project?.is_archived"
      :comment="comment"
      :task="task" />

    <div v-else class="py-3 border-b border-gray-200 last:border-none">
      <div class="flex items-start w-full gap-x-2">
        <BaseAvatar :avatar="comment.user.avatar" class="h-6 w-6" />
        <div class="flex-1">
          <div class="flex items-start gap-x-1">
            <Link :href="route('users.show', comment.user.id)" class="text-sm font-semibold hover:underline">
              {{ comment.user?.name }}
            </Link>
            <span class="mx-2">&bull;</span>
            <span class="text-xs text-gray-500">{{ comment.dates?.created_at_human }}</span>
            <div class="ml-auto" v-if="comment.can?.update && !task.project.is_archived">
              <Menu>
                <Float
                  :offset="12"
                  flip
                  arrow
                  placement="bottom-end"
                  enter="transition duration-200 ease-out"
                  enter-from="scale-95 opacity-0"
                  enter-to="scale-100 opacity-100"
                  leave="transition duration-150 ease-in"
                  leave-from="scale-100 opacity-100"
                  leave-to="scale-95 opacity-0"
                  tailwindcss-origin-class
                >
                  <MenuButton class="hover:bg-gray-200 w-8 h-8 rounded-full grid place-content-center">
                    <EllipsisHorizontalIcon class="w-5 h-5" />
                  </MenuButton>
                  <MenuItems class="w-48 bg-white border border-gray-200 rounded-md shadow-lg focus:outline-none">
                    <FloatArrow class="absolute bg-white w-5 h-5 rotate-45 border border-gray-200" />
                    <div class="relative bg-white rounded-md overflow-hidden">
                      <MenuItem v-slot="{active}">
                        <button @click="setEditing" :class="{'bg-gray-100': active}"
                                class="dropdown-item w-full">
                          Edit comment
                        </button>
                      </MenuItem>
                      <MenuItem v-slot="{active}">
                        <button @click.prevent="destroy()" :class="{'bg-red-100/30': active}"
                                class="dropdown-item w-full !text-red-600">
                          Delete comment
                        </button>
                      </MenuItem>
                    </div>
                  </MenuItems>
                </Float>
              </Menu>
            </div>
          </div>
          <div class="text-sm">
            {{ comment.body }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Menu, MenuItems, MenuButton, MenuItem } from "@headlessui/vue";
import { Float, FloatArrow } from "@headlessui-float/vue";
import { EllipsisHorizontalIcon } from "@heroicons/vue/24/outline";
import TaskCommentForm from "@/Components/Tasks/TaskCommentForm.vue";
import BaseAvatar from "@/Components/BaseAvatar.vue";
import { useConfirm } from "v3confirm";

const confirm = useConfirm();

const props = defineProps({
  comment: Object,
  task: Object
});

const { isEditing, editingCommentId } = useComment();

function setEditing() {
  editingCommentId.value = props.comment.id;
  isEditing.value = true;
}

function destroy() {
  confirm.show("Are you sure?").then((ok) => {
    if (ok) {
      router.delete(route("comments.destroy", [
        route().params.project,
        props.task.id,
        props.comment.id
      ]), {
        preserveScroll: true,
        onSuccess: () => null,
        onError: (error) => console.log(error)
      });
    } else {
      console.log("Declined");
    }
  });


}
</script>

<style scoped>

</style>