<template>
  <div class="container-fluid">
    <Loader v-model="getHbLoader" class="loader" />
    <b-row>
      <!-- header :: start -->
      <div class="col-lg-8">
        <div class="iq-welcome">
          <div class="property2-content">
            <div class="d-flex flex-wrap align-items-center">
              <div class="col-lg-6 col-sm-6 p-0">
                <h3 class="mb-3">Hey {{ getCompUser?.name }}, Welcome Back .!</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- header :: end -->

      <!-- ################  RECENT_FOLDERS :: start ################  -->
      <!-- recentFolderHeader :: start -->
      <div class="col-lg-12">
        <div class="card card-block card-stretch card-transparent">
          <div class="card-header d-flex justify-content-between pb-0">
            <div class="header-title">
              <h4 class="card-title">Folders</h4>
            </div>
            <!-- rightSide :: start -->
            <!-- <div class="card-header-toolbar d-flex align-items-center">
              <b-dropdown v-b-tooltip.hover title="Filter Folders" disabled id="dropdownMenuButton1" right variant="none p-0" data-toggle="dropdown" class="dropdown shadow none">
                <template v-slot:button-content>
                  <span class="dropdown-toggle dropdown-bg btn bg-white" id="dropdownMenuButton1" data-toggle="dropdown"> Name<i class="ri-arrow-down-s-line ml-1"></i> </span>
                </template>
                <b-dropdown-item>{{ "Last modified" }}</b-dropdown-item>
                <b-dropdown-item>{{ "Last modifiedby me" }}</b-dropdown-item>
                <b-dropdown-item>{{ "Last opened by me" }}</b-dropdown-item>
              </b-dropdown>
            </div> -->
            <!-- rightSide :: end -->
          </div>
        </div>
      </div>
      <!-- recentFolderHeader :: start -->

      <!-- loopRecentFolders :: start -->
      <div class="col-md-6 col-sm-6 col-lg-3" v-for="folder in getRecentFolders" :key="folder.data.uuid">
        <div class="card card-block card-stretch card-height hub-folders" v-if="folder.data.type === 'folder'" @dblclick.prevent="showFolderDetails(folder.data.uuid)">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div class="hub-folder mb-4">
                <svg fill="none" height="50" viewBox="0 0 50 50" width="50" xmlns="http://www.w3.org/2000/svg">
                  <path d="m40.6863 14.9414h-18.0392l-3.5883-4.2647c-.1207-.1451-.3016-.2265-.4902-.2206h-14.55389c-2.22206.0162-4.01471 1.8221-4.01471 4.0441v26.2304c.00269608 2.2297 1.80956 4.0365 4.03922 4.0392h36.64708c2.2296-.0027 4.0365-1.8095 4.0392-4.0392v-21.75c-.0027-2.2296-1.8096-4.0365-4.0392-4.0392z" fill="#4590e8" />
                  <path d="m45.9853 9.71582h-18.0441l-3.5883-4.26471c-.1207-.1451-.3016-.22647-.4902-.22059h-14.549c-2.01617.00331-3.72108 1.49277-3.9951 3.4902h13.2696c.6958-.00172 1.3565.30539 1.8039.83823l3.0638 3.64215h17.2304c3.1868.0054 5.7691 2.5876 5.7745 5.7745v20.5294c2.0206-.252 3.5376-1.9686 3.5392-4.0049v-21.75c-.0053-2.2182-1.7966-4.01811-4.0147-4.03428z" fill="#73b3ff" />
                </svg>
              </div>
              <div class="card-header-toolbar">
                <b-dropdown id="dropdownMenuButton1" right variant="none p-0" data-toggle="dropdown" class="dropdown shadow none">
                  <template v-slot:button-content>
                    <span class="dropdown-toggle" id="dropdownMenuButton2" data-toggle="dropdown">
                      <i class="ri-more-fill"></i>
                    </span>
                  </template>
                  <b-dropdown-item @click="showViewFolderModalFn(folder.data.uuid)"><i class="ri-eye-fill mr-2"></i>{{ "view" }}</b-dropdown-item>
                  <b-dropdown-item @click="deleteFolderByIdToTrash(folder.data.uuid)"><i class="ri-recycle-line mr-2"></i>{{ "trash" }}</b-dropdown-item>
                  <b-dropdown-item @click="deleteFolderByIdPermanently(folder.data.uuid)"><i class="ri-delete-bin-6-fill mr-2"></i>{{ "delete" }}</b-dropdown-item>
                  <b-dropdown-item @click="downloadFolderByIdAn(folder.data.uuid)"><i class="ri-folder-download-fill mr-2"></i>{{ "download" }}</b-dropdown-item>
                </b-dropdown>
              </div>
            </div>
            <div class="folder">
              <h5>{{ folder.data.attributes.name }}</h5>
              <span class="hub-folder-meta">
                <span class="hf-files" v-if="folder.data.attributes.items">{{ folder.data.attributes.items }} files</span>
                <span class="hf-size" v-if="folder.data.attributes.filesize">{{ folder.data.attributes.filesize }}</span>
              </span>
              <!-- <template>
                <div class="hub-folder-share">
                  <span class="hf-share-t text-primar" v-if="folder.data.shared">Shared</span>
                  <b-avatar-group size="24px" class="hub-folder-avtar">
                    <b-avatar src="https://i.pravatar.cc/150?img=1" variant="info"></b-avatar>
                    <b-avatar src="https://i.pravatar.cc/150?img=2" variant="info"></b-avatar>
                    <b-avatar src="https://i.pravatar.cc/150?img=3" variant="info"></b-avatar>
                    <b-avatar src="https://i.pravatar.cc/150?img=4" variant="info"></b-avatar>
                    <b-avatar src="https://i.pravatar.cc/150?img=5" variant="info"></b-avatar>
                    <b-avatar src="https://i.pravatar.cc/150?img=6" variant="info"></b-avatar>
                    <b-avatar icon="music-note" variant="dark">+4</b-avatar>
                  </b-avatar-group>
                </div>
              </template> -->
            </div>
          </div>
        </div>
      </div>
      <!-- loopRecentFolders :: start -->

      <!-- viewFolderDetails :: start -->
      <b-modal ref="viewFolder" lazy centered size="lg" hide-footer>
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
      </b-modal>
      <!-- viewFolderDetails :: start -->
      <!-- ################  RECENT_FOLDERS :: end ################  -->
    </b-row>
    <b-row>
      <!-- ################ RECENT_FILES:: start ################  -->
      <b-col col lg="6" class="mt-3">
        <!-- recentFilesHeader :: start -->
        <div class="card card-block card-stretch card-transparent">
          <div class="card-header d-flex justify-content-between pb-0">
            <div class="header-title">
              <h4 class="card-title">Recent Files</h4>
            </div>
            <div class="card-header-toolbar d-flex align-items-center">
              <router-link :to="{ name: 'drive.filebrowser' }" class="view-more">View all files</router-link>
            </div>
          </div>
        </div>
        <!-- recentFilesHeader :: start -->

        <!-- loopRecentFiles :: start -->
        <b-card>
          <table class="recent-table">
            <tr class="recent-table-head">
              <th>Name</th>
              <th>Last Modified</th>
            </tr>
            <tr class="rt-items" v-for="file in getRecentFiles" :key="file.uuid">
              <template v-if="file.data.type !== 'folder'">
                <td class="rt-name">
                  <router-link :to="{ name: 'drive.filebrowser' }" class="rt-link">
                    <svg fill="none" height="20" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg">
                      <path d="m17.2188 5.47656v13.23434c0 .711-.5782 1.2891-1.2891 1.2891h-11.91017c-.71094 0-1.28906-.5781-1.28906-1.2891v-17.42184c0-.710935.57812-1.28906 1.28906-1.28906h7.71877z" fill="#f5b912" />
                      <path d="m12.6406 9.12109h-5.25388c-.48828 0-.88281.39454-.88281.88281v5.2539c0 .4883.39453.8828.88281.8828h5.25388c.4883 0 .8828-.3945.8828-.8828v-5.2578c0-.48438-.3945-.87891-.8828-.87891zm-.0273 5.44921h-5.19533v-3.5351h5.19533z" fill="#fff" />
                      <path d="m12.4844 5.25 4.7304 3.83203v-3.60156l-2.6836-1.55469z" fill="#000" opacity=".19" />
                      <path d="m17.2422 5.47656h-4.1875c-.7109 0-1.2891-.57812-1.2891-1.28906v-4.1875z" fill="#fadc87" />
                    </svg>
                    <span class="rt-text">
                      <h5>{{ file.data.attributes.name }}</h5>
                      <p>{{ file.data.attributes.filesize }}</p>
                    </span>
                  </router-link>
                </td>
                <td class="rt-date">
                  {{ file.data.attributes.created_at }}
                </td>
                <td class="rt-share">
                  <span class="rt-share-inner">
                    <template>
                      <span class="rt-avt">
                        <!-- <b-avatar-group size="30px">
                        <b-avatar></b-avatar>
                        <b-avatar text="BV" variant="primary"></b-avatar>
                        <b-avatar src="https://placekitten.com/300/300" variant="info"></b-avatar>
                        <b-avatar src="https://placekitten.com/320/320" variant="dark"></b-avatar>
                        <b-avatar icon="music-note" variant="dark">+4</b-avatar>
                      </b-avatar-group> -->
                      </span>
                    </template>
                    <b-dropdown id="dropdownMenuButton1" right variant="none p-0" data-toggle="dropdown" class="dropdown shadow none recent-popup">
                      <template v-slot:button-content>
                        <span class="dropdown-toggle" id="dropdownMenuButton2" data-toggle="dropdown">
                          <i class="ri-more-fill"></i>
                        </span>
                      </template>
                      <b-dropdown-item @click="showViewFileModalFn(file.data.uuid)"><i class="ri-eye-fill mr-2"></i>{{ "view" }}</b-dropdown-item>
                      <b-dropdown-item @click="deleteFileByIdToTrash(file.data.uuid)"><i class="ri-recycle-line mr-2"></i>{{ "trash" }}</b-dropdown-item>
                      <b-dropdown-item @click="deleteFileByIdPermanently(file.data.uuid)"><i class="ri-delete-bin-6-fill mr-2"></i>{{ "delete" }}</b-dropdown-item>
                      <b-dropdown-item @click="downloadFileById({ base_name: file.data.attributes.basename, file_name: file.data.attributes.name })"><i class="ri-folder-download-fill mr-2"></i>{{ "download" }}</b-dropdown-item>
                    </b-dropdown>
                  </span>
                </td>
              </template>
            </tr>
          </table>
        </b-card>
        <!-- loopRecentFiles :: end -->

        <!-- viewFileDetails :: start -->
        <b-modal ref="viewFile" lazy centered size="lg" hide-footer>
          <!-- fileDetail :: start -->
          <div v-if="getRightSideFileDetail" class="mx-auto">
            <div>
              <!-- <div class="d-flex align-items-start justify-content-start">
                <b-img fluid-grow :src="getRightSideFileDetail[0].data.attributes.thumbnail" :alt="getRightSideFileDetail[0].data.attributes.name" />
              </div> -->
              <div>
                <p>{{ getRightSideFileDetail[0].data.attributes.name }}</p>
              </div>
              <div class="mt-3 d-flex flex-column">
                <small class="text-primary">created at</small>
                <small>{{ getRightSideFileDetail[0].data.attributes.created_at }}</small>
              </div>
              <div class="mt-3 d-flex flex-column align-content-center">
                <small class="text-primary">where</small>
                <small>My Files <i class="ri-pencil-line"></i></small>
              </div>
            </div>
          </div>
          <!-- fileDetail :: end -->
        </b-modal>
        <!-- viewFileDetails :: start -->
      </b-col>
      <!-- ################ RECENT_FILES:: End ################  -->

      <!-- Storage And MemeberList Widgets :: start -->
      <b-col col lg="6" class="mt-3">
        <!-- Storage Start -->
        <div>
          <div class="card card-block card-stretch card-transparent">
            <div class="card-header d-flex justify-content-between pb-0">
              <div class="header-title">
                <h4 class="card-title">Storage</h4>
              </div>
              <div class="card-header-toolbar d-flex align-items-center">
                <router-link :to="{ name: 'drive.filebrowser' }" class="view-more">Edit files</router-link>
              </div>
            </div>
          </div>
          <b-card class="storage-card">
            <b-progress :value="fileTraffic?.total_uploaded_percent" :max="100" height="40px" class="mb-3 hub-storage"></b-progress>
            <div class="storage-legend d-flex justify-content-between">
              <span class="active sl-legend">
                <i class="ri-checkbox-blank-circle-fill"></i>
                <span class="sl-title">Used Storage</span>
                <span class="sl-value">{{ (fileTraffic?.total_uploaded * 0.00000095367432).toPrecision(4) }} MB</span>
              </span>
              <span class="deactive sl-legend">
                <i class="ri-checkbox-blank-circle-fill"></i>
                <span class="sl-title">Storage Left</span>
                <span class="sl-value">{{ ((fileTraffic?.total_storage - fileTraffic?.total_uploaded) * 0.00000095367432).toPrecision(4) }} MB</span>
              </span>
            </div>
          </b-card>
        </div>
        <!-- Storage End -->

        <!-- Memberlist Start -->
        <!-- <div class="card card-block card-stretch card-transparent">
          <div class="card-header d-flex justify-content-between pb-0">
            <div class="header-title">
              <h4 class="card-title">Member list</h4>
            </div>
            <div class="card-header-toolbar d-flex align-items-center">
              <router-link :to="{ name: 'drive.filebrowser' }" class="view-more">Add or remove</router-link>
            </div>
          </div>
        </div>
        <b-card class="member-list-card">
          <b-row>
            <b-col class="right-border">
              <b-list-group class="hub-member-list">
                <b-list-group-item class="d-flex align-items-center">
                  <b-avatar size="42px" variant="info" src="https://i.pravatar.cc/150?img=1" class="mr-3"></b-avatar>
                  <span class="mr-auto m-name">Emily Davis</span>
                  <span class="rt-more"><i class="ri-more-fill"></i></span>
                </b-list-group-item>
                <b-list-group-item class="d-flex align-items-center">
                  <b-avatar size="42px" variant="info" src="https://i.pravatar.cc/150?img=2" class="mr-3"></b-avatar>
                  <span class="mr-auto m-name">John Smith</span>
                  <span class="rt-more"><i class="ri-more-fill"></i></span>
                </b-list-group-item>
                <b-list-group-item class="d-flex align-items-center">
                  <b-avatar size="42px" variant="info" src="https://i.pravatar.cc/150?img=3" class="mr-3"></b-avatar>
                  <span class="mr-auto m-name">Michael Thompson</span>
                  <span class="rt-more"><i class="ri-more-fill"></i></span>
                </b-list-group-item>
              </b-list-group>
            </b-col>
            <b-col>
              <b-list-group class="hub-member-list">
                <b-list-group-item class="d-flex align-items-center">
                  <b-avatar size="42px" variant="info" src="https://i.pravatar.cc/150?img=4" class="mr-3"></b-avatar>
                  <span class="mr-auto m-name">Jack Anderson</span>
                  <span class="rt-more"><i class="ri-more-fill"></i></span>
                </b-list-group-item>
                <b-list-group-item class="d-flex align-items-center">
                  <b-avatar size="42px" variant="info" src="https://i.pravatar.cc/150?img=5" class="mr-3"></b-avatar>
                  <span class="mr-auto m-name">Sarah Mitchell</span>
                  <span class="rt-more"><i class="ri-more-fill"></i></span>
                </b-list-group-item>
                <b-list-group-item class="d-flex align-items-center">
                  <b-avatar size="42px" variant="info" src="https://i.pravatar.cc/150?img=6" class="mr-3"></b-avatar>
                  <span class="mr-auto m-name">William Rodriguez</span>
                  <span class="rt-more"><i class="ri-more-fill"></i></span>
                </b-list-group-item>
              </b-list-group>
            </b-col>
          </b-row>
        </b-card> -->
        <!-- Memberlist End -->
      </b-col>
      <!-- Storage And MemeberList Widgets :: start -->
    </b-row>
  </div>
</template>
<script lang="js">
import { mapGetters, mapActions } from 'vuex';
import Loader from '@/components/loader/HbLoader.vue';
export default {
  name: 'Dashbord',
  components: {
    Loader
  },
  computed: {
    ...mapGetters('Auth', ['getCompUser']),
    ...mapGetters('Files', ['getRecentFiles']),
    ...mapGetters('Folders', ['getRecentFolders']),
    ...mapGetters('Browser', ['getHbLoader', 'getRightSideFolderDetail', 'getRightSideFileDetail']),
    ...mapGetters({
      fileTraffic: 'Traffic/getFileTraffic',
      loggedInUser: 'Auth/getCompUser'
    })
  },
  methods: {
    ...mapActions('Files', ['fetchRecentFilesAn',
      'deleteFileByIdToTrash',
      'deleteFileByIdPermanently']),
    ...mapActions('Folders', ['fetchRecentFoldersAn', 'deleteFolderByIdToTrash', 'deleteFolderByIdPermanently']),
    ...mapActions('Browser', ['getSingleFolderDetailsAn', 'getSingleFileDetailsAn', 'downloadFolderByIdAn', 'downloadFileById', 'getSingleFolderDetailsAn']),
    ...mapActions("Traffic", ["fetchAllUploadedFilesSize"]),

    showViewFolderModalFn(folder_uuid) {
      this.getSingleFolderDetailsAn(folder_uuid).then((res) => {
        if (res.status === 200) {
          this.$refs['viewFolder'].show()
        }
      }).catch(e => console.log('e', e));
    },

    showViewFileModalFn(file_uuid) {
      this.getSingleFileDetailsAn(file_uuid).then((res) => {
        if (res.status === 200) {
          this.$refs['viewFile'].show()
        }
      }).catch(e => console.log('e', e));
    },

    showFolderDetails(folder_uuid) {
      this.$router.push({ name: 'drive.filebrowserdetail', params: { 'uuid': `${folder_uuid}` } })
    },
  },
  created() {
    this.fetchRecentFoldersAn();
    this.fetchRecentFilesAn();
    this.fetchAllUploadedFilesSize(this.loggedInUser.uuid)
  },
}
</script>
