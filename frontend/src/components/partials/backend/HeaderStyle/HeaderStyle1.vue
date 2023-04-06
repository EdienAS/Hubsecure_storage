<template>
  <div class="iq-top-navbar">
    <div class="iq-navbar-custom">
      <nav class="navbar navbar-expand-lg navbar-light p-0">
        <div class="iq-navbar-logo d-flex align-items-center justify-content-between">
          <i class="ri-menu-line wrapper-menu"></i>
          <router-link to="/" class="header-logo">
            <img :src="logo" class="img-fluid rounded-normal" alt="logo" />
          </router-link>
        </div>
        <div class="iq-search-bar device-search">
          <form>
            <div class="input-prepend input-append">
              <div class="btn-group" v-nav-toggle>
                <label class="dropdown-toggle searchbox">
                  <input class="dropdown-toggle search-query text search-input" type="text" v-model="selectedInput" placeholder="Type here to search..." />
                  <span class="search-replace"></span>
                  <a class="search-link" href="#"><i class="ri-search-line"></i></a>
                  <span class="caret"></span>
                </label>

                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <li @click="selectedInput = 'pdf'">
                    <a href="#">
                      <div class="item"><i class="far fa-file-pdf bg-info"></i>PDFs</div>
                    </a>
                  </li>
                  <li @click="selectedInput = 'docx'">
                    <a href="#">
                      <div class="item"><i class="far fa-file-alt bg-primary"></i>Documents</div>
                    </a>
                  </li>
                  <li @click="selectedInput = 'xlsx'">
                    <a href="#">
                      <div class="item"><i class="far fa-file-excel bg-success"></i>Spreadsheet</div>
                    </a>
                  </li>
                  <li @click="selectedInput = 'pptx'">
                    <a href="#">
                      <div class="item"><i class="far fa-file-powerpoint bg-danger"></i>Presentation</div>
                    </a>
                  </li>
                  <li @click="selectedInput = 'jpg'">
                    <a href="#">
                      <div class="item"><i class="far fa-file-image bg-warning"></i>Photos & Images</div>
                    </a>
                  </li>
                  <li @click="selectedInput = 'mp4'">
                    <a href="#">
                      <div class="item"><i class="far fa-file-video bg-info"></i>Videos</div>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </form>
        </div>

        <div class="d-flex align-items-center">
          <ModeSwitch />
          <b-navbar-toggle target="nav-collapse" class="mr-2 text-primary">
            <i class="ri-menu-3-line"></i>
          </b-navbar-toggle>
          <b-collapse id="nav-collapse" is-nav>
            <ul class="navbar-nav ml-auto navbar-list align-items-center">
              <li class="nav-item nav-icon search-content" v-nav-toggle>
                <a href="#" class="search-toggle rounded dropdown-toggle" id="dropdownSearch" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="ri-search-line"></i>
                </a>
                <div class="iq-search-bar iq-sub-dropdown dropdown-menu" aria-labelledby="dropdownSearch">
                  <form action="#" class="searchbox p-2">
                    <div class="form-group mb-0 position-relative">
                      <input type="text" class="text search-input font-size-12" placeholder="type here to search..." />
                      <a href="#" class="search-link"><i class="las la-search"></i></a>
                    </div>
                  </form>
                </div>
              </li>
              <!-- help :: start -->
              <!-- <li class="nav-item nav-icon dropdown" v-nav-toggle>
                <a href="#" class="search-toggle dropdown-toggle" id="dropdownMenuButton01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="ri-question-line"></i>
                </a>
                <div class="iq-sub-dropdown dropdown-menu" aria-labelledby="dropdownMenuButton01">
                  <div class="card shadow-none m-0">
                    <div class="card-body p-0">
                      <div class="p-3">
                        <a href="#" class="iq-sub-card pt-0"><i class="ri-questionnaire-line"></i>Help</a>
                        <a href="#" class="iq-sub-card"><i class="ri-recycle-line"></i>Training</a>
                        <a href="#" class="iq-sub-card"><i class="ri-refresh-line"></i>Updates</a>
                        <a href="#" class="iq-sub-card"><i class="ri-service-line"></i>Terms and Policy</a>
                        <a href="#" class="iq-sub-card"><i class="ri-feedback-line"></i>Send Feedback</a>
                      </div>
                    </div>
                  </div>
                </div>
              </li> -->
              <!-- help :: end -->

              <!-- settings :: start -->
              <!-- <li class="nav-item nav-icon dropdown" v-nav-toggle>
                <a href="#" class="search-toggle dropdown-toggle dropdown-toggle" id="dropdownMenuButton02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="ri-settings-3-line"></i>
                </a>
                <div class="iq-sub-dropdown dropdown-menu" aria-labelledby="dropdownMenuButton02">
                  <div class="card shadow-none m-0">
                    <div class="card-body p-0">
                      <div class="p-3">
                        <a href="#" class="iq-sub-card pt-0"><i class="ri-settings-3-line"></i> Settings</a>
                        <a href="#" class="iq-sub-card"><i class="ri-hard-drive-line"></i> Get Drive for desktop</a>
                        <a href="#" class="iq-sub-card"><i class="ri-keyboard-line"></i> Keyboard Shortcuts</a>
                      </div>
                    </div>
                  </div>
                </div>
              </li> -->
              <!-- settings :: end -->
              <li class="nav-item nav-icon dropdown" v-header-toggle>
                <a href="#" class="search-toggle dropdown-toggle" id="dropdownMenuButton03" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <div class="caption bg-primary line-height">
                    <img src="@/assets/images/user/i1.jpg" :alt="user?.name" class="avatar-30" />
                  </div>
                </a>
                <div class="iq-sub-dropdown dropdown-menu" aria-labelledby="dropdownMenuButton03">
                  <div class="card mb-0">
                    <div class="card-header d-flex justify-content-between align-items-center mb-0">
                      <div class="header-title">
                        <h4 class="card-title mb-0">Profile</h4>
                      </div>
                      <div class="close-data text-right badge badge-primary cursor-pointer"><i class="ri-close-fill"></i></div>
                    </div>
                    <div class="card-body">
                      <div class="profile-header">
                        <div class="cover-container text-center">
                          <div class="rounded-circle profile-icon bg-primary mx-auto d-block">
                            <img src="@/assets/images/user/i1.jpg" :alt="user?.name" class="avatar-70" />
                          </div>
                          <div class="profile-detail mt-3">
                            <h5>
                              <a href="@/app/user-profile-edit.html">{{ user?.name }}</a>
                            </h5>
                            <p>{{ user?.email }}</p>
                          </div>
                          <button @click="HbLogOutUserAn" class="btn btn-primary">Sign Out</button>
                        </div>
                        <!-- <div class="profile-details mt-4 pt-4 border-top">
                          <div class="media align-items-center mb-3">
                            <div class="rounded-circle iq-card-icon-small bg-primary">A</div>
                            <div class="media-body ml-3">
                              <div class="media justify-content-between">
                                <h6 class="mb-0">Anna Mull</h6>
                                <p class="mb-0 font-size-12"><i>Signed Out</i></p>
                              </div>
                              <p class="mb-0 font-size-12">annamull@gmail.com</p>
                            </div>
                          </div>
                          <div class="media align-items-center mb-3">
                            <div class="rounded-circle iq-card-icon-small bg-success">K</div>
                            <div class="media-body ml-3">
                              <div class="media justify-content-between">
                                <h6 class="mb-0">King Poilin</h6>
                                <p class="mb-0 font-size-12"><i>Signed Out</i></p>
                              </div>
                              <p class="mb-0 font-size-12">kingpoilin@gmail.com</p>
                            </div>
                          </div>
                          <div class="media align-items-center">
                            <div class="rounded-circle iq-card-icon-small bg-danger">D</div>
                            <div class="media-body ml-3">
                              <div class="media justify-content-between">
                                <h6 class="mb-0">Devid Worner</h6>
                                <p class="mb-0 font-size-12"><i>Signed Out</i></p>
                              </div>
                              <p class="mb-0 font-size-12">devidworner@gmail.com</p>
                            </div>
                          </div>
                        </div> -->
                      </div>
                    </div>
                  </div>
                </div>
              </li>
            </ul>
          </b-collapse>
          <div class="header-create-btn align-items-center ml-3">
            <!-- <b-dropdown id="dropdown-1" text="Create New" icon="arrow-up" variant="primary" no-caret>
              <b-dropdown-item @click.prevent="createNewFolderFn"><i class="ri-folder-add-fill"></i>Create Folder</b-dropdown-item>
              <b-dropdown-item><i class="ri-file-fill"></i>Upload File</b-dropdown-item>
              <b-dropdown-item><i class="ri-upload-cloud-fill"></i>Upload Folder</b-dropdown-item>
            </b-dropdown> -->
            <b-button @click.prevent="createNewFolderFn" text="Create New" icon="arrow-up" variant="primary">Create Folder</b-button>
          </div>
        </div>
      </nav>
    </div>
  </div>
</template>
<script lang="js">

import { mapActions, mapGetters } from 'vuex'
export default {

    name: "HeaderStyle1",
    data() {
        return {
            selectedInput: ''
        }
    },
    computed: {
      ...mapGetters({
            user: 'Auth/getCompUser',
            appName: 'appName',
            logo: 'logo',

            name: 'name',
            image1: 'image1'
        }),
      },
      methods: {
      ...mapActions("Auth", ["HbLogOutUserAn"]),
      ...mapActions('Browser', ['createFolderAn', 'searchDocsAn']),
        createNewFolderFn(){
          this.createFolderAn(null).then(res => {
            if(res.status === 200){
              this.$router.push({name: 'drive.filebrowser'});
            }
          });
        },
      },
      watch: {
        selectedInput: function(newValue, oldValue) {
          if(newValue !== oldValue){
            if(this.$route.name !== 'drive.filebrowser'){
              this.$router.push({ name: 'drive.filebrowser' });
            }
            setTimeout(() => {
              this.searchDocsAn(newValue);
            }, 3000);
            // switch(newValue){
            //   case 'pdf':
            //     if(this.$route.name !== 'drive.filebrowser'){
            //       this.$router.push({ name: 'drive.filebrowser' });
            //     }
            //     this.searchDocsAn(newValue);
            //     break;
            //   case 'docx':
            //     if(this.$route.name !== 'drive.filebrowser'){
            //       this.$router.push({ name: 'drive.filebrowser' });
            //     }
            //     this.searchDocsAn(newValue);
            //     break;
            //   case 'xlsx':
            //     if(this.$route.name !== 'drive.filebrowser'){
            //       this.$router.push({ name: 'drive.filebrowser' });
            //     }
            //     this.searchDocsAn(newValue);
            //     break;
            //   case 'pptx':
            //     if(this.$route.name !== 'drive.filebrowser'){
            //       this.$router.push({ name: 'drive.filebrowser' });
            //     }
            //     this.searchDocsAn(newValue);
            //     break;
            //   case 'jpg':
            //     if(this.$route.name !== 'drive.filebrowser'){
            //       this.$router.push({ name: 'drive.filebrowser' });
            //     }
            //     this.searchDocsAn(newValue);
            //     break;
            //   case 'mp4':
            //     if(this.$route.name !== 'drive.filebrowser'){
            //       this.$router.push({ name: 'drive.filebrowser' });
            //     }
            //     this.searchDocsAn(newValue);
            //     break;
            // }
          }
        }
      }


}
</script>
