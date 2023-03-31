import Vue from "vue";
import Vuex from "vuex";
import axios from "axios";

Vue.use(Vuex);

export default {
  namespaced: true,
  state: {
    recentFiles: [],
  },
  getters: {
    getRecentFiles(state) {
      return state.recentFiles;
    },
  },
  mutations: {
    setRecentFiles(state, data) {
      state.recentFiles = data;
    },
    deleteFileById(state, id) {
      state.recentFiles = state.recentFiles.filter((file) => file.data.uuid !== id);
      this.dispatch("Files/fetchRecentFilesAn");
    },
    deleteFileByIdPermanentlyMn(state, id) {
      state.recentFiles = state.recentFiles.filter((file) => file.data.uuid !== id);
      this.dispatch("Files/fetchRecentFilesAn");
    },
  },
  actions: {
    async fetchRecentFilesAn({ commit }) {
      return await new Promise((t, f) => {
        axios
          .get("/files?orderBy=desc&limit=4")
          .then((res) => {
            commit("setRecentFiles", res.data.data.items);
          })
          .catch((e) => {
            f(e);
          });
      });
    },
    async deleteFileByIdToTrash({ commit }, payload_id) {
      return await new Promise((t, f) => {
        axios
          .delete(`/trashfile/${payload_id}`)
          .then((res) => {
            if (res.status === 204) {
              commit("deleteFileById", payload_id);

              Vue.swal.fire({
                position: "top-center",
                icon: "success",
                title: "File moved to trash .!",
                showConfirmButton: false,
                timer: 1500,
              });

              t();
            }
          })
          .catch((e) => f(e));
      });
    },
    async deleteFileByIdPermanently({ commit }, payload_id) {
      return await new Promise((t, f) => {
        axios
          .post(`/file/${payload_id}`, { _method: "delete", force_delete: 1 })
          .then((res) => {
            console.log("deleteFileByIdPermenently 204? ", res);
            if (res.status === 204) {
              commit("deleteFileByIdPermanentlyMn", payload_id);
              commit("deleteFileById", payload_id);
              Vue.swal.fire({
                position: "top-center",
                icon: "success",
                title: "File deleted succssfully .!",
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
