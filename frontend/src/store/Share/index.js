import Vue from "vue";
import Vuex from "vuex";
import axios from "axios";

Vue.use(Vuex);

export default {
  namespaced: true,
  state: {
    shareDataResponse: {},
    shareDataDetails: {},
  },
  getters: {
    getShareDataResponse(state) {
      return state.shareDataResponse;
    },
    getShareDataDetails(state) {
      return state.shareDataDetails;
    },
  },
  mutations: {
    setShareDataResponse(state, data) {
      state.shareDataResponse = data;
    },
    setShareDataDetails(state, data) {
      state.shareDataDetails = data;
    },
    resetShareDataDetails(state) {
      state.shareDataResponse = {};
    },
  },
  actions: {
    async shareFolderByIdAn({ commit }, payload) {
      return await new Promise((t, f) => {
        axios
          .post(`/share`, payload)
          .then((res) => {
            console.log("res", res.data);
            commit("setShareDataResponse", res.data);
            t(res);
          })
          .catch((e) => {
            f(e);
          });
      });
    },

    async fetchShareDetailsAn({ commit }, token) {
      return await new Promise((t, f) => {
        axios
          .get(`/sharing/${token}`)
          .then((res) => {
            commit("setShareDataDetails", res.data);
            t(res);
          })
          .catch((e) => {
            f(e);
          });
      });
    },

    async updateShareDetailsAn({ commit }, payload) {
      return await new Promise((t, f) => {
        axios
          .post(`/share/${payload.token}`, payload.data)
          .then((res) => {
            commit("setShareDataDetails", res.data);
            t(res);
          })
          .catch((e) => {
            f(e);
          });
      });
    },

    async deleteShareAn({ commit }, payload) {
      return await new Promise((t, f) => {
        axios
          .post(`/share`, payload)
          .then((res) => {
            console.log("commit", commit);
            console.log("res", res);
            t(res);
          })
          .catch((e) => {
            f(e);
          });
      });
    },

    async fetchShareDetailsWithoutPassword({ commit }, token) {
      return await new Promise((t, f) => {
        axios
          .get(`/sharing/item/${token}`)
          .then((res) => {
            commit("setShareDataDetails", res.data);
            t(res);
          })
          .catch((e) => {
            f(e);
          });
      });
    },

    async fetchShareDetailsWithPassword({ commit }, token) {
      return await new Promise((t, f) => {
        axios
          .get(`/sharing/item/${token}`, { withCredentials: true })
          .then((res) => {
            commit("setShareDataDetails", res.data);
            t(res);
          })
          .catch((e) => {
            f(e);
          });
      });
    },
  },
};
