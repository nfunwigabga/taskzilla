<template>
  <TransitionRoot appear as="template" :show="show">
    <Dialog as="div" class="relative z-10">
      <TransitionChild
        @after-leave="redirect"
        as="template"
        enter="ease-in-out duration-300"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="ease-in-out duration-300"
        leave-from="opacity-100"
        leave-to="opacity-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-60 transition-opacity" />
      </TransitionChild>

      <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
          <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
            <TransitionChild
              as="template"
              enter="transform transition ease-in-out duration-300 sm:duration-500"
              enter-from="translate-x-full"
              enter-to="translate-x-0"
              leave="transform transition ease-in-out duration-300 sm:duration-500"
              leave-from="translate-x-0"
              leave-to="translate-x-full">
              <DialogPanel class="pointer-events-auto relative w-screen max-w-5xl md:max-w-md">
                <section class="absolute right-0 bottom-0 bg-white w-full h-full shadow flex flex-col">
                  <header class="h-14 border-b border-gray-200 px-4 flex items-center justify-between">
                    <DialogTitle class="text-lg font-medium text-gray-900">
                      <slot name="title" />
                    </DialogTitle>
                    <button @click="close" class="rounded-full bg-gray-100 transition p-2 hover:bg-gray-200">
                      <XMarkIcon class="h-5" />
                    </button>
                  </header>
                  <div class="py-3 pb-0 flex-1 overflow-auto">
                    <slot />
                  </div>
                  <slot name="footer" />
                </section>
              </DialogPanel>
            </TransitionChild>
          </div>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
import { useModal } from "momentum-modal";
import { DialogPanel, Dialog, DialogTitle, TransitionChild, TransitionRoot } from "@headlessui/vue";
import { XMarkIcon } from "@heroicons/vue/24/outline";
import { useSlots } from "vue";

const { show, close, redirect } = useModal();

defineProps({
  onClose: { type: Function, default: () => null }
});
const slots = useSlots();

</script>

<style scoped>

</style>