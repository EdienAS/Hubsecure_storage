import Vue from 'vue'

Vue.mixin({
    data() { 
        return {
            baseUrl: ''
        }
    },
    mounted() { 
        this.baseUrl = process.env.VUE_APP_BASE_URL
    }
})