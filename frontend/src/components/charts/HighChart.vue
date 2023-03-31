<template>
  <highcharts :options="option"></highcharts>
</template>
<script lang="js">
import { Chart } from 'highcharts-vue'
export default {
  name: 'HighChart',
  props: {
    option: { type: Object }
  },
  mounted () {
  },
  components: {
    highcharts: Chart
  }
}
</script>
