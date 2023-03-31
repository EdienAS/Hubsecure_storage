const webpack = require("webpack");

const path = require("path");

function resolve(dir) {
  return path.join(__dirname, dir);
}

module.exports = {
  publicPath: process.env.NODE_ENV === "production" ? process.env.VUE_APP_BASE_URL : "/",

  configureWebpack: {
    plugins: [new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/)],
    resolve: {
      alias: {
        vue$: "vue/dist/vue.common.js",
        // 'jquery': 'jquery/src/jquery.js'
        "@": resolve("src"),
      },
    },
  },
};
