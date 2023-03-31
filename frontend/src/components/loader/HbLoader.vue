<template>
  <div v-if="value" class="loader">
    <div class="spinner"></div>
  </div>
</template>

<script>
export default {
  name: "HbLoader",
  props: {
    value: {
      type: Boolean,
      required: true,
    },
  },
};
</script>

<style>
.loader {
  position: fixed;
  top: 100%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 9999;
  opacity: 0.1;
  background-color: #ffffff;
  display: flex;
  justify-content: center;
  align-items: center;
  min-width: 100vw;
  min-height: 100vh;
}

.spinner {
  border: 8px solid #f3f3f3;
  border-top: 8px solid #3498db;
  border-radius: 50%;
  width: 50px;
  height: 50px;
  animation: spin 0.4s linear infinite;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>
