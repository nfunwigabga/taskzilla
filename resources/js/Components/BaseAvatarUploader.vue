<template>
  <div class="flex-none image-fit relative">
    <BaseAvatar class="w-24 h-24" :avatar="$page.props.auth.user?.avatar" />
    <button
      @click="showCropper.value = true"
      class="absolute mb-1 mr-1 flex items-center justify-center bottom-0 right-0 bg-primary-700 hover:bg-primary-600 rounded-full p-2"
    >
      <CameraIcon class="h-3 w-3 text-white" />
    </button>

  </div>
</template>

<script setup>

import { useToast } from "vue-toastification";
import { CameraIcon } from "@heroicons/vue/24/outline";
import BaseAvatar from "@/Components/BaseAvatar.vue";

const inputRef = ref(null);

const showCropper = ref(false);

const form = useForm({
  avatar: null
});

const toast = useToast();

async function handleFileInputChange(e) {
  form.avatar = DataURIToBlob(e);
  await form.post(`/account/avatar`, {
    onSuccess: () => {
      showCropper.value = false;
    },
    onError: (error) => console.log(error)
  });
}

function DataURIToBlob(dataURI) {
  const splitDataURI = dataURI.split(",");
  const byteString =
    splitDataURI[0].indexOf("base64") >= 0
      ? atob(splitDataURI[1])
      : decodeURI(splitDataURI[1]);
  const mimeString = splitDataURI[0].split(":")[1].split(";")[0];

  const ia = new Uint8Array(byteString.length);
  for (let i = 0; i < byteString.length; i++) ia[i] = byteString.charCodeAt(i);

  return new Blob([ia], { type: mimeString });
}
</script>

<style></style>
