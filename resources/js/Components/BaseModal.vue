<template>

  <TransitionRoot appear :show="isOpen" as="template">
    <Dialog static as="div" class="relative z-10">
      <TransitionChild
        as="template"
        enter="duration-300 ease-out"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="duration-200 ease-in"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div class="fixed pointer-events-none inset-0 bg-black bg-opacity-25" />
      </TransitionChild>

      <div class="fixed inset-0 overflow-y-auto">
        <div
          class="flex min-h-full items-start mt-2 sm:mt-16 justify-center p-4 text-center"
        >
          <TransitionChild
            as="template"
            enter="ease-out duration-300"
            enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            enter-to="opacity-100 translate-y-0 sm:scale-100"
            leave="ease-in duration-200"
            leave-from="opacity-100 translate-y-0 sm:scale-100"
            leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          >
            <DialogPanel
              class="w-full transform rounded-lg bg-white text-left align-middle shadow-xl transition-all"
              :class="`max-w-${size}`"
            >
              <DialogTitle class="bg-white border-b">
                <div
                  class="flex items-center py-3 justify-between font-medium text-lg px-4 leading-6 text-gray-900">
                  <div class="font-semibold text-gray-700">
                    <slot name="title" />
                  </div>
                  <button
                    @click="$emit('close')"
                    class="rounded-full p-2 bg-white hover:bg-slate-100"
                  >
                    <XMarkIcon class="h-5 w-5" />
                  </button>
                </div>
                <template v-if="slots.tabs">
                  <slot name="tabs" />
                </template>
              </DialogTitle>
              <DialogDescription as="div" class="p-4" v-bind="$attrs">
                <slot />
              </DialogDescription>
              <div
                v-if="slots.footer"
                class="flex items-center justify-between font-medium text-lg border-t px-4 py-1 leading-6 text-gray-900"
              >
                <slot name="footer" />
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
import { XMarkIcon } from "@heroicons/vue/24/outline";
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogPanel,
  DialogTitle,
  DialogDescription
} from "@headlessui/vue";

defineProps({
  isOpen: { type: Boolean, default: false },
  size: { type: String, default: "2xl" }
});
defineEmits(["close"]);
const slots = useSlots();
</script>

<style scoped></style>
