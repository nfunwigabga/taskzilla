<template>
  <div class="min-h-screen flex flex-col">
    <TransitionRoot as="template" :show="sidebarOpen">
      <Dialog as="div" class="relative z-40 lg:hidden" @close="sidebarOpen = false">
        <TransitionChild
          as="template"
          enter="transition-opacity ease-linear duration-300"
          enter-from="opacity-0"
          enter-to="opacity-100"
          leave="transition-opacity ease-linear duration-300"
          leave-from="opacity-100"
          leave-to="opacity-0">
          <div class="fixed inset-0 bg-gray-600 bg-opacity-75" />
        </TransitionChild>

        <div class="fixed inset-0 z-40 flex">
          <TransitionChild
            as="template"
            enter="transition ease-in-out duration-300 transform"
            enter-from="-translate-x-full"
            enter-to="translate-x-0"
            leave="transition ease-in-out duration-300 transform"
            leave-from="translate-x-0"
            leave-to="-translate-x-full">
            <DialogPanel class="relative flex w-full max-w-xs flex-1 flex-col bg-dark-900 pt-5 pb-4">
              <TransitionChild
                as="template"
                enter="ease-in-out duration-300"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="ease-in-out duration-300"
                leave-from="opacity-100"
                leave-to="opacity-0">
                <div class="absolute top-0 right-0 -mr-12 pt-2">
                  <button type="button"
                          class="ml-1 flex h-10 w-10 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                          @click="sidebarOpen = false">
                    <span class="sr-only">Close sidebar</span>
                    <XMarkIcon class="h-6 w-6 text-white" aria-hidden="true" />
                  </button>
                </div>
              </TransitionChild>
              <div class="h-0 flex-1 overflow-y-auto pt-5 pb-4">
                <a href="/" class="flex flex-shrink-0 items-center px-4">
                  <img class="h-8 w-auto" src="/logo.png" alt="Mobile logo" />
                </a>
                <SidebarLinks />
              </div>
            </DialogPanel>
          </TransitionChild>
          <div class="w-14 flex-shrink-0" aria-hidden="true"></div>
        </div>
      </Dialog>
    </TransitionRoot>

    <div class="hidden lg:fixed lg:inset-y-0 lg:flex lg:w-64 lg:flex-col">
      <div class="flex flex-grow flex-col overflow-y-auto bg-dark-900 pt-5 pb-4">
        <a href="/" class="flex flex-shrink-0 items-center px-4">
          <img class="h-8 w-auto" src="/logo.png" alt="Logo" />
        </a>
        <SidebarLinks />
      </div>
    </div>

    <div class="flex flex-1 flex-col lg:pl-64">
      <div class="flex h-16 flex-shrink-0 border-b border-gray-200 bg-white">
        <button type="button"
                class="border-r border-gray-200 px-4 text-gray-400 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500 lg:hidden"
                @click="sidebarOpen = true">
          <span class="sr-only">Open sidebar</span>
          <Bars3CenterLeftIcon class="h-6 w-6" aria-hidden="true" />
        </button>

        <div class="flex flex-1 justify-between px-4 md:px-0 lg:mx-auto lg:max-w-6xl">
          <div id="header-left" class="hidden sm:flex items-center mr-4 md:mr-6" />
          <div class="flex flex-1 relative">
            <SiteSearchInput />
          </div>

          <div class="ml-4 gap-x-3 flex items-center md:ml-6">
            <NavbarNotifications />
            <SiteNavUserDropdown :user="$page.props.auth?.user" />
          </div>
        </div>
      </div>
      <transition name="page" mode="out-in" appear :key="route().current()">
        <main class="flex flex-col flex-1 bg-zinc-100">
          <slot />
        </main>
      </transition>
    </div>
  </div>
  <BaseProfileSettingsModal :is-open="isOpen" @close="isOpen = false" />
  <Modal />
</template>

<script setup>
import { Modal } from "momentum-modal";
import {
  Dialog,
  DialogPanel,
  TransitionChild,
  TransitionRoot
} from "@headlessui/vue";
import {
  Bars3CenterLeftIcon,
  ClockIcon,
  HomeIcon,
  XMarkIcon,
  UsersIcon,
  CogIcon
} from "@heroicons/vue/24/outline";
import SiteNavUserDropdown from "@/Layouts/partials/SiteNavUserDropdown.vue";
import { useSettings } from "@/Composables/useSettings";
import { computed, ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import BaseProfileSettingsModal from "@/Components/BaseProfileSettingsModal.vue";
import SiteSearchInput from "@/Components/Search/SiteSearchInput.vue";
import NavbarNotifications from "@/Components/Notifications/NavbarNotifications.vue";
import ProjectSidebarList from "@/Components/Project/ProjectSidebarList.vue";
import SidebarLinks from "@/Layouts/partials/SidebarLinks.vue";

const { user } = usePage().props.auth;
const favorites = computed(() => usePage().props.auth.projects.filter(p => p.is_faved));
const { isOpen } = useSettings();


const sidebarOpen = ref(false);
</script>

<style lang="scss">
#confirm {
  .modal {
    @apply flex flex-col;
    @apply items-center justify-center;
    @apply overflow-hidden;
    @apply fixed z-[1000];
  }

  .modal.is-active {
    @apply flex;
  }

  .modal-background, .modal {
    @apply inset-0 absolute;
  }

  .modal-background {
    @apply bg-dark-900/80;
  }

  .modal-content,
  .modal-card {
    @apply my-0 mx-auto;
    @apply max-h-[calc(100vh-40px)];
    @apply w-full md:max-w-sm;
    @apply overflow-auto relative;
  }

  .modal-card {
    @apply flex flex-col overflow-hidden;
    @apply max-h-[calc(100vh-40px)];
  }

  .modal-card-head {
    @apply border-b border-b-dark-200 rounded-t-md;
  }

  .modal-card-head, .modal-card-foot {
    @apply flex flex-shrink-0 items-center;
    @apply bg-white;
    @apply relative p-4;
  }

  .modal-card-foot {
    @apply border-t-0 rounded-b-md;
    @apply flex gap-x-4 items-center;
    button {
      @apply px-4 py-1 rounded-md;
      @apply first:bg-red-100 first:text-danger-800 first:hover:bg-red-200;
      @apply last:bg-dark-200 last:text-dark-600 last:hover:bg-dark-300;
    }
  }
}
</style>