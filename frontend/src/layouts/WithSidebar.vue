<template>
  <div>
    <!-- <Loader /> -->
    <div class="wrapper">
      <SidebarStyle />
      <HeaderStyle1 />
      <div class="content-page">
        <transition name="router-anim">
          <router-view />
        </transition>
      </div>
    </div>
    <FooterStyle />
    <ViewerModal />
  </div>
</template>

<script lang="js">
// import Loader from "@/components/loader/Loader";
import SidebarStyle from "@/components/partials/backend/SidebarStyle/SidebarStyle";
import HeaderStyle1 from "@/components/partials/backend/HeaderStyle/HeaderStyle1";
import FooterStyle from "@/components/partials/backend/FooterStyle/FooterStyle";
import ViewerModal from "@/components/viewer-modal/ViewerModal";
import { core } from "@/config/pluginInit";
export default {
  name: "Layout-2",
  components: {
    HeaderStyle1,
    FooterStyle,
    SidebarStyle,
    // Loader,
    ViewerModal,
  },
  mounted() {
    document.body.classList = "";
    setTimeout(() => {
      core.verticalImagePopup();
    }, 2000);
  },
  destroyed() {
    document.body.classList = "";
  },
};
</script>
<style></style>
