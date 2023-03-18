<template>
  <div>
    <label class="block text-sm font-semibold leading-6 text-gray-900">Site {{ type }}</label>
    <AvatarUploader
      @crop-success="handleFileInputChange"
      @crop-upload-success="handleFileInputChange"
      v-model="showCropper"
      :width="220"
      :height="220"
      langType="en"
      no-circle
      img-format="png"
    />
    <div class="mt-2 flex items-center">
      <img class="inline-block bg-dark-900 max-h-10 rounded p-1 ring-1 ring-offset-2 ring-primary-600"
           :src="file"
           alt="" />
      <button type="button"
              @click="showCropper = true"
              class="ml-5 rounded-md border border-gray-300 bg-white py-1.5 px-2.5 text-sm font-semibold text-gray-900 shadow-sm hover:bg-gray-50">
        Change {{ type }}
      </button>
    </div>
  </div>
</template>

<script setup>
import AvatarUploader from "vue-image-crop-upload";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
  file: String,
  type: { type: String, default: "Large logo" }
});
const showCropper = ref(false);
const form = useForm({
  file: null
});

async function handleFileInputChange(e) {
  form.avatar = DataURIToBlob(e);
  await form.post(route("profile.avatar"), {
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
