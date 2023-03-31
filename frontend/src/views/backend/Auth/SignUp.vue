<template>
  <section class="login-content" v-if="signUpToggle">
    <div class="container h-100">
      <div class="row justify-content-center align-items-center height-self-center">
        <div class="col-md-5 col-sm-12 col-12 align-self-center">
          <div class="sign-user_card">
            <img src="@/assets/images/logo.png" class="img-fluid rounded-normal light-logo logo" alt="logo" />
            <h3 class="mb-3">Sign Up</h3>
            <form @submit.prevent="registerHandler">
              <div class="row">
                <!-- name :: start -->
                <div class="col-lg-12">
                  <div for="name" class="floating-label form-group">
                    <input class="floating-input form-control" id="name" name="name" type="name" v-model="values.name" placeholder=" " @blur="validate('name')" @keypress="validate('name')" />
                    <label>Name</label>
                  </div>
                  <p class="form-input-hint text-danger text-left" v-if="errors.name">{{ errors.name }}</p>
                </div>
                <!-- name :: end -->

                <!-- email :: start -->
                <div class="col-lg-12">
                  <div for="email" class="floating-label form-group">
                    <input class="floating-input form-control" id="email" name="email" type="email" v-model="values.email" placeholder=" " @blur="validate('email')" @keypress="validate('email')" />
                    <label>Email</label>
                  </div>
                  <p class="form-input-hint text-danger text-left" v-if="errors.email">{{ errors.email }}</p>
                </div>
                <!-- email :: end -->

                <!-- password :: start -->
                <div class="col-lg-12">
                  <div for="password" class="floating-label form-group">
                    <input class="floating-input form-control" id="password" name="password" type="password" v-model="values.password" placeholder=" " @blur="validate('password')" @keypress="validate('password')" />
                    <label>Password</label>
                  </div>
                  <p class="form-input-hint text-danger text-left" v-if="errors.password">{{ errors.password }}</p>
                </div>
                <!-- password :: end -->
              </div>
              <button type="submit" class="btn btn-primary">Sign Up</button>
              <p class="mt-3">Already have an Account <router-link :to="{ name: 'auth.login' }" class="text-primary">Sign In</router-link></p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script lang="js">
import * as yup from "yup";
import { mapActions } from 'vuex';

const registerFormSchema = yup.object({
  name: yup.string().required(),
  email: yup
    .string()
    .required()
    .email(),
  password: yup.string().required(),
});

export default {
  name: "SignUp",
  data() {
    return {
      values: {
        name: "",
        email: "",
        password: "",
      },
      errors: {
        name: "",
        email: "",
        password: "",
      },
      signUpToggle: true
    };
  },
  methods: {
    ...mapActions("Auth", ["HbRegisterUserAn", "HbLogOutUserAn"]),
    registerHandler() {
      registerFormSchema
        .validate(this.values, { abortEarly: false })
        .then(() => {
          this.errors = {};
          const payload = {
            ...this.values, uuid: 'uuid', role_id: 2
          }
          this.HbRegisterUserAn(payload);
        })
        .catch((err) => {
          err.inner.forEach((error) => {
            this.errors[error.path] = error.message;
          });
        });
    },
    validate(field) {
      registerFormSchema
        .validateAt(field, this.values)
        .then(() => {
          this.errors[field] = "";
        })
        .catch((err) => {
          this.errors[field] = err.message;
        });
    },
  },
  created() {
    if (this.$store.getters['Auth/getCompUser'] !== null && this.$route.path === '/auth/sign-up') {
      this.signUpToggle = false
      this.$router.push({ name: 'layout.dashboard' })
    }
  }
};
</script>
