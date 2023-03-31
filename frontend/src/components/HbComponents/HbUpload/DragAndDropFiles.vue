<template>
  <div
    class="file-upload"
    @dragover.prevent
    @dragenter.prevent
    @dragleave.prevent
    @drop="handleDrop"
  >
    <input
      type="file"
      ref="fileInput"
      style="display: none"
      @change="handleFileSelect"
      multiple
    />
    <div class="file-upload__content" v-if="!files.length">
      <p>Drop your files here or click to select files.</p>
      <button class="btn" @click="handleFileInputClick">Select files</button>
    </div>
    <div class="file-upload__preview" v-else>
      <div
        class="file-upload__preview__item"
        v-for="(previewUrl, index) in previewUrls"
        :key="index"
      >
        <img :src="previewUrl" />
        <button class="btn btn--clear" @click="clearFile(index)">Clear</button>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "DragAndDropFiles",
  data() {
    return {
      files: [],
      previewUrls: [],
    };
  },
  methods: {
    handleFileSelect(event) {
      for (let i = 0; i < event.target.files.length; i++) {
        const file = event.target.files[i];
        this.previewUrls.push(URL.createObjectURL(file));
        this.files.push(file);
      }
    },
    handleFileInputClick() {
      this.$refs.fileInput.click();
    },
    clearFile(index) {
      this.files.splice(index, 1);
      this.previewUrls.splice(index, 1);
    },
    handleDrop(event) {
      event.preventDefault();
      for (let i = 0; i < event.dataTransfer.files.length; i++) {
        const file = event.dataTransfer.files[i];
        this.previewUrls.push(URL.createObjectURL(file));
        this.files.push(file);
      }
    },
  },
};
</script>

<style scoped>
.file-upload {
  border: 2px dashed #ccc;
  padding: 2rem;
  text-align: center;
}

.file-upload__preview__item {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-bottom: 1rem;
}

.btn {
  display: inline-block;
  background-color: #007bff;
  color: #fff;
  padding: 0.5rem 1rem;
  border-radius: 0.25rem;
  text-decoration: none;
  cursor: pointer;
}

.btn--clear {
  background-color: #dc3545;
  margin-top: 0.5rem;
}
</style>

