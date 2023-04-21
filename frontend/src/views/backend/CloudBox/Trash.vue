<template>
  <div class="container-fluid">
    <Loader v-model="getHbLoader" class="loader" />
    <div class="icon icon-grid i-grid" v-if="!getHbLoader">
      <div class="row">
        <!-- new :: start -->
        <div class="col-lg-2 col-md-3 col-sm-6" v-for="doc in getAllDocumentsItems" :key="doc.uuid">
          <!-- folder :: start  -->
          <div v-if="doc.data.type === 'folder'" class="card" @click="showSingleFolderDetailFn(doc.data.uuid)" @dblclick="getDocDetailsFn(doc.data.uuid)">
            <div class="card-body hub-mydrive-folder" style="cursor: pointer">
              <!-- folderImg :: start -->
              <div class="d-flex justify-content-between">
                <div class="image-holder">
                  <b-img class="folders" rounded fluid :src="require('@/assets/images/page-img/folderx80.svg')" alt="folder"></b-img>
                </div>
                <div class="hub-cta">
                  <!-- folderCTA :: start -->
                  <div class="card-header-toolbar">
                    <b-dropdown id="dropdownMenuButton05" top variant="none" data-toggle="dropdown">
                      <template v-slot:button-content>
                        <i class="ri-more-fill"></i>
                      </template>
                      <b-dropdown-item @click="restoreFolderByIdAn(doc.data.uuid)"><i class="ri-recycle-line mr-2"></i>Restore</b-dropdown-item>
                      <b-dropdown-item @click="deleteFolderByIdPermanentlyAn(doc.data.uuid)"><i class="ri-delete-bin-line mr-2"></i>Delete</b-dropdown-item>
                    </b-dropdown>
                  </div>
                  <!-- folderCTA :: end1 -->
                </div>
              </div>
              <!-- folderImg :: start -->

              <!-- folderBody :: start -->
              <div class="folder-meta">
                <!-- folderName :: start -->
                <div class="folder-name">
                  <b-input class="bg-white border-none" :value="doc.data.attributes.name" @change.prevent="updateFolderFn($event, doc)" />
                </div>
                <div class="f-meta-btm d-flex justify-content-between">
                  <span class="mr-1" v-if="doc.data.relationships.shared"
                    ><b><i class="ri-links-line" style="color: #8d93f2 !important"></i></b
                  ></span>
                  <span> {{ doc.data.attributes.items === 0 ? "Empty" : `${doc.data.attributes.items} Items` }}</span>
                  <span>{{ doc.data.attributes.created_at }}</span>
                </div>
                <!-- folderName :: end -->
              </div>
              <!-- folderBody :: start -->
            </div>
          </div>
          <!-- folder :: end  -->

          <!-- image :: start -->
          <div v-if="doc.data.type === 'image'" @click="showSingleFileDetailFn(doc.data.uuid)" style="cursor: pointer">
            <cardlist :shared="doc.data.relationships.shared" :image_name="doc.data.attributes.name" :thumbnail_url="doc.data.attributes.thumbnail.sm" v-if="doc.data.attributes.mimetype == 'jpg' || doc.data.attributes.mimetype == 'jpeg' || doc.data.attributes.mimetype == 'png'">
              <template v-slot:dropdown>
                <div class="card-header-toolbar">
                  <b-dropdown id="dropdownMenuButton05" right variant="none" data-toggle="dropdown">
                    <template v-slot:button-content>
                      <i class="ri-more-fill"></i>
                    </template>
                    <b-dropdown-item @click="restoreFileByIdAn(doc.data.uuid)"><i class="ri-eye-fill mr-2"></i>Restore</b-dropdown-item>
                    <b-dropdown-item @click="deleteFileByIdPermanently(doc.data.uuid)"><i class="ri-delete-bin-6-fill mr-2"></i>Delete</b-dropdown-item>
                  </b-dropdown>
                </div>
              </template>
            </cardlist>
          </div>
          <!-- image :: end -->

          <!-- svg :: start -->
          <div v-if="doc.data.type === 'image' && doc.data.attributes.mimetype == 'svg'" @click="showSingleFileDetailFn(doc.data.uuid)" style="cursor: pointer">
            <div class="card card-block card-stretch card-height my-drive-files my-files-pdf">
              <div class="card-body image-thumb">
                <div class="mb-4 text-center p-3 rounded iq-thumb">
                  <div class="iq-image-overlay"></div>
                  <a href="#" :data-url="doc.data.attributes.file_url" :data-title="doc.data.attributes.name" @click="$root.$emit('bv::show::modal', 'viewer-modal', $event.target)" v-b-modal.viewer-modal>
                    <b-img class="file-pdf" rounded fluid :src="require('@/assets/images/page-img/svgx80.svg')" alt="pdf"></b-img>
                  </a>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                  <h6>
                    <span class="mr-1" v-if="doc.data.relationships.shared"
                      ><b><i class="ri-links-line" style="color: #8d93f2 !important"></i></b
                    ></span>
                    {{ doc.data.attributes.name.length > 15 ? `${doc.data.attributes.name.substring(0, 15)}...` : doc.data.attributes.name }}
                  </h6>
                  <div class="card-header-toolbar">
                    <b-dropdown id="dropdownMenuButton05" right variant="none" data-toggle="dropdown">
                      <template v-slot:button-content>
                        <i class="ri-more-fill"></i>
                      </template>
                      <b-dropdown-item @click="restoreFileByIdAn(doc.data.uuid)"><i class="ri-eye-fill mr-2"></i>Restore</b-dropdown-item>
                      <b-dropdown-item @click="deleteFileByIdPermanently(doc.data.uuid)"><i class="ri-delete-bin-6-fill mr-2"></i>Delete</b-dropdown-item>
                    </b-dropdown>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- svg :: end -->

          <!-- pdf :: start -->
          <div @click="showSingleFileDetailFn(doc.data.uuid)" v-if="doc.data.type === 'file' && doc.data.attributes.mimetype == 'pdf'" style="cursor: pointer">
            <div class="card card-block card-stretch card-height my-drive-files my-files-pdf">
              <div class="card-body image-thumb">
                <div class="mb-4 text-center p-3 rounded iq-thumb">
                  <div class="iq-image-overlay"></div>
                  <a href="#" :data-url="doc.data.attributes.file_url" :data-title="doc.data.attributes.name" @click="$root.$emit('bv::show::modal', 'viewer-modal', $event.target)" v-b-modal.viewer-modal>
                    <b-img class="file-pdf" rounded fluid :src="require('@/assets/images/page-img/pdfx80.svg')" alt="pdf"></b-img>
                  </a>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                  <h6>
                    <span class="mr-1" v-if="doc.data.relationships.shared"
                      ><b><i class="ri-links-line" style="color: #8d93f2 !important"></i></b
                    ></span>
                    {{ doc.data.attributes.name.length > 15 ? `${doc.data.attributes.name.substring(0, 15)}...` : doc.data.attributes.name }}
                  </h6>
                  <div class="card-header-toolbar">
                    <b-dropdown id="dropdownMenuButton05" right variant="none" data-toggle="dropdown">
                      <template v-slot:button-content>
                        <i class="ri-more-fill"></i>
                      </template>
                      <b-dropdown-item @click="restoreFileByIdAn(doc.data.uuid)"><i class="ri-eye-fill mr-2"></i>Restore</b-dropdown-item>
                      <b-dropdown-item @click="deleteFileByIdPermanently(doc.data.uuid)"><i class="ri-delete-bin-6-fill mr-2"></i>Delete</b-dropdown-item>
                    </b-dropdown>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- pdf :: end -->

          <!-- docx :: start -->
          <div @click="showSingleFileDetailFn(doc.data.uuid)" v-if="(doc.data.type === 'file' && doc.data.attributes.mimetype == 'doc') || doc.data.attributes.mimetype == 'docx'" class="card card-block card-stretch card-height my-drive-files my-files-doc" style="cursor: pointer">
            <div class="card-body image-thumb">
              <div class="mb-4 text-center p-3 rounded iq-thumb">
                <div class="iq-image-overlay"></div>
                <a href="#" :data-title="doc.data.attributes.name" :data-url="doc.data.attributes.file_url" @click="$root.$emit('bv::show::modal', 'viewer-modal', $event.target)" v-b-modal.viewer-modal>
                  <b-img class="file-doc" rounded fluid :src="require('@/assets/images/page-img/docsx80.svg')" alt="doc"></b-img>
                </a>
              </div>

              <div class="d-flex justify-content-between align-items-center">
                <h6>
                  <span class="mr-1" v-if="doc.data.relationships.shared"
                    ><b><i class="ri-links-line" style="color: #8d93f2 !important"></i></b
                  ></span>
                  {{ doc.data.attributes.name.length > 15 ? `${doc.data.attributes.name.substring(0, 15)}...` : doc.data.attributes.name }}
                </h6>
                <div class="card-header-toolbar">
                  <b-dropdown id="dropdownMenuButton05" right variant="none" data-toggle="dropdown">
                    <template v-slot:button-content>
                      <i class="ri-more-fill"></i>
                    </template>
                    <b-dropdown-item @click="restoreFileByIdAn(doc.data.uuid)"><i class="ri-eye-fill mr-2"></i>Restore</b-dropdown-item>
                    <b-dropdown-item @click="deleteFileByIdPermanently(doc.data.uuid)"><i class="ri-delete-bin-6-fill mr-2"></i>Delete</b-dropdown-item>
                  </b-dropdown>
                </div>
              </div>
            </div>
          </div>
          <!-- docx :: end -->

          <!-- xlsx :: start -->
          <div @click="showSingleFileDetailFn(doc.data.uuid)" v-if="(doc.data.type === 'file' && doc.data.attributes.mimetype == 'xls') || doc.data.attributes.mimetype == 'xlsx'" class="card card-block card-stretch card-height my-drive-files my-files-sheet" style="cursor: pointer">
            <div class="card-body image-thumb">
              <div class="mb-4 text-center p-3 rounded iq-thumb">
                <div class="iq-image-overlay"></div>
                <a href="#" :data-title="doc.data.attributes.name" :data-url="doc.data.attributes.file_url" @click="$root.$emit('bv::show::modal', 'viewer-modal', $event.target)" v-b-modal.viewer-modal>
                  <b-img class="file-sheets" rounded fluid :src="require('@/assets/images/page-img/sheetsx80.svg')" alt="sheets"></b-img>
                </a>
              </div>
              <div class="d-flex justify-content-between align-items-center">
                <h6>
                  <span class="mr-1" v-if="doc.data.relationships.shared"
                    ><b><i class="ri-links-line" style="color: #8d93f2 !important"></i></b
                  ></span>
                  {{ doc.data.attributes.name.length > 15 ? `${doc.data.attributes.name.substring(0, 15)}...` : doc.data.attributes.name }}
                </h6>
                <div class="card-header-toolbar">
                  <b-dropdown id="dropdownMenuButton05" right variant="none" data-toggle="dropdown">
                    <template v-slot:button-content>
                      <i class="ri-more-fill"></i>
                    </template>
                    <b-dropdown-item @click="restoreFileByIdAn(doc.data.uuid)"><i class="ri-eye-fill mr-2"></i>Restore</b-dropdown-item>
                    <b-dropdown-item @click="deleteFileByIdPermanently(doc.data.uuid)"><i class="ri-delete-bin-6-fill mr-2"></i>Delete</b-dropdown-item>
                  </b-dropdown>
                </div>
              </div>
            </div>
          </div>
          <!-- xlsx :: end -->

          <!-- pptx :: start -->
          <div @click="showSingleFileDetailFn(doc.data.uuid)" v-if="(doc.data.type === 'file' && doc.data.attributes.mimetype == 'ppt') || doc.data.attributes.mimetype == 'pptx'" class="card card-block card-stretch card-height my-drive-files my-files-slides" style="cursor: pointer">
            <div class="card-body image-thumb">
              <div class="mb-4 text-center p-3 rounded iq-thumb">
                <div class="iq-image-overlay"></div>
                <a href="#" :data-title="doc.data.attributes.name" :data-url="doc.data.attributes.file_url" @click="$root.$emit('bv::show::modal', 'viewer-modal', $event.target)" v-b-modal.viewer-modal>
                  <b-img class="file-slides" rounded fluid :src="require('@/assets/images/page-img/slidesx80.svg')" alt="slides"></b-img>
                </a>
              </div>
              <div class="d-flex justify-content-between align-items-center">
                <h6>
                  <span class="mr-1" v-if="doc.data.relationships.shared"
                    ><b><i class="ri-links-line" style="color: #8d93f2 !important"></i></b
                  ></span>
                  {{ doc.data.attributes.name.length > 15 ? `${doc.data.attributes.name.substring(0, 15)}...` : doc.data.attributes.name }}
                </h6>
                <div class="card-header-toolbar">
                  <b-dropdown id="dropdownMenuButton05" right variant="none" data-toggle="dropdown">
                    <template v-slot:button-content>
                      <i class="ri-more-fill"></i>
                    </template>
                    <b-dropdown-item @click="restoreFileByIdAn(doc.data.uuid)"><i class="ri-eye-fill mr-2"></i>Restore</b-dropdown-item>
                    <b-dropdown-item @click="deleteFileByIdPermanently(doc.data.uuid)"><i class="ri-delete-bin-6-fill mr-2"></i>Delete</b-dropdown-item>
                  </b-dropdown>
                </div>
              </div>
            </div>
          </div>
          <!-- pptx :: end -->

          <!-- mp4 :: start -->
          <div @click="showSingleFileDetailFn(doc.data.uuid)" v-if="doc.data.type === 'video' && doc.data.attributes.mimetype == 'mp4'" class="card card-block card-stretch card-height my-drive-files my-files-slides" style="cursor: pointer">
            <div class="card-body image-thumb">
              <div class="mb-4 text-center p-3 rounded iq-thumb">
                <div class="iq-image-overlay"></div>
                <a href="#" :data-title="doc.data.attributes.name" :data-url="doc.data.attributes.file_url" @click="$root.$emit('bv::show::modal', 'viewer-modal', $event.target)" v-b-modal.viewer-modal>
                  <b-img class="file-slides" rounded fluid :src="require('@/assets/images/page-img/videox80.svg')" alt="slides"></b-img>
                </a>
              </div>
              <div class="d-flex justify-content-between align-items-center">
                <h6>
                  <span class="mr-1" v-if="doc.data.relationships.shared"
                    ><b><i class="ri-links-line" style="color: #8d93f2 !important"></i></b
                  ></span>
                  {{ doc.data.attributes.name.length > 15 ? `${doc.data.attributes.name.substring(0, 15)}...` : doc.data.attributes.name }}
                </h6>
                <div class="card-header-toolbar">
                  <b-dropdown id="dropdownMenuButton05" right variant="none" data-toggle="dropdown">
                    <template v-slot:button-content>
                      <i class="ri-more-fill"></i>
                    </template>
                    <b-dropdown-item @click="restoreFileByIdAn(doc.data.uuid)"><i class="ri-eye-fill mr-2"></i>Restore</b-dropdown-item>
                    <b-dropdown-item @click="deleteFileByIdPermanently(doc.data.uuid)"><i class="ri-delete-bin-6-fill mr-2"></i>Delete</b-dropdown-item>
                  </b-dropdown>
                </div>
              </div>
            </div>
          </div>
          <!-- mp4 :: end -->
        </div>
        <!-- new :: end -->
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
import Loader from '@/components/loader/HbLoader.vue';

export default {
    name:'Trash',
    components: {
      Loader
    },
    computed: {
      ...mapGetters('Browser', ['getHbLoader','getAllDocumentsItems']),
    },
    methods:{
      ...mapActions('Browser', ['getDeletedDocsAn', 'restoreFolderByIdAn', 'restoreFileByIdAn',  'deleteFolderByIdPermanentlyAn', 'deleteFileByIdPermanently']),
  },
  created(){
    this.getDeletedDocsAn();
  }
}
</script>
