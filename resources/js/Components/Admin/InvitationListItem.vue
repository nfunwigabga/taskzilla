<template>
  <li
    class="flex items-center justify-between transition-all duration-300 rounded-lg px-2 gap-x-2 py-1 hover:bg-gray-50">
    <div class="flex flex-col">
      <span class="text-gray-800 leading-relaxed">{{ invitation.recipient }}</span>
      <span class="text-xxs text-gray-500">{{ invitation.days_old }}</span>
    </div>
    <div class="flex items-center">

      <BaseFormButton
        color="lightred"
        type="button"
        class="text-xs !px-0 !py-0"
        :loading="deleting"
        @click="destroy">
        Delete
      </BaseFormButton>

      <BaseFormButton
        color="lightgreen"
        type="button"
        class="text-xs !px-0 !py-0"
        :loading="resending"
        @click="resend">
        Resend
      </BaseFormButton>
    </div>
  </li>
</template>

<script setup>
import BaseFormButton from "@/Components/BaseFormButton.vue";
import { useConfirm } from "v3confirm";

const confirm = useConfirm();

const props = defineProps({
  invitation: Object,
  isReceived: {
    type: Boolean,
    default: false
  }
});

const resending = ref(false);
const deleting = ref(false);

function resend() {
  resending.value = true;
  router.put(route("admin.invitations.resend", [props.invitation.id]), {}, {
    preserveScroll: true,
    onSuccess: (_) => null,
    onError: (error) => console.log(error),
    onFinish: () => resending.value = false
  });
}

function destroy() {
  confirm.show("Are you sure?").then((ok) => {
    if (ok) {
      deleting.value = true;
      router.delete(route("admin.invitations.destroy", [props.invitation.id]), {}, {
        preserveScroll: true,
        onSuccess: (_) => null,
        onError: (error) => console.log(error),
        onFinish: () => deleting.value = false
      });
    } else {
      console.log("Declined");
    }
  });

}

</script>

<style scoped>

</style>