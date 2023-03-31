<template>
  <div class="container-fluid">
    <!-- fileUploadSection :: start -->
    <b-col lg="6" offset-lg="3">
      <card class="card-upload">
        <template v-slot:headerTitle>
          <h4 class="card-title">Upload</h4>
        </template>
        <template v-slot:body>
          <div class="hub-upload-wrap">
            <b-form-group class="hub-upload-fg">
              <div class="upload-dialg">
                 <span class="icon-up">
                  <svg height="130" viewBox="0 0 184.69 184.69" width="130" xmlns="http://www.w3.org/2000/svg"><g fill="#FE5C36"><path d="m149.968 50.186c-8.017-14.308-23.796-22.515-40.717-19.813-6.642-13.943-20.538-22.797-36.164-22.797-22.117 0-40.112 17.994-40.112 40.115 0 .913.036 1.854.118 2.834-19.089 4.35-33.093 21.585-33.093 41.434 0 23.456 19.082 42.535 42.538 42.535h33.623v-7.025h-33.623c-19.583 0-35.509-15.929-35.509-35.509 0-17.526 13.084-32.621 30.442-35.105.931-.132 1.768-.633 2.326-1.392.555-.755.795-1.704.644-2.63-.297-1.904-.447-3.582-.447-5.139 0-18.249 14.852-33.094 33.094-33.094 13.703 0 25.789 8.26 30.803 21.04.63 1.621 2.351 2.534 4.058 2.14 15.425-3.568 29.919 3.883 36.604 17.168.508 1.027 1.503 1.736 2.641 1.897 17.368 2.473 30.481 17.569 30.481 35.112 0 19.58-15.937 35.509-35.52 35.509h-44.764v7.025h44.761c23.459 0 42.538-19.079 42.538-42.535 0-20.411-14.806-38.055-34.722-41.77z"/><path d="m108.586 90.201c1.406-1.403 1.406-3.672 0-5.075l-20.045-20.048c-.701-.698-1.614-1.045-2.534-1.045l-.064.011c-.018 0-.036-.011-.054-.011-.931 0-1.85.361-2.534 1.045l-20.045 20.049c-1.403 1.403-1.403 3.672 0 5.075 1.403 1.406 3.672 1.406 5.075 0l13.911-13.912v97.227c0 1.99 1.603 3.597 3.593 3.597 1.979 0 3.59-1.607 3.59-3.597v-97.352l14.033 14.036c1.398 1.407 3.671 1.407 5.074 0z"/></g></svg>
                  </span>
                  <span class="text">Drag &amp; drop files or <span class="link">Browse</span></span>
              </div>
              <b-form-file v-model="selectedFiles" placeholder="Supported formates: JPEG, PNG, GIF, PDF, DOC, XLS AND MORE" drop-placeholder="Drop files here" @input-file="onFileSelected" multiple></b-form-file>
            </b-form-group>
          </div>
          <div class="uploading-files"  v-if="selectedFiles && selectedFiles.length > 0">
            <h5>Files</h5>
            <ul>
              <li v-for="(file, index) in selectedFiles" :key="index">
                <span class="fi-inner">
                  <span class="fi-name">{{ file.name }}</span>
                  <span class="fi-remove"><i @click="cancelFile(index)" class="ri-delete-bin-6-line"></i></span>
                </span>
              </li>
            </ul>
          </div>
          <div class="btn-wrap">
          <button class="btn btn-primary" @click.prevent="onUpload">{{ isFileUploading ? `Please wait ..` : "Upload" }}</button>
          </div>
        </template>
   
        
      </card>
    </b-col>
    <!-- fileUploadSection :: end -->
  </div>
</template>

<script lang="js">
import axios from 'axios';

export default {
  name: 'Files',
  data() {
    return {
      selectedFiles: [],
      isFileUploading: false,
      // uploadPercentage: 0
    }
  },
  methods: {
    onFileSelected(files) {
    this.selectedFiles = files
    },
    cancelFile(index) {
      this.selectedFiles.splice(index, 1)
    },
    async onUpload() {
      console.log('this.selectedFiles', this.selectedFiles);

      if(this.selectedFiles.length === 0) return;

      this.isFileUploading = true;

      const fd = new FormData()
      for (let i = 0; i < this.selectedFiles.length; i++){
        fd.append('files[' + i + ']', this.selectedFiles[i]);
      }
      fd.append('uuid', 'uuid')
      await axios.post('/upload/file', fd, {
          headers: {
            'Content-Type': 'multipart/form-data'
          },
          onUploadProgress: function (progressEvent) {
            console.log(parseInt( Math.round( ( progressEvent.loaded / progressEvent.total ) * 100 ) ))
            // this.uploadPercentage = parseInt( Math.round( ( progressEvent.loaded / progressEvent.total ) * 100 ) );
          }.bind(this)
        }).then((res) => {
          if(res.status === 200){
            this.isFileUploading = false;
            this.selectedFiles = [];
            this.$router.push({name: 'drive.filebrowser'});
          }
        }).catch(e => console.log(e));
    },
  }
}
</script>
