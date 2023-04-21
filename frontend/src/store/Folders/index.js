import Vue from "vue";
import Vuex from "vuex";
import axios from "axios";
import store from "@/store";

Vue.use(Vuex);

export default {
  namespaced: true,
  state: {
    recentFolders: [],
  },
  getters: {
    getRecentFolders(state) {
      return state.recentFolders;
    },
  },
  mutations: {
    setRecentFolders(state, data) {
      state.recentFolders = data;
    },
    deleteFolderById(state, id) {
      state.recentFolders = state.recentFolders.filter((folder) => folder.data.uuid !== id);
      this.dispatch("Folders/fetchRecentFoldersAn");
    },
    deleteFolderByIdPermanentlyMn(state, id) {
      state.recentFolders = state.recentFolders.filter((folder) => folder.data.uuid !== id);
      this.dispatch("Folders/fetchRecentFoldersAn");
    },
  },
  actions: {
    async fetchRecentFoldersAn({ commit }) {
      return await new Promise((t, f) => {
        store.commit("Browser/setHbLoader", true, { root: true });
        axios
          .get(`/folders?orderBy=desc&limit=4`)
          .then((res) => {
            commit("setRecentFolders", res.data.data.items);
            store.commit("Browser/setHbLoader", false, { root: true });
            t();
          })
          .catch((e) => {
            f(e);
          });
      });
    },
    async deleteFolderByIdToTrash({ commit }, payload_id) {
      return await new Promise((t, f) => {
        axios
          .delete(`/trashfolder/${payload_id}`)
          .then((res) => {
            if (res.status === 204) {
              commit("deleteFolderById", payload_id);
              store.commit("Browser/setHbLoader", false, { root: true });
              Vue.swal.fire({
                position: "top-center",
                icon: "success",
                title: "Folder moved to trash .!",
                showConfirmButton: false,
                timer: 1500,
              });

              t();
            }
          })
          .catch((e) => f(e));
      });
    },
    async deleteFolderByIdPermanently({ commit }, payload_id) {
      return await new Promise((t, f) => {
        axios
          .post(`/folder/${payload_id}`, { _method: "delete", force_delete: 1 })
          .then((res) => {
            console.log("deleteFolderByIdPermenently 204? ", res);
            if (res.status === 204) {
              commit("deleteFolderByIdPermanentlyMn", payload_id);
              commit("deleteFolderById", payload_id);
              store.commit("Browser/setHbLoader", false, { root: true });
              Vue.swal.fire({
                position: "top-center",
                icon: "success",
                title: "Folder deleted succssfully .!",
                showConfirmButton: false,
                timer: 1500,
              });
              t();
            }
          })
          .catch((e) => {
            f(e);
          });
      });
    },
  },
};
