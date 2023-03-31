<template>
  <div>
    <div v-if="!getShareDataResponse?.data?.items[0]?.data?.attributes?.token">
      <form class="d-block text-center">
        <!-- folderType :: start -->
        <b-list-group-item v-if="fc.type === 'folder'" class="d-flex align-items-center">
          <b-avatar style="background-color: white !important" src="https://api.iconify.design/ri:folder-shared-fill.svg" size="3rem" class="mr-3" square rounded="lg"></b-avatar>
          <div>
            <strong
              ><span class="d-flex">{{ fc.name }}</span></strong
            >
            <div class="d-flex">
              <span> 0 Folders, </span>
              <span> {{ fc.items }} Files </span>
            </div>
          </div>
        </b-list-group-item>
        <!-- folderType :: end -->

        <!-- fileType :: start -->
        <b-list-group-item v-if="fc.type === 'file'" class="d-flex align-items-center">
          <b-avatar style="background-color: white !important" src="https://api.iconify.design/uil:file-share-alt.svg" size="3rem" class="mr-3" square rounded="lg"></b-avatar>
          <div>
            <strong
              ><span class="d-flex">{{ fc.name }}</span></strong
            >
          </div>
        </b-list-group-item>
        <!-- fileType :: end -->

        <!-- permission :: start -->
        <div class="mx-auto">
          <p class="text-left">Permission:</p>
          <b-form-select v-model="permission" class="mb-3">
            <b-form-select-option value="null" disabled>Please select an option</b-form-select-option>
            <b-form-select-option value="visitor">Can only view and download</b-form-select-option>
            <b-form-select-option value="editor">Can edit and upload files</b-form-select-option>
          </b-form-select>
          <p v-if="errors.permission" class="myerror">{{ errors.permission }}</p>
        </div>
        <!-- permission :: end -->

        <!-- passwordProtected :: start -->
        <div class="mx-auto my-4">
          <p class="text-left">Password Protected:</p>
          <div class="d-flex justify-content-between align-items-center">
            <small>Protect your item by your custom password.</small>
            <b-form-checkbox size="lg" v-model="togglePasswordBtn" name="check-button" switch></b-form-checkbox>
          </div>
          <div v-if="togglePasswordBtn" class="mt-3">
            <div class="d-flex justify-content-around">
              <b-form-input id="password" type="password" name="password" v-model="password" placeholder="Type your password" autofocus></b-form-input>
            </div>
            <p v-if="errors.password" class="myerror">{{ errors.password }}</p>
          </div>
        </div>
        <!-- passwordProtected :: end -->

        <!-- expiration :: start -->
        <div class="mx-auto">
          <p class="text-left">Expiration:</p>
          <div class="d-flex justify-content-between align-items-center">
            <small>Your link expire after exact period of time.</small>
            <b-form-checkbox size="lg" v-model="toggleExpirationBtn" name="check-button" switch></b-form-checkbox>
          </div>
          <div v-if="toggleExpirationBtn" class="mt-3">
            <div class="d-flex justify-content-around">
              <b-form-radio-group v-model="expiration" :options="expiryOptions" class="mb-3" type="btn" value-field="item" text-field="name"></b-form-radio-group>
            </div>
            <p v-if="errors.expiration" class="myerror">{{ errors.expiration }}</p>
          </div>
        </div>
        <!-- expiration :: end -->

        <!-- sendLinkByEmail :: start -->
        <div class="mx-auto my-4">
          <p class="text-left">Send link by Email:</p>
          <div class="d-flex justify-content-between align-items-center">
            <small>Send your share link via email to many recipients.</small>
            <b-form-checkbox size="lg" v-model="toggleEmailBtn" name="check-button" switch></b-form-checkbox>
          </div>
          <div v-if="toggleEmailBtn" class="mt-3">
            <div class="d-flex justify-content-around">
              <b-form-tags input-id="tags-basic" v-model="emails" placeholder="Type your email"></b-form-tags>
            </div>
            <p v-if="errors.emails" class="myerror">{{ errors.emails }}</p>
          </div>
        </div>
        <!-- sendLinkByEmail :: end -->

        <!-- ctaButtons :: start -->
        <div class="d-flex justify-content-around my-4">
          <b-button class="btn btn-info w-100 mx-2" @click.prevent="$emit('close')">Cancel</b-button>
          <b-button type="submit" class="btn btn-success w-100 mx-2" @click.prevent="shareFolderSubmit">Generate Link</b-button>
        </div>
        <!-- ctaButtons :: end -->
      </form>
    </div>
    <div v-else>
      <p><i class="ri-share-forward-box-fill"></i> <b>Share your folder</b></p>
      <div>
        <p>Get your link</p>
        <input style="width: 100%" type="text" ref="sharelink" v-model="getShareDataResponse.data.items[0].data.attributes.link" />
      </div>
      <div class="d-flex justify-content-between my-3">
        <button class="btn btn-success" @click.prevent="copyToClipboard(getShareDataResponse.data.items[0].data.attributes.link)">Copy Link To Clipboard</button>
        <button class="btn btn-danger" @click.prevent="$emit('close')">close</button>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";

export default {
  name: "HbShareModal",
  props: {
    fc: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      uuid: "",
      type: "",
      emails: [],
      permission: null,
      password: "",
      expiration: "",
      isTokenGenerated: false,

      expiryOptions: [
        { item: "1", name: "1hr" },
        { item: "2", name: "2hr" },
        { item: "3", name: "3hr" },
      ],

      togglePasswordBtn: false,
      toggleExpirationBtn: false,
      toggleEmailBtn: false,
      errors: {},
    };
  },
  computed: {
    ...mapGetters("Share", ["getShareDataResponse"]),
  },
  methods: {
    ...mapActions("Share", ["shareFolderByIdAn"]),

    copyToClipboard(text) {
      navigator.clipboard.writeText(text);
    },

    shareFolderSubmit() {
      const payload = {};

      if (this.permission !== null) {
        this.errors.permission = "";
        payload.permission = this.permission;
        payload.uuid = "uuid";
        payload.item_uuid = this.$options?.propsData?.fc?.uuid;
        payload.type = this.$options?.propsData?.fc?.type;
      } else {
        this.errors.permission = "Required";
      }

      if (this.togglePasswordBtn && this.password !== "") {
        this.errors.password = "";
        payload.password = this.password;
        payload.isPassword = 1;
      } else {
        this.errors.password = "Password Required";
      }

      if (this.toggleExpirationBtn && this.expiration !== "") {
        this.errors.expiration = "";
        payload.expiration = this.expiration;
      } else {
        this.errors.expiration = "Expiration Required";
      }

      if (this.toggleEmailBtn && this.emails !== []) {
        this.errors.emails = "";
        payload.emails = this.emails;
      } else {
        this.errors.emails = "Emails Required";
      }

      if (this.permission) {
        this.shareFolderByIdAn(payload);
      }
    },
  },
};
</script>

<style>
.myerror {
  color: red !important;
  text-align: left;
}
</style>
