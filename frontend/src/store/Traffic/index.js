import Vue from "vue";
import Vuex from "vuex";
import axios from "axios";
import Browser from "@/store/Browser";
import store from "@/store";

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
        store.commit("Browser/setHbLoader", true, { root: true });
        axios
          .get(`/traffic/${user_id}?duration=month&limit=12`)
          .then((res) => {
            commit("setFileTraffic", res.data.data);
            store.commit("Browser/setHbLoader", false, { root: true });
            t();
          })
          .catch((e) => {
            f(e);
          });
      });
    },
  },
  modules: {
    Browser,
  },
};
