import Vue from "vue";
import Vuex from "vuex";
import Axios from "axios";
import axios from "axios";

import router from "../../router";

Vue.use(Vuex);

export default {
  namespaced: true,
  state: {
    user: {},
    token: null,
    userDetails: {},
    uuid: null,
  },
  getters: {
    getCompToken(state) {
      if (Vue.$cookies.get("auth_token") !== "" || Vue.$cookies.get("auth_token") !== null) {
        state.token = Vue.$cookies.get("auth_token");
        Axios.defaults.headers.common["Authorization"] = `Bearer ${state.token}`;
        return state.token;
      }
    },
    getCompUser(state) {
      if (Vue.$cookies.get("auth_user") !== "" || Vue.$cookies.get("auth_user") !== null) {
        state.user = Vue.$cookies.get("auth_user");
        return state.user;
      }
    },
    getUserDetails(state) {
      return state.userDetails;
    },
    getUserUUID(state) {
      if (Vue.$cookies.get("auth_user_uuid") !== "" || Vue.$cookies.get("auth_user_uuid") !== null) {
        state.uuid = Vue.$cookies.get("auth_user_uuid");
        return state.uuid;
      }
      return state.uuid;
    },
  },
  mutations: {
    HbSetToken(state, data) {
      Vue.$cookies.set("auth_token", data);
      state.token = data;
    },
    HbRemoveToken(state, data) {
      Vue.$cookies.remove("auth_token", data);
      state.token = data;
    },
    HbSetUserMn(state, data) {
      Vue.$cookies.set("auth_user", data);
      state.user = data;
    },
    HbRemoveUserMn(state, data) {
      Vue.$cookies.remove("auth_user");
      state.user = data;
    },
    HbSetUserDetails(state, data) {
      state.userDetails = data;
    },
    HbSetUUID(state, data) {
      Vue.$cookies.set("auth_user_uuid", data);
      state.uuid = data;
    },
  },
  actions: {
    HbLogInUserAn({ commit }, payload) {
      return new Promise((resolve, reject) => {
        axios
          .post(`${process.env.VUE_APP_BACKEND_URL}/login`, payload)
          .then((res) => {
            commit("HbSetUserMn", res.data.data);
            commit("HbSetToken", res.data.data.token);
            commit("HbSetUUID", res.data.data.uuid);
            Vue.swal
              .fire({
                position: "top-center",
                icon: "success",
                title: "SignIn Success",
                showConfirmButton: false,
                timer: 1500,
              })
              .then(() => {
                router.push({ name: "layout.dashboard" });
              });

            resolve(res);
          })
          .catch((e) => {
            console.log("e", e);
            Vue.swal
              .fire({
                position: "top-center",
                icon: "error",
                title: e.response.data.message,
                showConfirmButton: false,
                timer: 1500,
              })
              .then(() => {
                router.push({ name: "layout.dashboard" });
              });
            reject(e);
          });
      });
    },
    HbRegisterUserAn({ commit }, payload) {
      return new Promise((resolve, reject) => {
        axios
          .post(`${process.env.VUE_APP_BACKEND_URL}/user/register`, payload)
          .then((res) => {
            commit("HbSetUserMn", res.data.data);
            commit("HbSetToken", res.data.data.token);

            Vue.swal
              .fire({
                position: "top-center",
                icon: "success",
                title: "SignUp Success",
                showConfirmButton: false,
                timer: 1500,
              })
              .then(() => {
                router.push({ name: "layout.dashboard" });
              });

            resolve(res);
          })
          .catch((e) => {
            console.log("e", e);
            Vue.swal
              .fire({
                position: "top-center",
                icon: "error",
                title: e.response.data.message,
                showConfirmButton: false,
                timer: 1500,
              })
              .then(() => {
                router.push({ name: "layout.dashboard" });
              });
            reject(e);
          });
      });
    },
    HbLogOutUserAn({ commit }) {
      return new Promise((resolve, reject) => {
        axios
          .post(`${process.env.VUE_APP_BACKEND_URL}/logout`)
          .then((res) => {
            if (res.status === 204) {
              commit("HbRemoveUserMn", "");
              commit("HbRemoveToken", "");
              commit("HbSetUUID", "");
              Vue.swal
                .fire({
                  position: "top-center",
                  icon: "success",
                  title: "SignOut Success .!",
                  showConfirmButton: false,
                  timer: 1500,
                })
                .then(() => {
                  router.push({ name: "auth.login" });
                });
              resolve(res);
            }
          })
          .catch((e) => {
            reject(e);
          });
      });
    },
    HbGetLoggedInUserAn({ commit }) {
      if (Vue.$cookies.get("auth_user_uuid") !== "" && Vue.$cookies.get("auth_user_uuid") !== null) {
        var user_uuid = Vue.$cookies.get("auth_user_uuid");
      }
      return new Promise((resolve, reject) => {
        axios
          .get(`${process.env.VUE_APP_BACKEND_URL}/user/${user_uuid}`)
          .then((res) => {
            commit("HbSetUserDetails", res.data.data[0].data);
            resolve(res);
          })
          .catch((e) => {
            reject(e);
          });
      });
    },
    HbSetNewPassword({ commit }, payload) {
      if (Vue.$cookies.get("auth_user_uuid") !== "" && Vue.$cookies.get("auth_user_uuid") !== null) {
        var user_uuid2 = Vue.$cookies.get("auth_user_uuid");
      }
      return new Promise((resolve, reject) => {
        axios
          .post(`${process.env.VUE_APP_BACKEND_URL}/user/${user_uuid2}`, payload)
          .then((res) => {
            commit("HbRemoveUserMn", "");
            commit("HbRemoveToken", "");
            commit("HbSetUUID", "");
            Vue.swal
              .fire({
                position: "top-center",
                icon: "success",
                title: "Password Reset Success .!",
                showConfirmButton: false,
                timer: 1500,
              })
              .then(() => {
                router.push({ name: "auth.login" });
              });
            resolve(res);
          })
          .catch((e) => {
            reject(e);
          });
      });
    },
    HbChangeAvatar({ commit }, payload) {
      if (Vue.$cookies.get("auth_user_uuid") !== "" && Vue.$cookies.get("auth_user_uuid") !== null) {
        var user_uuid3 = Vue.$cookies.get("auth_user_uuid");
      }
      return new Promise((resolve, reject) => {
        axios
          .post(`${process.env.VUE_APP_BACKEND_URL}/usersettings/${user_uuid3}`, payload)
          .then((res) => {
            console.log("commit", commit);
            if (res.status === 204) {
              Vue.swal.fire({
                position: "top-center",
                icon: "success",
                title: "Profile Image Changed .!",
                showConfirmButton: false,
                timer: 1500,
              });
              resolve(res);
            }
          })
          .catch((e) => {
            reject(e);
          });
      });
    },
  },
};
