<template>
  <div class="iq-sidebar sidebar-default">
    <div class="iq-sidebar-logo d-flex align-items-center justify-content-between">
      <router-link :to="{ name: 'layout.dashboard' }" class="header-logo">
        <img :src="logo" class="img-fluid rounded-normal" alt="logo" />
      </router-link>
      <div class="iq-menu-bt-sidebar">
        <i class="las la-bars wrapper-menu"></i>
      </div>
    </div>
    <div class="data-scrollbar" data-scroll="1" id="sidebar-scrollbar">
      <!-- <div class="new-create select-dropdown input-prepend input-append">
        <div class="btn-group">
          <b-dropdown id="dropdownMenuButton1" right variant="none p-0" data-toggle="dropdown" class="dropdown shadow-none" no-caret>
            <template v-slot:button-content>
              <div class="search-query selet-caption"><i class="las la-plus pr-1"></i>Create New</div>
              <span class="search-replace"></span>
              <span class="caret"></span>
            </template>
            <b-dropdown-item><i class="ri-folder-add-line pr-3"></i>{{ "New Folder" }} </b-dropdown-item>
            <b-dropdown-item><i class="ri-file-upload-line pr-3"></i>{{ "Upload Files" }}</b-dropdown-item>
            <b-dropdown-item><i class="ri-folder-upload-line pr-3"></i>{{ "Upload Folders" }}</b-dropdown-item>
          </b-dropdown>
        </div>
      </div> -->
      <div class="new-create select-dropdown input-prepend input-append" v-sidebar-toggle>
        <div class="btn-group">
          <label class="iq-user-toggle" @click="$router.push({ name: 'layout.files' })">
            <div class="search-query selet-caption"><i class="las la-plus pr-2"></i>Upload</div>
            <span class="search-replace"></span>
            <span class="caret"></span>
          </label>
          <!-- <ul class="dropdown-menu">
            <li>
              <div class="item"><i class="ri-folder-add-line pr-3"></i>New Folder</div>
            </li>
            <li>
              <div class="item"><i class="ri-file-upload-line pr-3"></i>Upload Files</div>
            </li>
            <li>
              <div class="item"><i class="ri-folder-upload-line pr-3"></i>Upload Folders</div>
            </li>
          </ul> -->
        </div>
      </div>
      <nav class="iq-sidebar-menu">
        <CollapseMenu :items="sidebarItems" :open="true" />
      </nav>
      <!-- sidebarBottom :: start -->
      <!-- <div class="sidebar-bottom">
        <h4 class="mb-3"><i class="las la-cloud mr-2"></i>Storage</h4>
        <p>{{ (fileTraffic?.total_uploaded / (1024 * 1024)).toPrecision(4) }} GB / {{ (fileTraffic?.total_storage / (1024 * 1024)).toPrecision(4) }} GB Used</p>
        <b-progress color="primary" :value="parseInt(fileTraffic?.total_uploaded_percent)" :max="100" variant="primary"></b-progress>
        <p>
          <small>{{ fileTraffic?.total_uploaded_percent }}% Full - {{ ((fileTraffic?.total_storage - fileTraffic?.total_uploaded) / (1024 * 1024)).toPrecision(4) }} GB Free</small>
        </p>
        <button href="#" disabled class="btn btn-primary view-more mt-4">Buy Storage</button>
      </div> -->
      <!-- sidebarBottom :: end -->
      <div class="p-3"></div>
    </div>
  </div>
</template>
<script lang="js">
import CollapseMenu from "@/components/menustyle/CollapseMenu";
import sideBarItem from "@/JsonData/sidebar.json"
import { mapGetters, mapActions } from 'vuex'
import {core} from '@/config/pluginInit'
export default {
  name:"SidebarStyle",
  data () {
    return{
      homeurl:'',
      sidebarItems:sideBarItem,
    }
  },
  mounted () {
    core.SmoothScrollbar();
    core.changesidebar();
  },
  destroyed () {
    core.SmoothScrollbar()
    core.changesidebar()
  },
  components:{
    CollapseMenu
  },
  computed: {
  ...mapGetters({
      appName: 'appName',
      logo:'logo',
      fileTraffic: 'Traffic/getFileTraffic',
      loggedInUser: 'Auth/getCompUser'
    })
  },
  methods: {
    ...mapActions("Traffic", ["fetchAllUploadedFilesSize"]),
  },
  created(){
    this.fetchAllUploadedFilesSize(this.loggedInUser.uuid)
  }
}
</script>
