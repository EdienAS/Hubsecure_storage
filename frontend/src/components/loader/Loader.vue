<template>
<div id="loading" >
    <div id="loading-center">
    </div>
  </div>
</template>
<script lang="js">
import {animation} from "@/config/pluginInit";
export default {
  name: 'Loader',
  watch: {
    $route: function () {
      this.init()
    }
  },
  computed: {
  },
  mounted () {
    this.init()
  },
  methods: {
    init() {
      const load = document.getElementById('loading')
      load.classList.remove('d-none')
      window.scrollTo({ top: 0, behavior: 'smooth' });
      animation.fadeIn(load, { duration: 20 })
      setTimeout (() => {
        animation.fadeOut(load, { duration: 20 })
        load.classList.add('d-none')
      }, 1000)
    }
  }
}
</script>
