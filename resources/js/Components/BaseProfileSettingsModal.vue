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
              class="w-full transform rounded-lg bg-white text-left align-middle shadow-xl transition-all max-w-2xl"
            >
              <TabGroup :defaultIndex="0">
                <DialogTitle class="bg-white border-b">
                  <div
                    class="flex items-center py-3 justify-between font-medium text-lg px-4 leading-6 text-gray-900">
                    <div class="font-semibold text-gray-700">
                      My Settings
                    </div>
                    <button
                      @click="$emit('close')"
                      class="rounded-full p-2 bg-white hover:bg-slate-100"
                    >
                      <XMarkIcon class="h-5 w-5" />
                    </button>
                  </div>
                  <TabList class="border-b border-gray-200 flex gap-x-4 px-4">
                    <Tab
                      v-for="tab in tabs"
                      :key="tab.id"
                      as="template"
                      v-slot="{ selected }">
                      <button :aria-current="selected ? 'page' : undefined"
                              :class="[selected ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300', 'outline-0 whitespace-nowrap pb-2 px-1 border-b-2 font-medium text-sm']">
                        {{ tab.name }}
                      </button>
                    </Tab>
                  </TabList>
                </DialogTitle>

                <DialogDescription as="div" class="p-8" v-bind="$attrs">
                  <TabPanels class="mt-2">
                    <TabPanel>
                      <ProfileSettingsForm :user="user" />
                    </TabPanel>
                    <TabPanel>
                      <ProfileSettingsPasswordForm :user="user" />
                    </TabPanel>
                  </TabPanels>
                </DialogDescription>

              </TabGroup>
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
  DialogDescription, TabGroup, TabList, Tab, TabPanels, TabPanel
} from "@headlessui/vue";
import ProfileSettingsForm from "@/Components/Forms/ProfileSettingsForm.vue";
import ProfileSettingsPasswordForm from "@/Components/Forms/ProfileSettingsPasswordForm.vue";
import { usePage } from "@inertiajs/vue3";

defineProps({
  isOpen: { type: Boolean, default: false },
  size: { type: String, default: "2xl" }
});
defineEmits(["close"]);

const { user } = usePage().props.auth;
const slots = useSlots();

const tabs = [
  { id: "profile", name: "Profile" },
  // { id: "notifications", name: "Notifications" },
  { id: "password", name: "Password and security" }
];
</script>

<style scoped></style>
