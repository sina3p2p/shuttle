let mix = require("laravel-mix");
const path = require("path");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

const time = new Date().getTime();

mix
  .js("resources/js/app.js", "shuttle-vue")
  .setPublicPath("public")
  .vue({ version: 2 })
  .extract([])
  //   .postCss("resources/css/app.css", "public")
  //   .copy("public", "../nova-app/public/vendor/nova")
  .webpackConfig({
    // resolve: {
    //   alias: {
    //     "@": path.resolve(__dirname, "resources/js/"),
    //   },
    // },
    // clean: {
    //   keep(asset) {
    //     if (/^(?!js\/).*/.test(asset)) return true;
    //   },
    // },
    // chunkFilename: `js/[id]-${time}.js`,
    output: {
      // clean: {
      //     keep(asset) {
      //         if (/^(?!js\/).*/.test(asset)) return true;
      //     },
      // },
      chunkFilename: `shuttle-vue/component/[id].js`,
    },
  })
  .version();
