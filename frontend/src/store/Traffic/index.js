import Vue from "vue";
import Vuex from "vuex";
import axios from "axios";

Vue.use(Vuex);

export default {
  namespaced: true,
  state: {
    fileTraffic: null,
  },
  getters: {
    getFileTraffic(state) {
      return state.fileTraffic;
    },
  },
  mutations: {
    setFileTraffic(state, data) {
      state.fileTraffic = data;
    },
  },
  actions: {
    async fetchAllUploadedFilesSize({ commit }, user_id) {
      return await new Promise((t, f) => {
        axios
          .get(`/traffic/${user_id}?duration=month&limit=12`)
          .then((res) => {
            commit("setFileTraffic", res.data.data);
            t();
          })
          .catch((e) => {
            f(e);
          });
      });
    },
  },
};
