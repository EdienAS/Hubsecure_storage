<template>
    <div class="container">
         <b-row class=" no-gutters height-self-center">
            <b-col sm="12" class=" text-center align-self-center">
               <div class="iq-error position-relative">
                     <img src="../../../../assets/images/error/404.png" class="img-fluid iq-error-img" alt="">
                     <h2 class="mb-0 mt-4">Oops! This Page is Not Found.</h2>
                     <p>The requested page dose not exist.</p>
                     <router-link class="btn btn-primary d-inline-flex align-items-center mt-3" :to="{name: 'layout.dashboard'}"><i class="ri-home-4-line"></i>Back to Home</router-link>
               </div>
            </b-col>
         </b-row>
   </div>
</template>
<script lang="js">
export default {
    name:'Error404'
}
</script>