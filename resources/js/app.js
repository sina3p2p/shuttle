// import CKEditor from "ckeditor4-vue";

require("./bootstrap");
require("./utils/caHash");

require
  .context("./", true, /\.vue$/i, "lazy")
  .keys()
  .forEach((file) => {
    Vue.component(file.split("/").pop().split(".")[0], () => import(`${file}`));
  });

window.eventBus = new Vue(); // creating an event bus.

// Vue.use(CKEditor);

window.app = new Vue({
  el: "#app",
  data() {
    return {};
  },
  mounted() {
    $(".pre-load-hidden").removeClass("pre-load-hidden");
  },
});
