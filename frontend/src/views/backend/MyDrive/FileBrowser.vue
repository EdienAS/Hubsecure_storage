<template>
  <div class="container-fluid">
    <Loader v-model="getHbLoader" class="loader" />
    <!-- BreadCrumb :: start -->
    <div class="row" v-if="!getHbLoader">
      <div class="col-lg-12">
        <div class="d-flex align-items-center justify-content-between welcome-content mb-3">
          <div class="navbar-breadcrumb">
            <nav aria-label="breadcrumb">
              <ul class="breadcrumb">
                <li disabled style="cursor: not-allowed" class="breadcrumb-item active"><i class="ri-home-2-fill mr-2 pt-1"></i> Home</li>
                <!-- <li disabled style="cursor: not-allowed" class="breadcrumb-item" aria-current="page">Uploaded Files</li> -->
              </ul>
            </nav>
          </div>
          <div class="d-flex align-items-center">
            <div style="cursor: pointer" @click="toggleSidebar" class="list-grid-toggle mr-4">
              <span class="icon icon-grid i-grid"><i class="ri-information-line font-size-20"></i></span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- BreadCrumb :: end -->

    <!-- Container :: start -->
    <div class="d-flex align-items-start" v-if="!getHbLoader">
      <div class="icon icon-grid i-grid" style="min-height: 100vh" @click.prevent.right="showModalWindow">
        <!-- shareFolderModal :: start -->
        <b-modal ref="sfm" centered hide-header hide-footer>
          <HbShareModal :fc="fc" @close="closeShareModal" />
        </b-modal>
        <!-- shareFolderModal :: start -->

        <!-- editShareFolderModal :: start -->
        <b-modal ref="sfm2" centered hide-header hide-footer>
          <HbEditShareModal :fc="fc" @close="closeEditShareModal" />
        </b-modal>
        <!-- editShareFolderModal :: start -->

        <!-- editShareFileModal :: start -->
        <b-modal ref="sfm3" centered hide-header hide-footer>
          <HbEditFileShareModal :fc="fc" @close="closeEditFileShareModal" />
        </b-modal>
        <!-- editShareFileModal :: start -->

        <!-- rightClickMenu :: start -->
        <b-modal class="m-0 p-0" ref="right-menu" size="sm" centered hide-header hide-footer>
          <b-list-group class="list-group list-group-flush" v-if="!isFileUploading">
            <b-list-group-item style="cursor: pointer" @click="createNewFolderFn(getParentFolderId)">Create Folder</b-list-group-item>
            <input style="display: none" id="file-upload" ref="fileInput" @change="uploadDocs($event, getParentFolderId)" type="file" name="fileUpload" accept="*" multiple />
            <b-list-group-item @click="$refs.fileInput.click()"> Upload Files </b-list-group-item>
            <b-list-group-item @click="handleFileUpload"> Upload Folders </b-list-group-item>
          </b-list-group>
          <b-list-group class="text-center p-5" v-if="isFileUploading"> Please Wait ... </b-list-group>
        </b-modal>
        <!-- rightClickMenu :: end -->

        <!-- containerRow :: start -->
        <div class="row">
          <div class="col-lg-3 col-md-3 col-sm-6" v-for="doc in getAllDocumentsItems" :key="doc.uuid">
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
                        <b-dropdown-item><i class="ri-drag-move-2-line mr-2"></i>Move</b-dropdown-item>
                        <b-dropdown-item><i class="ri-user-add-fill mr-2"></i>Convert as Team Folder</b-dropdown-item>
                        <!-- <b-dropdown-item><i class="ri-upload-cloud-2-line mr-2"></i>File Request</b-dropdown-item> -->
                        <!-- <b-dropdown-item><i class="ri-information-line mr-2"></i>Details</b-dropdown-item> -->
                        <b-dropdown-item @click="downloadFolderByIdAn(doc.data.uuid)"><i class="ri-folder-download-line mr-2"></i>Download</b-dropdown-item>
                        <b-dropdown-item @click="deleteFolderByIdToTrashAn(doc.data.uuid)"><i class="ri-recycle-line mr-2"></i>Trash</b-dropdown-item>
                        <b-dropdown-item @click="deleteFolderByIdPermanentlyAn(doc.data.uuid)"><i class="ri-delete-bin-line mr-2"></i>Delete</b-dropdown-item>
                        <b-dropdown-item v-if="!doc.data.relationships.shared" id="toggle-btn" @click="shareFolderByIdFn(doc.data.uuid)"><i class="ri-share-line mr-2"></i>Share</b-dropdown-item>
                        <b-dropdown-item v-if="doc.data.relationships.shared" id="toggle-btn" @click="editShareFolderByIdFn(doc.data.relationships.shared?.data?.attributes)"><i class="ri-share-line mr-2"></i>Edit Share</b-dropdown-item>
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
                      <b-dropdown-item @click="secureFileByIdFn(doc.data.uuid)"><i class="ri-file-shield-2-line"></i> Secure With XRPL</b-dropdown-item>
                      <b-dropdown-item @click="downloadFileById({ base_name: doc.data.attributes.basename, file_name: doc.data.attributes.name })"><i class="ri-download-2-fill mr-2"></i>Download</b-dropdown-item>
                      <b-dropdown-item @click="deleteFileByIdToTrash(doc.data.uuid)"><i class="ri-eye-fill mr-2"></i>Move To Trash</b-dropdown-item>
                      <b-dropdown-item @click="deleteFileByIdPermanently(doc.data.uuid)"><i class="ri-delete-bin-6-fill mr-2"></i>Delete Permanently</b-dropdown-item>
                      <b-dropdown-item v-if="!doc.data.relationships.shared" @click="shareFileByIdFn(doc.data.uuid)"><i class="ri-share-line mr-2"></i>Share</b-dropdown-item>
                      <b-dropdown-item v-if="doc.data.relationships.shared" @click="editShareFileByIdFn(doc.data.relationships.shared?.data?.attributes)"><i class="ri-share-line mr-2"></i>Edit Share</b-dropdown-item>
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
                        <b-dropdown-item @click="secureFileByIdFn(doc.data.uuid)"><i class="ri-file-shield-2-line"></i> Secure With XRPL</b-dropdown-item>
                        <b-dropdown-item @click="downloadFileById({ base_name: doc.data.attributes.basename, file_name: doc.data.attributes.name })"><i class="ri-download-2-fill mr-2"></i>Download</b-dropdown-item>
                        <b-dropdown-item @click="deleteFileByIdToTrash(doc.data.uuid)"><i class="ri-eye-fill mr-2"></i>Move To Trash</b-dropdown-item>
                        <b-dropdown-item @click="deleteFileByIdPermanently(doc.data.uuid)"><i class="ri-delete-bin-6-fill mr-2"></i>Delete Permanently</b-dropdown-item>
                        <b-dropdown-item v-if="!doc.data.relationships.shared" @click="shareFileByIdFn(doc.data.uuid)"><i class="ri-share-line mr-2"></i>Share</b-dropdown-item>
                        <b-dropdown-item v-if="doc.data.relationships.shared" @click="editShareFileByIdFn(doc.data.relationships.shared?.data?.attributes)"><i class="ri-share-line mr-2"></i>Edit Share</b-dropdown-item>
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
                    <!-- <a href="#" :data-url="`${baseUrl}/doc-viewer/files/demo.pdf`" data-title="Mobile-plan.pdf" @click="$root.$emit('bv::show::modal', 'viewer-modal', $event.target)" v-b-modal.viewer-modal>
                      <img src="@/assets/images/layouts/page-1/pdf.png" class="img-fluid" alt="image1" />
                    </a> -->
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
                        <b-dropdown-item @click="secureFileByIdFn(doc.data.uuid)"><i class="ri-file-shield-2-line"></i> Secure With XRPL</b-dropdown-item>
                        <b-dropdown-item @click="downloadFileById({ base_name: doc.data.attributes.basename, file_name: doc.data.attributes.name })"><i class="ri-download-2-fill mr-2"></i>Download</b-dropdown-item>
                        <b-dropdown-item @click="deleteFileByIdToTrash(doc.data.uuid)"><i class="ri-eye-fill mr-2"></i>Move To Trash</b-dropdown-item>
                        <b-dropdown-item @click="deleteFileByIdPermanently(doc.data.uuid)"><i class="ri-delete-bin-6-fill mr-2"></i>Delete Permanently</b-dropdown-item>
                        <b-dropdown-item v-if="!doc.data.relationships.shared" @click="shareFileByIdFn(doc.data.uuid)"><i class="ri-share-line mr-2"></i>Share</b-dropdown-item>
                        <b-dropdown-item v-if="doc.data.relationships.shared" @click="editShareFileByIdFn(doc.data.relationships.shared?.data?.attributes)"><i class="ri-share-line mr-2"></i>Edit Share</b-dropdown-item>
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
                      <b-dropdown-item @click="secureFileByIdFn(doc.data.uuid)"><i class="ri-file-shield-2-line"></i> Secure With XRPL</b-dropdown-item>
                      <b-dropdown-item @click="downloadFileById({ base_name: doc.data.attributes.basename, file_name: doc.data.attributes.name })"><i class="ri-download-2-fill mr-2"></i>Download</b-dropdown-item>
                      <b-dropdown-item @click="deleteFileByIdToTrash(doc.data.uuid)"><i class="ri-eye-fill mr-2"></i>Move To Trash</b-dropdown-item>
                      <b-dropdown-item @click="deleteFileByIdPermanently(doc.data.uuid)"><i class="ri-delete-bin-6-fill mr-2"></i>Delete Permanently</b-dropdown-item>
                      <b-dropdown-item v-if="!doc.data.relationships.shared" @click="shareFileByIdFn(doc.data.uuid)"><i class="ri-share-line mr-2"></i>Share</b-dropdown-item>
                      <b-dropdown-item v-if="doc.data.relationships.shared" @click="editShareFileByIdFn(doc.data.relationships.shared?.data?.attributes)"><i class="ri-share-line mr-2"></i>Edit Share</b-dropdown-item>
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
                      <b-dropdown-item @click="secureFileByIdFn(doc.data.uuid)"><i class="ri-file-shield-2-line"></i> Secure With XRPL</b-dropdown-item>
                      <b-dropdown-item @click="downloadFileById({ base_name: doc.data.attributes.basename, file_name: doc.data.attributes.name })"><i class="ri-download-2-fill mr-2"></i>Download</b-dropdown-item>
                      <b-dropdown-item @click="deleteFileByIdToTrash(doc.data.uuid)"><i class="ri-eye-fill mr-2"></i>Move To Trash</b-dropdown-item>
                      <b-dropdown-item @click="deleteFileByIdPermanently(doc.data.uuid)"><i class="ri-delete-bin-6-fill mr-2"></i>Delete Permanently</b-dropdown-item>
                      <b-dropdown-item v-if="!doc.data.relationships.shared" @click="shareFileByIdFn(doc.data.uuid)"><i class="ri-share-line mr-2"></i>Share</b-dropdown-item>
                      <b-dropdown-item v-if="doc.data.relationships.shared" @click="editShareFileByIdFn(doc.data.relationships.shared?.data?.attributes)"><i class="ri-share-line mr-2"></i>Edit Share</b-dropdown-item>
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
                      <b-dropdown-item @click="secureFileByIdFn(doc.data.uuid)"><i class="ri-file-shield-2-line"></i> Secure With XRPL</b-dropdown-item>
                      <b-dropdown-item @click="downloadFileById({ base_name: doc.data.attributes.basename, file_name: doc.data.attributes.name })"><i class="ri-download-2-fill mr-2"></i>Download</b-dropdown-item>
                      <b-dropdown-item @click="deleteFileByIdToTrash(doc.data.uuid)"><i class="ri-eye-fill mr-2"></i>Move To Trash</b-dropdown-item>
                      <b-dropdown-item @click="deleteFileByIdPermanently(doc.data.uuid)"><i class="ri-delete-bin-6-fill mr-2"></i>Delete Permanently</b-dropdown-item>
                      <b-dropdown-item v-if="!doc.data.relationships.shared" @click="shareFileByIdFn(doc.data.uuid)"><i class="ri-share-line mr-2"></i>Share</b-dropdown-item>
                      <b-dropdown-item v-if="doc.data.relationships.shared" @click="editShareFileByIdFn(doc.data.relationships.shared?.data?.attributes)"><i class="ri-share-line mr-2"></i>Edit Share</b-dropdown-item>
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
                      <b-dropdown-item @click="secureFileByIdFn(doc.data.uuid)"><i class="ri-file-shield-2-line"></i> Secure With XRPL</b-dropdown-item>
                      <b-dropdown-item @click="downloadFileById({ base_name: doc.data.attributes.basename, file_name: doc.data.attributes.name })"><i class="ri-download-2-fill mr-2"></i>Download</b-dropdown-item>
                      <b-dropdown-item @click="deleteFileByIdToTrash(doc.data.uuid)"><i class="ri-eye-fill mr-2"></i>Move To Trash</b-dropdown-item>
                      <b-dropdown-item @click="deleteFileByIdPermanently(doc.data.uuid)"><i class="ri-delete-bin-6-fill mr-2"></i>Delete Permanently</b-dropdown-item>
                      <b-dropdown-item v-if="!doc.data.relationships.shared" @click="shareFileByIdFn(doc.data.uuid)"><i class="ri-share-line mr-2"></i>Share</b-dropdown-item>
                      <b-dropdown-item v-if="doc.data.relationships.shared" @click="editShareFileByIdFn(doc.data.relationships.shared?.data?.attributes)"><i class="ri-share-line mr-2"></i>Edit Share</b-dropdown-item>
                    </b-dropdown>
                  </div>
                </div>
              </div>
            </div>
            <!-- mp4 :: end -->
          </div>
          <div v-if="getAllDocumentsItems.length === 0" class="under-folder-upload col-lg-6 offset-lg-3">
            <div class="under-folder-inner">
              <h5>Upload Your First File</h5>
              <p>Upload some files here easily via upload button.</p>
              <input style="display: none" id="file-upload" ref="fileInput" @change="uploadDocs($event, getParentFolderId)" type="file" name="fileUpload" accept="*" multiple />
              <button class="btn btn-primary" @click="$refs.fileInput.click()">Upload Files</button>
            </div>
          </div>
        </div>
        <!-- containerRow :: end -->
      </div>
      <div v-if="getRightSidebar" class="mx-3 px-3" style="min-width: 20%; max-width: 20%; border-left: 1px solid #e3e3e3; min-height: 100vh">
        <!-- folderDetail :: start -->
        <div v-if="getRightSideFolderDetail" class="mx-auto">
          <div>
            <div class="d-flex align-items-start justify-content-start">
              <i class="ri-folder-fill mx-2"></i>
              <small>{{ getRightSideFolderDetail[0].data.attributes.name }}</small>
            </div>
            <div class="mt-3 d-flex flex-column">
              <small class="text-primary">created at</small>
              <small>{{ getRightSideFolderDetail[0].data.attributes.created_at }}</small>
            </div>
            <div class="mt-3 d-flex flex-column align-content-center">
              <small class="text-primary">where</small>
              <small>My Files <i class="ri-pencil-line"></i></small>
            </div>
          </div>
        </div>
        <!-- folderDetail :: end -->

        <!-- fileDetail :: start -->
        <div v-else-if="getRightSideFileDetail" class="mx-auto">
          <!-- image :: start -->
          <div v-if="getRightSideFileDetail[0]?.data?.type === 'image'">
            <div class="d-flex align-items-start justify-content-start">
              <img style="border-radius: 10px" :src="getRightSideFileDetail[0].data.attributes.thumbnail.sm" alt="file" />
            </div>
            <div class="d-flex align-items-start my-3">
              <i class="ri-image-line mx-2"></i>
              <div class="d-flex flex-column">
                <small class="text-primary">{{ getRightSideFileDetail[0].data.attributes.name }}</small>
                <small class="text-muted">{{ getRightSideFileDetail[0].data.attributes.mimetype }}</small>
              </div>
            </div>
            <div class="d-flex flex-column">
              <p class="text-primary py-0 mb-0">Size</p>
              <small>
                <b>{{ getRightSideFileDetail[0].data.attributes.filesize }}</b>
              </small>
            </div>
            <br />
            <div class="d-flex flex-column">
              <p class="text-primary py-0 mb-0">Created at</p>
              <small>
                <b>{{ getRightSideFileDetail[0].data.attributes.created_at }}</b>
              </small>
            </div>
            <br />
            <div class="d-flex flex-column">
              <p class="text-primary py-0 mb-0">where</p>
              <small><b>My Files </b><i class="ri-pencil-line"></i></small>
            </div>
            <br />
            <div class="d-flex flex-column">
              <p class="text-primary py-0 mb-1">Meta data</p>
              <div>
                <div class="d-flex justify-content-between">
                  <small><b>Content Created</b></small>
                  <small>No Data</small>
                </div>
                <div class="d-flex justify-content-between">
                  <small><b>Dimentions</b></small>
                  <small>No Data</small>
                </div>
              </div>
            </div>
          </div>
          <!-- image :: end -->

          <!-- doc :: start -->
          <div v-if="getRightSideFileDetail[0]?.data?.attributes?.mimetype === 'doc'">
            <div>
              <div class="d-flex justify-content-start align-items-start">
                <i class="ri-file-fill mx-2 pt-2"></i>
                <div class="d-flex flex-column">
                  <span>{{ getRightSideFileDetail[0]?.data?.attributes?.name }}</span>
                  <small>pdf</small>
                </div>
              </div>
            </div>

            <div class="mt-3 d-flex flex-column">
              <small class="text-primary">size</small>
              <small>{{ getRightSideFileDetail[0]?.data?.attributes?.filesize }}</small>
            </div>

            <div class="mt-3 d-flex flex-column">
              <small class="text-primary">created at</small>
              <small>{{ getRightSideFileDetail[0]?.data?.attributes?.created_at }}</small>
            </div>

            <div class="mt-3 d-flex flex-column align-content-center">
              <small class="text-primary">where</small>
              <small>My Files <i class="ri-pencil-line"></i></small>
            </div>
          </div>
          <!-- doc :: end -->

          <!-- xlsx :: start -->
          <div v-if="getRightSideFileDetail[0]?.data?.attributes?.mimetype === 'xlsx'">
            <div>
              <div class="d-flex justify-content-start align-items-start">
                <i class="ri-file-fill mx-2 pt-2"></i>
                <div class="d-flex flex-column">
                  <span>{{ getRightSideFileDetail[0]?.data?.attributes?.name }}</span>
                  <small>pdf</small>
                </div>
              </div>
            </div>

            <div class="mt-3 d-flex flex-column">
              <small class="text-primary">size</small>
              <small>{{ getRightSideFileDetail[0]?.data?.attributes?.filesize }}</small>
            </div>

            <div class="mt-3 d-flex flex-column">
              <small class="text-primary">created at</small>
              <small>{{ getRightSideFileDetail[0]?.data?.attributes?.created_at }}</small>
            </div>

            <div class="mt-3 d-flex flex-column align-content-center">
              <small class="text-primary">where</small>
              <small>My Files <i class="ri-pencil-line"></i></small>
            </div>
          </div>
          <!-- xlsx :: end -->

          <!-- pdf :: start -->
          <div v-if="getRightSideFileDetail[0]?.data?.attributes?.mimetype === 'pdf'">
            <div>
              <div class="d-flex justify-content-start align-items-start">
                <i class="ri-file-fill mx-2 pt-2"></i>
                <div class="d-flex flex-column">
                  <span>{{ getRightSideFileDetail[0]?.data?.attributes?.name }}</span>
                  <small>pdf</small>
                </div>
              </div>
            </div>

            <div class="mt-3 d-flex flex-column">
              <small class="text-primary">size</small>
              <small>{{ getRightSideFileDetail[0]?.data?.attributes?.filesize }}</small>
            </div>

            <div class="mt-3 d-flex flex-column">
              <small class="text-primary">created at</small>
              <small>{{ getRightSideFileDetail[0]?.data?.attributes?.created_at }}</small>
            </div>

            <div class="mt-3 d-flex flex-column align-content-center">
              <small class="text-primary">where</small>
              <small>My Files <i class="ri-pencil-line"></i></small>
            </div>
          </div>
          <!-- pdf :: end -->

          <!-- ppt :: start -->
          <div v-if="getRightSideFileDetail[0]?.data?.attributes?.mimetype === 'ppt'">
            <div>
              <div class="d-flex justify-content-start align-items-start">
                <i class="ri-file-fill mx-2 pt-2"></i>
                <div class="d-flex flex-column">
                  <span>{{ getRightSideFileDetail[0]?.data?.attributes?.name }}</span>
                  <small>pdf</small>
                </div>
              </div>
            </div>

            <div class="mt-3 d-flex flex-column">
              <small class="text-primary">size</small>
              <small>{{ getRightSideFileDetail[0]?.data?.attributes?.filesize }}</small>
            </div>

            <div class="mt-3 d-flex flex-column">
              <small class="text-primary">created at</small>
              <small>{{ getRightSideFileDetail[0]?.data?.attributes?.created_at }}</small>
            </div>

            <div class="mt-3 d-flex flex-column align-content-center">
              <small class="text-primary">where</small>
              <small>My Files <i class="ri-pencil-line"></i></small>
            </div>
          </div>
          <!-- ppt :: end -->
        </div>
        <!-- fileDetail :: end -->

        <!-- noContent :: start -->
        <div class="mx-auto my-auto text-center d-flex flex-column justify-content-center align-content-center" v-else>
          <div class="d-flex flex-column">
            <i class="ri-eye-off-line"></i>
            <small class="text-muted">There is nothing to preview</small>
          </div>
        </div>
        <!-- noContent :: end -->
      </div>
    </div>
    <!-- Container :: end -->
  </div>
</template>
<script lang="js">
import axios from 'axios';
import { mapGetters, mapActions, mapMutations } from 'vuex';
import HbShareModal from '@/components/HbComponents/HbModals/HbShareModal.vue'
import HbEditShareModal from '@/components/HbComponents/HbModals/HbEditShareModal.vue';
import HbEditFileShareModal from '@/components/HbComponents/HbModals/HbEditFileShareModal.vue';

import Loader from '@/components/loader/HbLoader.vue';
export default {
  name: 'uploadfiles',
  components: {
    HbShareModal,
    HbEditShareModal,
    HbEditFileShareModal,
    Loader
  },
  data() {
    return {
      // uploadPercentage: 0,
      isFileUploading: false,
      fc: {},
    }
  },
  computed: {
    ...mapGetters('Browser', ['getHbLoader', 'getRightSidebar', 'getRightSideFolderDetail', 'getRightSideFileDetail', 'getFolderUuid', 'getParentFolderId','getAllDocumentsItems']),
  },
  methods: {
    ...mapMutations('Browser', ['toggleSidebar']),
    ...mapMutations('Share', ['resetShareDataDetails']),
    ...mapActions('Browser', ['secureWithXRPLAn', 'downloadFolderByIdAn', 'getSingleFolderDetailsAn', 'getSingleFileDetailsAn', 'getSingleFileDetailsAn', 'createFolderAn', 'getAllDocumentsAn', 'getDocDetailsAn', 'updateFolderNameAn', 'deleteFolderByIdToTrashAn', 'deleteFolderByIdPermanentlyAn', 'deleteFileByIdToTrash', 'deleteFileByIdPermanently', 'downloadFileById']),


  secureFileByIdFn(file_uuid){
    this.secureWithXRPLAn(file_uuid);
  },
  handleFileUpload(){
    console.log('No logic added yet');
  },
  showSingleFolderDetailFn(folder_uuid){
    this.getSingleFolderDetailsAn(folder_uuid);
  },
  showSingleFileDetailFn(file_uuid){
    this.getSingleFileDetailsAn(file_uuid);
  },
  createNewFolderFn(parentFolderId){
    this.createFolderAn(parentFolderId);
    this.$refs['right-menu'].hide();
  },
  showModalWindow(){
    this.$refs['right-menu'].show()
  },
  shareFolderByIdFn(folder_uuid){
    this.$refs['sfm'].show();
    this.getSingleFolderDetailsAn(folder_uuid).then(()=>{
      let fData = this.getRightSideFolderDetail;
      this.fc = {
        name: fData[0].data?.attributes?.name,
        items: fData[0].data?.attributes?.items,
        uuid: fData[0].data?.uuid,
        type: 'folder'
      }
    }).catch(e => console.log('e', e));
  },
  shareFileByIdFn(file_uuid){
    this.$refs['sfm'].show();
    this.getSingleFileDetailsAn(file_uuid).then(()=>{
      let fData = this.getRightSideFileDetail;
      this.fc = {
        name: fData[0].data?.attributes?.name,
        items: fData[0].data?.attributes?.items,
        uuid: fData[0].data?.uuid,
        type: 'file'
      }
    }).catch(e => console.log('e', e));
  },
  editShareFolderByIdFn(share_data){
    this.$refs['sfm2'].show();
    this.fc = share_data;
  },
  editShareFileByIdFn(share_data){
    this.$refs['sfm3'].show();
    this.fc = share_data;
  },
  closeShareModal(){
    this.$refs['sfm'].hide();
    this.resetShareDataDetails();
  },

  closeEditShareModal(){
    this.$refs['sfm2'].hide();
    this.getAllDocumentsAn();
    this.resetShareDataDetails();
  },
  closeEditFileShareModal(){
    this.$refs['sfm3'].hide();
    this.getAllDocumentsAn();
    this.resetShareDataDetails();
  },


  updateFolderFn(e, doc) {
    const payload = {
      newName: e,
      uuid: doc.data.uuid
    }
    this.updateFolderNameAn(payload)
  },

  async uploadDocs(event, id) {

    this.isFileUploading = true;

    if(!event.target.files) return;

    const fd = new FormData()
    for (let i = 0; i < event.target.files.length; i++ ){
      fd.append('files[' + i + ']', event.target.files[i]);
    }

    fd.append('uuid', 'uuid')

    if(id !== null){
      fd.append('parent_folder_id', parseInt(id))
    }

    await axios.post('/upload/file', fd, {
        headers: {
          'Content-Type': 'multipart/form-data'
        },
        onUploadProgress: function (progressEvent) {
          console.log(parseInt( Math.round( ( progressEvent.loaded / progressEvent.total ) * 100 ) ));
          // this.uploadPercentage = parseInt( Math.round( ( progressEvent.loaded / progressEvent.total ) * 100 ) );
        }.bind(this)
      }).then((res) => {
        if(res.status === 200){
          this.$refs['right-menu'].hide();
          if(this.$store.getters['Browser/getFolderUuid'] !== null){
            this.getDocDetailsAn(this.$store.getters['Browser/getFolderUuid']);
          } else {
            this.getAllDocumentsAn();
          }
          this.isFileUploading = false;
        } else {
          alert('something went wrong in file upload');
        }
      }).catch(e => console.log(e));
  },
  getDocDetailsFn(folder_uuid){
    this.$router.push({ name: 'drive.filebrowserdetail', params : { uuid: folder_uuid}})
  }
  },
  mounted() {
    this.getAllDocumentsAn();
  }
}
</script>
