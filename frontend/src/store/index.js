import Vue from "vue";
import Vuex from "vuex";
import Todo from "@/store/Todo";
import Auth from "@/store/Auth";
import Files from "@/store/Files";
import Folders from "@/store/Folders";
import Traffic from "@/store/Traffic";
import Browser from "@/store/Browser";
import Share from "@/store/Share";

import createPersistedState from "vuex-persistedstate";

const folderState = createPersistedState({
  paths: ["Browser.parent_folder_id", "Browser.folder_uuid", "Share.shareDataDetails"],
});

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    appName: "HubSecure",
    logo: require("../assets/images/logo.svg"),
    darklogo: require("../assets/images/logo-white.svg"),
    dark: false,
    namespaced: true,
    user: {
      name: "Bill Yerds",
      image: require("@/assets/images/user/1.jpg"),
    },
  },
  mutations: {
    layoutModeCommit(state, payload) {
      state.dark = payload;
      if (!payload) {
        state.logo = require("../assets/images/logo.svg");
      } else {
        state.logo = require("../assets/images/logo-white.svg");
      }
    },
  },
  actions: {
    layoutModeAction(context, payload) {
      context.commit("layoutModeCommit", payload.dark);
    },
  },
  getters: {
    appName: (state) => {
      return state.appName;
    },
    logo: (state) => {
      return state.logo;
    },
    darklogo: (state) => {
      return state.darklogo;
    },
    image1: (state) => {
      return state.user.image;
    },
    name: (state) => {
      return state.user.name;
    },
    image2: (state) => {
      return state.user.image2;
    },
    image3: (state) => {
      return state.user.image3;
    },
    dark: (state) => {
      return state.dark;
    },
  },
  modules: {
    Todo,
    Auth,
    Files,
    Folders,
    Traffic,
    Browser,
    Share,
  },
  plugins: [folderState],
});
