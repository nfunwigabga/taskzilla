<template>
  <file-pond
    name="task-attachment"
    ref="pond"
    :label-idle="label"
    :accepted-file-types="accept"
    :server="server"
    :allow-multiple="true"
    :allow-image-validate-size="true"
    :image-validate-size-min-width="50"
    :image-validate-size-min-height="50"
    :files="files"
    :instant-upload="true"
    @addfile="handleAddFile"
    @processfile="handleProcessFile"
    :max-files="maxFileCount"
    :max-file-size="maxFileSize"
    credits="false"
  />
</template>

<script setup>

import vueFilePond from "vue-filepond";
import "filepond/dist/filepond.min.css";
import FilePondPluginFileValidateSize from "filepond-plugin-file-validate-size";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImageValidateSize from "filepond-plugin-image-validate-size";
import { attachmentTypes } from "@/Helpers/helpers";
import { ref } from "vue";

const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginFileValidateSize,
  FilePondPluginImageValidateSize
);

const props = defineProps({
  task: Object,
  endpoint: String,
  label: {
    type: String,
    default:
      "Drag & Drop your files or <span class='filepond--label-action'> Browse</span> <small>(max: 5 at a time)</small>"
  },
  maxFileCount: {
    type: Number,
    default: 5
  },
  maxFileSize: {
    type: String,
    default: "5MB"
  },
  accept: {
    type: String,
    default: attachmentTypes
  }

});

const emits = defineEmits(["upload-successful"]);

const files = ref([]);
const pond = ref(null);
const server = {
  process: handleUpload
};


function handleUpload(fieldName, file, metadata, load, error, progress, abort) {
  let formData = new FormData();
  formData.append("file", file);
  const cancelTokenSource = axios.CancelToken.source();
  axios.post(props.endpoint, formData, {
    headers: {
      "Content-Type": "multipart/form-data"
    },
    onUploadProgress: (e) => progress(e.lengthComputable, e.loaded, e.total),
    cancelToken: cancelTokenSource.token
  }).then((res) => {
    load(file);
    emits("upload-successful", res.data);
  }).catch((e) => {
    console.log(e);
    error("Server error");
  });
  return {
    abort: () => {
      cancelTokenSource.cancel();
      abort();
    }
  };
}

function handleAddFile(error, file) {
  if (error) return;
  file.setMetadata("fileInfo", {
    name: file.filenameWithoutExtension,
    extension: file.fileExtension,
    size: file.fileSize
  });
}

function handleProcessFile(error, file) {
  if (error) return;
  pond.value?.removeFile(file);
}


</script>

<style lang="scss">
.filepond--drop-label label {
  font-size: .875em !important;
}
</style>