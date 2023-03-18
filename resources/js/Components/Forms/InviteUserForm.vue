<template>
  <div>
    <BaseFormButton type="button" class="px-0" v-bind="$attrs" @click="isOpen = true">
      <UserPlusIcon class="h-4 mr-1" />
      Invite user
    </BaseFormButton>

    <BaseModal size="lg" :is-open="isOpen" @close="isOpen=false">
      <template #title>
        <span class="font-semibold">Invite new user</span>
      </template>

      <div class="space-y-4">
        <form @submit.prevent="addEmail">
          <label for="email" class="block text-sm font-medium text-gray-700">
            Add email to invite
          </label>
          <div class="mt-1 w-full flex rounded-md shadow-sm">
            <div class="relative flex flex-grow items-stretch focus-within:z-10">
              <BaseFormInput
                v-model="email"
                placeholder="Enter email address"
                class="block w-full rounded-none rounded-l"
              />
            </div>
            <div>
              <button type="submit"
                      :disabled="!validateEmail(email)"
                      class="relative disabled:bg-opacity-50 disabled:cursor-not-allowed -ml-px inline-flex items-center rounded-r border border-l-0 border-gray-300 bg-gray-50 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 focus:border-primary-500 focus:outline-none focus:ring-1 focus:ring-primary-500">
                Add
              </button>
            </div>
          </div>
        </form>
        <div
          class="p-2 min-h-[6rem] max-h-[8rem] border overflow-y-auto gap-1 flex items-start flex-wrap flex-1 rounded bg-slate-100">
          <div v-for="(email,index) in form.emails"
               class="border border-gray-400 pl-4 pr-2 py-1 flex justify-between items-center text-sm font-medium rounded bg-white text-gray-800">
            <span>{{ email }}</span>
            <button @click="removeEmail(index)">
              <XCircleIcon class="h-5 w-5 ml-3" />
            </button>
          </div>
        </div>

        <div class="mt-4 flex justify-end">
          <BaseFormButton type="button" @click="submit"
                          :disabled="!form.isDirty"
                          :block="false" color="dark" :loading="form.processing">Send
          </BaseFormButton>
        </div>
      </div>


    </BaseModal>
  </div>
</template>

<script setup>

import { UserPlusIcon } from "@heroicons/vue/24/outline";
import { XCircleIcon } from "@heroicons/vue/24/solid";
import { validateEmail } from "@/Helpers/helpers";
import BaseModal from "@/Components/BaseModal.vue";
import BaseFormInput from "@/Components/BaseFormInput.vue";
import BaseFormButton from "@/Components/BaseFormButton.vue";
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";


const isOpen = ref(false);

const email = ref("");
const form = useForm({
  emails: []
});


function addEmail() {
  if (!validateEmail(email.value)) {
    return;
  }

  if (form.emails.includes(email.value)) {
    return;
  }

  form.emails.push(email.value);
  email.value = "";
}

function removeEmail(index) {
  form.emails.splice(index, 1);
}

function submit() {
  form.post(route("admin.invitations.invite"), {
    preserveScroll: true,
    onError: (error) => console.log(error),
    onSuccess: () => {
      form.reset();
      isOpen.value = false;
    }
  });
}
</script>

<style scoped>

</style>