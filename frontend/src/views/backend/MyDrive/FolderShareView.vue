<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12" v-if="getShareDataDetails.data.items[0].data.attributes.protected">
        <div class="d-flex justify-content-center align-items-center" style="height: 100vh">
          <div class="bg-white p-5" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)">
            <form @submit.prevent="getDataWithPassword">
              <div class="form-group">
                <label for="password">Enter password</label>
                <input v-model="password" type="text" class="form-control form-control-lg" id="password" autofocus />
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-12" v-if="!getShareDataDetails.data.items[0].data.attributes.protected">
        <!-- Container :: start -->
          <div class="icon icon-grid i-grid" style="min-height: 100vh">
            <div class="row" style="padding-top: 50px;">
              <div class="col-lg-3 col-md-2 col-sm-6" v-for="doc in getShareDataDetails.data.items" :key="doc.uuid">
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
                            <b-dropdown-item><i class="ri-star-line mr-2"></i>Favourites</b-dropdown-item>
                            <b-dropdown-item><i class="ri-drag-move-2-line mr-2"></i>Move</b-dropdown-item>
                            <b-dropdown-item><i class="ri-user-add-fill mr-2"></i>Convert as Team Folder</b-dropdown-item>
                            <!-- <b-dropdown-item><i class="ri-upload-cloud-2-line mr-2"></i>File Request</b-dropdown-item> -->
                            <!-- <b-dropdown-item><i class="ri-information-line mr-2"></i>Details</b-dropdown-item> -->
                            <b-dropdown-item @click="downloadFolderByIdAn(doc.data.uuid)"><i class="ri-folder-download-line mr-2"></i>Download</b-dropdown-item>
                            <b-dropdown-item @click="deleteFolderByIdToTrashAn(doc.data.uuid)"><i class="ri-recycle-line mr-2"></i>Trash</b-dropdown-item>
                            <b-dropdown-item @click="deleteFolderByIdPermanentlyAn(doc.data.uuid)"><i class="ri-delete-bin-line mr-2"></i>Delete</b-dropdown-item>
                            <b-dropdown-item id="toggle-btn" @click="shareFolderByIdFn(doc.data.uuid)"><i class="ri-share-line mr-2"></i>{{ doc.data.relationships.shared ? "Edit Share" : "Share" }}</b-dropdown-item>
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
                        <b-input class="bg-white border-none" :value="doc.data.attributes.name" @change="updateFolderFn($event, doc)" />
                        </div>
                        <div class="f-meta-btm d-flex justify-content-between">
                          <!-- <span class="mr-1" v-if="doc.data.relationships.shared"
                            ><b><i class="ri-links-line" style="color: #8d93f2 !important"></i></b
                          ></span> -->
                          <span> {{ doc.data.attributes.items === 0 ? 'Empty' : `${doc.data.attributes.items} Items` }}</span>
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
                  <cardlist :image_name="doc.data.attributes.name" :thumbnail_url="doc.data.attributes.thumbnail.sm" v-if="doc.data.attributes.mimetype == 'jpg' || doc.data.attributes.mimetype == 'jpeg' || doc.data.attributes.mimetype == 'png'">
                    <template v-slot:dropdown>
                      <div class="card-header-toolbar">
                        <b-dropdown id="dropdownMenuButton05" right variant="none" data-toggle="dropdown">
                          <template v-slot:button-content>
                            <i class="ri-more-fill"></i>
                          </template>
                          <b-dropdown-item @click="downloadFileById({ 'base_name': doc.data.attributes.basename, 'file_name': doc.data.attributes.name})"><i class="ri-download-2-fill mr-2"></i>Download</b-dropdown-item>
                          <b-dropdown-item @click="deleteFileByIdToTrash(doc.data.uuid)"><i class="ri-eye-fill mr-2"></i>Move To Trash</b-dropdown-item>
                          <b-dropdown-item @click="deleteFileByIdPermanently(doc.data.uuid)"><i class="ri-delete-bin-6-fill mr-2"></i>Delete Permanently</b-dropdown-item>
                        </b-dropdown>
                      </div>
                    </template>
                  </cardlist>
                </div>
                <!-- image :: start -->

                <!-- files :: start -->
                <div v-if="doc.data.type === 'file'">
                  <!-- pdf :: start -->
                  <div @click="showSingleFileDetailFn(doc.data.uuid)" v-if="doc.data.attributes.mimetype == 'pdf'" style="cursor: pointer">
                    <div class="card card-block card-stretch card-height my-drive-files my-files-pdf">
                      <div class="card-body image-thumb">
                        <div class="mb-4 text-center p-3 rounded iq-thumb">
                          <div class="iq-image-overlay"></div>
                          <!-- <a href="#" :data-url="`${baseUrl}/doc-viewer/files/demo.pdf`" data-title="Mobile-plan.pdf" @click="$root.$emit('bv::show::modal', 'viewer-modal', $event.target)" v-b-modal.viewer-modal>
                            <img src="@/assets/images/layouts/page-1/pdf.png" class="img-fluid" alt="image1" />
                          </a> -->
                          <a href="#" :data-url="doc.data.attributes.file_url" :data-title="doc.data.attributes.name" @click="$root.$emit('bv::show::modal', 'viewer-modal', $event.target)" v-b-modal.viewer-modal>
            
                            <b-img class="file-pdf" rounded fluid :src="require('@/assets/images/page-img/pdfx80.svg')" alt="pdf"></b-img>
                          </a>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                          <h6>
                            {{ doc.data.attributes.name.length > 15 ? `${doc.data.attributes.name.substring(0, 15)}...` : doc.data.attributes.name }}
                          </h6>
                          <div class="card-header-toolbar">
                            <b-dropdown id="dropdownMenuButton05" right variant="none" data-toggle="dropdown">
                              <template v-slot:button-content>
                                <i class="ri-more-fill"></i>
                              </template>
                              <b-dropdown-item @click="downloadFileById({ 'base_name': doc.data.attributes.basename, 'file_name': doc.data.attributes.name})"><i class="ri-download-2-fill mr-2"></i>Download</b-dropdown-item>
                              <b-dropdown-item @click="deleteFileByIdToTrash(doc.data.uuid)"><i class="ri-eye-fill mr-2"></i>Move To Trash</b-dropdown-item>
                              <b-dropdown-item @click="deleteFileByIdPermanently(doc.data.uuid)"><i class="ri-delete-bin-6-fill mr-2"></i>Delete Permanently</b-dropdown-item>
                            </b-dropdown>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- docx :: start -->
                  <div @click="showSingleFileDetailFn(doc.data.uuid)" v-if="doc.data.attributes.mimetype == 'doc' || doc.data.attributes.mimetype == 'docx'" class="card card-block card-stretch card-height my-drive-files my-files-doc" style="cursor: pointer">
                    <div class="card-body image-thumb">
                      <div class="mb-4 text-center p-3 rounded iq-thumb">
                        <div class="iq-image-overlay"></div>
                        <a href="#" :data-title="doc.data.attributes.name" :data-url="doc.data.attributes.file_url" @click="$root.$emit('bv::show::modal', 'viewer-modal', $event.target)" v-b-modal.viewer-modal>
        
                          <b-img class="file-doc" rounded fluid :src="require('@/assets/images/page-img/docsx80.svg')" alt="doc"></b-img>
                        </a>
                      </div>

                      <div class="d-flex justify-content-between align-items-center">
                        <h6>
                          {{ doc.data.attributes.name.length > 15 ? `${doc.data.attributes.name.substring(0, 15)}...` : doc.data.attributes.name }}
                        </h6>
                        <div class="card-header-toolbar">
                          <b-dropdown id="dropdownMenuButton05" right variant="none" data-toggle="dropdown">
                            <template v-slot:button-content>
                              <i class="ri-more-fill"></i>
                            </template>
                            <b-dropdown-item @click="downloadFileById({ 'base_name': doc.data.attributes.basename, 'file_name': doc.data.attributes.name})"><i class="ri-download-2-fill mr-2"></i>Download</b-dropdown-item>
                            <b-dropdown-item @click="deleteFileByIdToTrash(doc.data.uuid)"><i class="ri-eye-fill mr-2"></i>Move To Trash</b-dropdown-item>
                            <b-dropdown-item @click="deleteFileByIdPermanently(doc.data.uuid)"><i class="ri-delete-bin-6-fill mr-2"></i>Delete Permanently</b-dropdown-item>
                          </b-dropdown>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- xlsx :: start -->
                  <div @click="showSingleFileDetailFn(doc.data.uuid)" v-if="doc.data.attributes.mimetype == 'xls' || doc.data.attributes.mimetype == 'xlsx'" class="card card-block card-stretch card-height my-drive-files my-files-sheet" style="cursor: pointer">
                    <div class="card-body image-thumb">
                      <div class="mb-4 text-center p-3 rounded iq-thumb">
                        <div class="iq-image-overlay"></div>
                        <a href="#" :data-title="doc.data.attributes.name" :data-url="doc.data.attributes.file_url" @click="$root.$emit('bv::show::modal', 'viewer-modal', $event.target)" v-b-modal.viewer-modal>

                          <b-img class="file-sheets" rounded fluid :src="require('@/assets/images/page-img/sheetsx80.svg')" alt="sheets"></b-img>
                          </a>
                      </div>
                      <div class="d-flex justify-content-between align-items-center">
                        <h6>
                          {{ doc.data.attributes.name.length > 15 ? `${doc.data.attributes.name.substring(0, 15)}...` : doc.data.attributes.name }}
                        </h6>
                        <div class="card-header-toolbar">
                          <b-dropdown id="dropdownMenuButton05" right variant="none" data-toggle="dropdown">
                            <template v-slot:button-content>
                              <i class="ri-more-fill"></i>
                            </template>
                            <b-dropdown-item @click="downloadFileById({ 'base_name': doc.data.attributes.basename, 'file_name': doc.data.attributes.name})"><i class="ri-download-2-fill mr-2"></i>Download</b-dropdown-item>
                            <b-dropdown-item @click="deleteFileByIdToTrash(doc.data.uuid)"><i class="ri-eye-fill mr-2"></i>Move To Trash</b-dropdown-item>
                            <b-dropdown-item @click="deleteFileByIdPermanently(doc.data.uuid)"><i class="ri-delete-bin-6-fill mr-2"></i>Delete Permanently</b-dropdown-item>
                          </b-dropdown>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- pptx :: start -->
                  <div @click="showSingleFileDetailFn(doc.data.uuid)" v-if="doc.data.attributes.mimetype == 'ppt' || doc.data.attributes.mimetype == 'pptx'" class="card card-block card-stretch card-height my-drive-files my-files-slides" style="cursor: pointer">
                    <div class="card-body image-thumb">
                      <div class="mb-4 text-center p-3 rounded iq-thumb">
                        <div class="iq-image-overlay"></div>
                        <a href="#" :data-title="doc.data.attributes.name" :data-url="doc.data.attributes.file_url" @click="$root.$emit('bv::show::modal', 'viewer-modal', $event.target)" v-b-modal.viewer-modal>
                          <b-img class="file-slides" rounded fluid :src="require('@/assets/images/page-img/slidesx80.svg')" alt="slides"></b-img>
                          </a>
                      </div>
                      <div class="d-flex justify-content-between align-items-center">
                        <h6>
                          {{ doc.data.attributes.name.length > 15 ? `${doc.data.attributes.name.substring(0, 15)}...` : doc.data.attributes.name }}
                        </h6>
                        <div class="card-header-toolbar">
                          <b-dropdown id="dropdownMenuButton05" right variant="none" data-toggle="dropdown">
                            <template v-slot:button-content>
                              <i class="ri-more-fill"></i>
                            </template>
                            <b-dropdown-item @click="downloadFileById({ 'base_name': doc.data.attributes.basename, 'file_name': doc.data.attributes.name})"><i class="ri-download-2-fill mr-2"></i>Download</b-dropdown-item>
                            <b-dropdown-item @click="deleteFileByIdToTrash(doc.data.uuid)"><i class="ri-eye-fill mr-2"></i>Move To Trash</b-dropdown-item>
                            <b-dropdown-item @click="deleteFileByIdPermanently(doc.data.uuid)"><i class="ri-delete-bin-6-fill mr-2"></i>Delete Permanently</b-dropdown-item>
                          </b-dropdown>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- files :: end -->
              </div>
            </div>
          </div>
        <!-- Container :: end -->
      </div>
    </div>
  </div>
</template>
<script lang="js">
import Vue from 'vue';
import axios from 'axios';
import { mapGetters, mapActions } from 'vuex';

export default {
  name: 'FolderShareView',
  data() {
    return {
      password: '',
      token: this.$route.params.token
    }
  },
  computed: {
    ...mapGetters('Share', ['getShareDataDetails']),
  },
  methods: {
    ...mapActions('Share', ['fetchShareDetailsAn','fetchShareDetailsWithPassword', 'fetchShareDetailsWithoutPassword']),

    getDataWithPassword(){
      axios.post(`/sharing/authenticate/${this.token}`, {password: this.password}).then((res)=>{
        if(res.status === 204){
          console.log('Authenticated and proceeding next');
          Vue.$cookies.set('share_session', { "token": `${this.token}`, "authenticated": true, "expire": "" });
          this.fetchShareDetailsWithPassword(this.token);
        }
      }).catch(e => console.log('e', e))
    },

  },
  created() {
    this.fetchShareDetailsAn(this.token)
      .then(res => {
        console.log('res', res.data);
        this.protected = res.data.data.items[0].data.attributes.protected;
          if (!this.protected) {
            this.fetchShareDetailsWithoutPassword(this.token)
          }
        } 
      )
      .catch(e => console.log('e', e));
  }
}
</script>
