<template>
  <div class="container-fluid">
    <div class="icon icon-grid i-grid">
      <div class="row">
        <div class="col-lg-2 col-md-3 col-sm-6" v-for="doc in getAllDocumentsItems" :key="doc.uuid">
          <!-- folder  -->
          <div v-if="doc.data.type === 'folder'" class="card" @dblclick="getDocDetailsAn(doc.data.uuid)">
            <div class="card-body">
              <!-- folderImg :: start -->
              <div class="d-flex justify-content-center">
                <div>
                  <b-img style="height: 150px" rounded fluid :src="require('@/assets/images/page-img/folder.png')" alt="folder"></b-img>
                </div>
              </div>
              <!-- folderImg :: start -->

              <!-- folderBody :: start -->
              <div class="d-flex justify-content-around">
                <!-- folderName :: start -->
                <div>
                  <b-input class="bg-white border-none" :value="doc.data.attributes.name" @change="updateFolderFn($event, doc)" />
                </div>
                <!-- folderName :: end -->

                <!-- folderCTA :: start -->
                <div class="card-header-toolbar">
                  <b-dropdown id="dropdownMenuButton05" top variant="none" data-toggle="dropdown">
                    <template v-slot:button-content>
                      <i class="ri-more-2-fill"></i>
                    </template>
                    <b-dropdown-item @click="restoreFolderByIdAn(doc.data.uuid)"><i class="ri-recycle-line mr-2"></i>Restore</b-dropdown-item>
                    <b-dropdown-item @click="deleteFolderByIdPermanentlyAn(doc.data.uuid)"><i class="ri-delete-bin-line mr-2"></i>Delete</b-dropdown-item>
                  </b-dropdown>
                </div>
                <!-- folderCTA :: end1 -->
              </div>
              <!-- folderBody :: start -->
            </div>
          </div>

          <!-- image -->
          <div v-if="doc.data.type === 'image'">
            <cardlist :image_name="doc.data.attributes.name" :thumbnail_url="doc.data.attributes.thumbnail.sm" v-if="doc.data.attributes.mimetype == 'jpg' || doc.data.attributes.mimetype == 'jpeg' || doc.data.attributes.mimetype == 'png'">
              <template v-slot:dropdown>
                <div class="card-header-toolbar">
                  <b-dropdown id="dropdownMenuButton05" right variant="none" data-toggle="dropdown">
                    <template v-slot:button-content>
                      <i class="ri-more-2-fill"></i>
                    </template>
                    <b-dropdown-item @click="restoreFileByIdAn(doc.data.uuid)"><i class="ri-eye-fill mr-2"></i>Restore</b-dropdown-item>
                    <b-dropdown-item @click="deleteFileByIdPermanently(doc.data.uuid)"><i class="ri-delete-bin-6-fill mr-2"></i>Delete</b-dropdown-item>
                  </b-dropdown>
                </div>
              </template>
            </cardlist>
          </div>

          <!-- files -->
          <div v-if="doc.data.type === 'file'">
            <!-- pdf :: start -->
            <div v-if="doc.data.attributes.mimetype == 'pdf'">
              <div class="card card-block card-stretch card-height">
                <div class="card-body image-thumb">
                  <div class="mb-4 text-center p-3 rounded iq-thumb">
                    <div class="iq-image-overlay"></div>
                    <!-- <a href="#" :data-url="`${baseUrl}/doc-viewer/files/demo.pdf`" data-title="Mobile-plan.pdf" @click="$root.$emit('bv::show::modal', 'viewer-modal', $event.target)" v-b-modal.viewer-modal>
                        <img src="@/assets/images/layouts/page-1/pdf.png" class="img-fluid" alt="image1" />
                      </a> -->
                    <a href="#" :data-url="doc.data.attributes.file_url" :data-title="doc.data.attributes.name" @click="$root.$emit('bv::show::modal', 'viewer-modal', $event.target)" v-b-modal.viewer-modal>
                      <img src="@/assets/images/layouts/page-1/pdf.png" class="img-fluid" alt="image1" />
                    </a>
                  </div>
                  <div class="d-flex justify-content-between align-items-center">
                    <h6>
                      {{ doc.data.attributes.name.length > 15 ? `${doc.data.attributes.name.substring(0, 15)}...` : doc.data.attributes.name }}
                    </h6>
                    <div class="card-header-toolbar">
                      <b-dropdown id="dropdownMenuButton05" right variant="none" data-toggle="dropdown">
                        <template v-slot:button-content>
                          <i class="ri-more-2-fill"></i>
                        </template>
                        <b-dropdown-item @click="restoreFileByIdAn(doc.data.uuid)"><i class="ri-eye-fill mr-2"></i>Restore</b-dropdown-item>
                        <b-dropdown-item @click="deleteFileByIdPermanently(doc.data.uuid)"><i class="ri-delete-bin-6-fill mr-2"></i>Delete</b-dropdown-item>
                      </b-dropdown>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- docx :: start -->
            <div v-if="doc.data.attributes.mimetype == 'doc' || doc.data.attributes.mimetype == 'docx'" class="card card-block card-stretch card-height">
              <div class="card-body image-thumb">
                <div class="mb-4 text-center p-3 rounded iq-thumb">
                  <div class="iq-image-overlay"></div>
                  <a href="#" :data-title="doc.data.attributes.name" :data-url="doc.data.attributes.file_url" @click="$root.$emit('bv::show::modal', 'viewer-modal', $event.target)" v-b-modal.viewer-modal>
                    <img src="@/assets/images/layouts/page-1/doc.png" class="img-fluid" alt="image1" />
                  </a>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                  <h6>
                    {{ doc.data.attributes.name.length > 15 ? `${doc.data.attributes.name.substring(0, 15)}...` : doc.data.attributes.name }}
                  </h6>
                  <div class="card-header-toolbar">
                    <b-dropdown id="dropdownMenuButton05" right variant="none" data-toggle="dropdown">
                      <template v-slot:button-content>
                        <i class="ri-more-2-fill"></i>
                      </template>
                      <b-dropdown-item @click="restoreFileByIdAn(doc.data.uuid)"><i class="ri-eye-fill mr-2"></i>Restore</b-dropdown-item>
                      <b-dropdown-item @click="deleteFileByIdPermanently(doc.data.uuid)"><i class="ri-delete-bin-6-fill mr-2"></i>Delete</b-dropdown-item>
                    </b-dropdown>
                  </div>
                </div>
              </div>
            </div>

            <!-- xlsx :: start -->
            <div v-if="doc.data.attributes.mimetype == 'xls' || doc.data.attributes.mimetype == 'xlsx'" class="card card-block card-stretch card-height">
              <div class="card-body image-thumb">
                <div class="mb-4 text-center p-3 rounded iq-thumb">
                  <div class="iq-image-overlay"></div>
                  <a href="#" :data-title="doc.data.attributes.name" :data-url="doc.data.attributes.file_url" @click="$root.$emit('bv::show::modal', 'viewer-modal', $event.target)" v-b-modal.viewer-modal><img src="@/assets/images/layouts/page-1/xlsx.png" class="img-fluid" alt="image1" /></a>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                  <h6>
                    {{ doc.data.attributes.name.length > 15 ? `${doc.data.attributes.name.substring(0, 15)}...` : doc.data.attributes.name }}
                  </h6>
                  <div class="card-header-toolbar">
                    <b-dropdown id="dropdownMenuButton05" right variant="none" data-toggle="dropdown">
                      <template v-slot:button-content>
                        <i class="ri-more-2-fill"></i>
                      </template>
                      <b-dropdown-item @click="restoreFileByIdAn(doc.data.uuid)"><i class="ri-eye-fill mr-2"></i>Restore</b-dropdown-item>
                      <b-dropdown-item @click="deleteFileByIdPermanently(doc.data.uuid)"><i class="ri-delete-bin-6-fill mr-2"></i>Delete</b-dropdown-item>
                    </b-dropdown>
                  </div>
                </div>
              </div>
            </div>

            <!-- pptx :: start -->
            <div v-if="doc.data.attributes.mimetype == 'ppt' || doc.data.attributes.mimetype == 'pptx'" class="card card-block card-stretch card-height">
              <div class="card-body image-thumb">
                <div class="mb-4 text-center p-3 rounded iq-thumb">
                  <div class="iq-image-overlay"></div>
                  <a href="#" :data-title="doc.data.attributes.name" :data-url="doc.data.attributes.file_url" @click="$root.$emit('bv::show::modal', 'viewer-modal', $event.target)" v-b-modal.viewer-modal><img src="@/assets/images/layouts/page-1/ppt.png" class="img-fluid" alt="image1" /></a>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                  <h6>
                    {{ doc.data.attributes.name.length > 15 ? `${doc.data.attributes.name.substring(0, 15)}...` : doc.data.attributes.name }}
                  </h6>
                  <div class="card-header-toolbar">
                    <b-dropdown id="dropdownMenuButton05" right variant="none" data-toggle="dropdown">
                      <template v-slot:button-content>
                        <i class="ri-more-2-fill"></i>
                      </template>
                      <b-dropdown-item @click="restoreFileByIdAn(doc.data.uuid)"><i class="ri-eye-fill mr-2"></i>Restore</b-dropdown-item>
                      <b-dropdown-item @click="deleteFileByIdPermanently(doc.data.uuid)"><i class="ri-delete-bin-6-fill mr-2"></i>Delete</b-dropdown-item>
                    </b-dropdown>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div v-if="getAllDocumentsItems.length === 0">
        <div class="d-flex justify-content-center align-items-center py-4 my-4">
          <h3 class="text-muted">No Trash Found</h3>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="js">
import { mapActions, mapGetters } from 'vuex';

export default {
    name:'Trash',
    data(){
        return{
            
        }
    },
    computed: {
      ...mapGetters('Browser', ['getAllDocumentsItems']),
    },
    methods:{
      ...mapActions('Browser', ['getDeletedDocsAn', 'restoreFolderByIdAn', 'restoreFileByIdAn',  'deleteFolderByIdPermanentlyAn', 'deleteFileByIdPermanently']),
  },
  created(){
    this.getDeletedDocsAn();
  }
}
</script>
