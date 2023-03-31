<template>
  <section class="login-content" v-if="signInToggle">
    <div class="container h-100">
      <div class="row justify-content-center align-items-center height-self-center">
        <div class="col-md-5 col-sm-12 col-12 align-self-center">
          <div class="sign-user_card">
            <img src="@/assets/images/logo.png" class="img-fluid rounded-normal light-logo logo" alt="logo" />

            <h3 class="mb-3">Sign In</h3>
            <form @submit.prevent="loginHandler()">
              <div class="row">
                <div class="col-lg-12">
                  <div class="floating-label form-group">
                    <input name="email" id="email" type="email" v-model="values.email" class="floating-input form-control" placeholder=" " @blur="validate('email')" @keypress="validate('email')" />
                    <label>Email</label>
                  </div>
                  <span class="form-input-hint text-danger text-left" v-if="errors.email"> {{ errors.email }}</span>
                </div>
                <div class="col-lg-12">
                  <div class="floating-label form-group">
                    <input name="password" id="password" type="password" v-model="values.password" class="floating-input form-control" placeholder=" " @blur="validate('password')" @keypress="validate('password')" />
                    <label>Password</label>
                  </div>
                  <span class="form-input-hint text-danger text-left" v-if="errors.password"> {{ errors.password }}</span>
                </div>
                <div class="col-lg-6">
                  <div class="custom-control custom-checkbox mb-3 text-left">
                    <input type="checkbox" class="custom-control-input" id="customCheck1" />
                    <label class="custom-control-label" for="customCheck1">Remember Me</label>
                  </div>
                </div>
                <div class="col-lg-6">
                  <router-link :to="{ name: 'auth.recover-password' }" class="text-primary float-right">Forgot Password?</router-link>
                </div>
              </div>
              <button type="submit" class="btn btn-primary">Sign In</button>
              <p class="mt-3">Create an Account <router-link :to="{ name: 'auth.register' }" class="text-primary">Sign Up</router-link></p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script lang="js">
import * as yup from "yup";
import { mapGetters, mapActions } from "vuex";

const loginFormSchema = yup.object({
  email: yup
    .string()
    .required()
    .email(),
  password: yup.string().required(),
});

export default {
  name: "SignIn",
  data() {
    return {
      values: {
        email: "",
        password: "",
      },
      errors: {
        email: "",
        password: "",
      },
      signInToggle: true
    };
  },
  computed: {
    ...mapGetters("Auth", ["getCompUser"]),
  },
  methods: {
    ...mapActions("Auth", ["HbLogInUserAn", "HbLogOutUserAn"]),
    loginHandler() {
      loginFormSchema
        .validate(this.values, { abortEarly: false })
        .then(() => {
          this.errors = {};
          this.HbLogInUserAn(this.values)
        })
        .catch((err) => {
          err.inner.forEach((error) => {
            this.errors[error.path] = error.message;
          });
        });
    },
    validate(field) {
      loginFormSchema
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
    if (this.$store.getters['Auth/getCompUser'] !== null && this.$route.path === '/auth/sign-in') {
      this.signInToggle = false
      this.$router.push({ name: 'layout.dashboard' })
    }
  }
};
</script>
