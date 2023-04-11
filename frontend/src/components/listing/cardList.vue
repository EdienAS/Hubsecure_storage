<template>
  <card class="card-block card-stretch card-height" bodyClass="image-thumb">
    <template v-slot:body>
      <div class="mb-4 text-center p-3 rounded iq-thumb" v-if="!thumbnail_url">
        <a class="image-popup-vertical-fit" :href="thumbnail_url">
          <img :src="thumbnail_url" class="img-fluid" alt="No Thumbnail" />
          <div class="iq-image-overlay"></div>
        </a>
      </div>
      <div class="mb-4 text-center p-3 rounded iq-thumb" v-else>
        <a class="image-popup-vertical-fit">
          <img src="https://vectorified.com/images/image-placeholder-icon-15.png" class="img-fluid" alt="No Thumbnail" />
          <div class="iq-image-overlay"></div>
        </a>
      </div>
      <div class="d-flex justify-content-between">
        <span class="mr-1" v-if="shared"
          ><b><i class="ri-links-line" style="color: #8d93f2 !important"></i></b
        ></span>
        <h6>{{ image_name.length > 15 ? `${image_name.substring(0, 15)}...` : image_name }}</h6>
        <slot name="dropdown" />
      </div>
    </template>
  </card>
</template>
<script lang="js">
import { core } from '@/config/pluginInit'
export default {
  name:'cardList',
  mounted(){
    core.verticalImagePopup()
  },
  props:{
    data:{
      type:Object,
    },
    thumbnail_url: {
      type: String,
    },
    image_name: {
      type: String,
    },
    shared: {
      type: Object
    }
  }
}
</script>
