<template>
     <section class="login-content">
         <div class="container h-100">
            <div class="row justify-content-center align-items-center height-self-center">
               <div class="col-md-5 col-sm-12 col-12 align-self-center">
                  <div class="sign-user_card">
                     <img src="@/assets/images/logo.png" class="img-fluid rounded-normal light-logo logo" alt="logo">
                     <h2 class="mb-3">Reset Password</h2>
                     <p>Enter your email address and we'll send you an email with instructions to reset your password.</p>
                     <form @submit.prevent="onSubmit()">
                        <div class="row">
                           <div class="col-lg-12">
                              <div class="floating-label form-group">
                                 <input class="floating-input form-control" type="email" placeholder=" ">
                                 <label>Email</label>
                              </div>
                           </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Reset</button>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </section>
</template>
<script lang="js">
export default {
    name:'RecoverPassword',
    methods: {
    onSubmit () {
      this.$router.push({name: 'auth.login'})
    }
  }
}
</script>