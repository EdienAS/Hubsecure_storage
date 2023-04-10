import Vue from "vue";
import Vuex from "vuex";
import axios from "axios";
import { saveAs } from "file-saver";

Vue.use(Vuex);

export default {
  namespaced: true,
  state: {
    recentFolders: [],
    sidebarVisible: false,
    rightSideFolderDetail: null,
    rightSideFileDetail: null,
    parent_folder_id: null,
    folder_uuid: null,
    allDocumentsItems: [],
    hbloader: true,
  },
  getters: {
    getHbLoader(state) {
      return state.hbloader;
    },
    getRightSidebar(state) {
      return state.sidebarVisible;
    },
    getRightSideFolderDetail(state) {
      return state.rightSideFolderDetail;
    },
    getRightSideFileDetail(state) {
      return state.rightSideFileDetail;
    },
    getParentFolderId(state) {
      return state.parent_folder_id;
    },
    getFolderUuid(state) {
      return state.folder_uuid;
    },
    getAllDocumentsItems(state) {
      return state.allDocumentsItems;
    },
    getRecentFolders(state) {
      return state.recentFolders;
    },
  },
  mutations: {
    setHbLoader(state, data) {
      state.hbloader = data;
    },
    toggleSidebar(state) {
      state.sidebarVisible = !state.sidebarVisible;
    },
    resetRightSideBar(state, data) {
      state.rightSideFolderDetail = data;
    },
    setRightSideFolderDetail(state, data) {
      state.rightSideFolderDetail = data;
    },
    setRightSideFileDetail(state, data) {
      state.rightSideFileDetail = data;
    },
    setParentFolderId(state, data) {
      state.parent_folder_id = data;
    },
    setFolderUuid(state, data) {
      state.folder_uuid = data;
    },
    setAllDocumentsItemsMn(state, data) {
      state.allDocumentsItems = data;
    },
    deleteFolderByIdMn(state, id) {
      state.allDocumentsItems = state.allDocumentsItems.filter((item) => item.data.uuid !== id);
      state.recentFolders = state.recentFolders.filter((item) => item.data.uuid !== id);
    },
    setRecentFolders(state, data) {
      state.recentFolders = data;
    },
  },
  actions: {
    async createFolderAn({ commit, dispatch, getters }, folder_id) {
      return await new Promise((t, f) => {
        commit("setHbLoader", true);
        axios
          .post(`/folder`, { uuid: "uuid", name: "NewFolder", parent_folder_id: folder_id })
          .then((r) => {
            if (getters.getFolderUuid === null) {
              commit("setHbLoader", false);
              dispatch("getAllDocumentsAn");
              t(r);
            } else {
              dispatch("getDocDetailsAn", getters.getFolderUuid);
              t(r);
            }
          })
          .catch((e) => {
            f(e);
          });
      });
    },
    async updateFolderNameAn({ commit }, payload) {
      return await new Promise((t, f) => {
        axios
          .patch(`/folder/${payload.uuid}`, { _method: "patch", name: payload.newName })
          .then((res) => {
            if (res.status === 200) {
              commit("setHbLoader", false);
              console.log("commit is not defined so logging it", commit);
            } else {
              console.log("something went wrong while renaming folder");
            }
            t();
          })
          .catch((e) => f(e));
      });
    },
    async getRecentFoldersAN({ commit }) {
      return await new Promise((t, f) => {
        commit("setHbLoader", true);
        axios
          .get(`/browse/folders?orderBy=desc&limit=4`)
          .then((res) => {
            commit("setHbLoader", false);
            commit("setRecentFolders", res.data.data.items);
            t();
          })
          .catch((e) => {
            f(e);
          });
      });
    },
    async getAllDocumentsAn({ commit }) {
      return await new Promise((t, f) => {
        commit("setHbLoader", true);
        axios
          .get(`/browse/folders?orderBy=desc`)
          .then((r) => {
            commit("setHbLoader", false);
            // commit("setAllDocumentsRootMn", r.data.data); // 4
            commit("setAllDocumentsItemsMn", r.data.data.items);
            if (r.data.data.meta.root?.data?.uuid !== undefined) {
              commit("setParentFolderId", r.data.data.meta.root);
              commit("setFolderUuid", r.data.data.meta.root.data.uuid);
            } else {
              commit("setParentFolderId", null);
              commit("setFolderUuid", null);
            }
            t(r);
          })
          .catch((e) => {
            f(e);
          });
      });
    },
    async getDocDetailsAn({ commit }, folder_id) {
      return await new Promise((t, f) => {
        commit("setHbLoader", true);
        axios
          .get(`/browse/folders/${folder_id}`)
          .then((r) => {
            commit("setHbLoader", false);
            commit("setFolderUuid", folder_id);
            commit("setAllDocumentsItemsMn", r.data.data.items);
            commit("setParentFolderId", r.data.data.meta.root.data.id);
            t(r);
          })
          .catch((e) => {
            f(e);
          });
      });
    },
    async getSingleFolderDetailsAn({ commit }, folder_uuid) {
      return await new Promise((t, f) => {
        axios
          .get(`/folder/${folder_uuid}`)
          .then((r) => {
            commit("resetRightSideBar", null);
            commit("setRightSideFolderDetail", r.data.data.items);
            t(r);
          })
          .catch((e) => {
            f(e);
          });
      });
    },
    async getSingleFileDetailsAn({ commit }, file_uuid) {
      return await new Promise((t, f) => {
        axios
          .get(`/file/${file_uuid}`)
          .then((r) => {
            commit("resetRightSideBar", null);
            commit("setRightSideFileDetail", r.data.data.items);
            t(r);
          })
          .catch((e) => {
            f(e);
          });
      });
    },
    async getDeletedDocsAn({ commit }) {
      return await new Promise((t, f) => {
        commit("setHbLoader", true);
        axios
          .get(`/browse/trash`)
          .then((r) => {
            commit("setHbLoader", false);
            commit("setAllDocumentsItemsMn", r.data.data.items);
            t(r);
          })
          .catch((e) => {
            f(e);
          });
      });
    },
    async deleteFolderByIdToTrashAn({ commit }, folder_id) {
      return await new Promise((t, f) => {
        axios
          .delete(`/trashfolder/${folder_id}`)
          .then((res) => {
            if (res.status === 204) {
              commit("setHbLoader", false);
              commit("deleteFolderByIdMn", folder_id);
              commit("setHbLoader", false);
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
    async deleteFolderByIdPermanentlyAn({ commit }, payload_id) {
      return await new Promise((t, f) => {
        axios
          .post(`/folder/${payload_id}`, { _method: "delete", force_delete: 1 })
          .then((res) => {
            if (res.status === 204) {
              commit("setHbLoader", false);
              commit("deleteFolderByIdMn", payload_id);
              commit("setHbLoader", false);
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
    async deleteFileByIdToTrash({ commit }, payload_id) {
      return await new Promise((t, f) => {
        axios
          .delete(`/trashfile/${payload_id}`)
          .then((res) => {
            if (res.status === 204) {
              commit("setHbLoader", false);
              commit("deleteFolderByIdMn", payload_id);
              commit("setHbLoader", false);
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
            if (res.status === 204) {
              commit("setHbLoader", false);
              commit("deleteFolderByIdMn", payload_id);
              commit("setHbLoader", false);
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
    async restoreFolderByIdAn({ commit }, folder_uuid) {
      const payload = {
        _method: "patch",
        items: [
          {
            type: "folder",
            uuid: folder_uuid,
          },
        ],
      };
      return await new Promise((t, f) => {
        commit("setHbLoader", true);
        axios
          .post(`/restorefolders`, payload)
          .then((res) => {
            if (res.status === 204) {
              commit("deleteFolderByIdMn", payload.items[0].uuid);
              commit("setHbLoader", false);
              Vue.swal.fire({
                position: "top-center",
                icon: "success",
                title: "Folder restored .!",
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
    async restoreFileByIdAn({ commit }, file_uuid) {
      const payload = {
        _method: "patch",
        items: [
          {
            type: "file",
            uuid: file_uuid,
          },
        ],
      };
      return await new Promise((t, f) => {
        commit("setHbLoader", true);
        axios
          .post(`/restorefiles`, payload)
          .then((res) => {
            if (res.status === 204) {
              commit("setHbLoader", false);
              commit("deleteFolderByIdMn", payload.items[0].uuid);
              Vue.swal.fire({
                position: "top-center",
                icon: "success",
                title: "File restored .!",
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
    async downloadFileById({ commit }, payload) {
      return await new Promise((t, f) => {
        commit("setHbLoader", true);
        console.log("payload", payload);
        axios
          .get(`/getfile/${payload.base_name}`, { responseType: "blob" })
          .then((res) => {
            commit("setHbLoader", false);
            const url = window.URL.createObjectURL(new Blob([res.data]));
            const link = document.createElement("a");
            link.href = url;
            link.setAttribute("download", payload.file_name);
            document.body.appendChild(link);
            link.click();
            t(res);
          })
          .catch((e) => {
            console.log("e", e);
            f(e);
          });
      });
    },
    async downloadFolderByIdAn({ commit }, folder_uuid) {
      return await new Promise((t, f) => {
        commit("setHbLoader", true);
        axios
          .get(`/getfolder/${folder_uuid}`, { responseType: "arraybuffer" })
          .then((response) => {
            const blob = new File([response.data], { type: response.headers["content-type"] });
            saveAs(blob, "folder.zip");
            commit("setHbLoader", false);
            t(response);
          })
          .catch((e) => {
            console.log("e", e);
            f(e);
          });
      });
    },
    async searchDocsAn({ commit }, searchFileType) {
      return await new Promise((t, f) => {
        commit("setHbLoader", true);
        axios
          .get(`/search?query=${searchFileType}`)
          .then((res) => {
            if (res.status === 200) {
              commit("setHbLoader", false);
              commit("setAllDocumentsItemsMn", res.data.data.items);
            }
            t(res);
          })
          .catch((e) => {
            console.log("e", e);
            f(e);
          });
      });
    },
  },
};
