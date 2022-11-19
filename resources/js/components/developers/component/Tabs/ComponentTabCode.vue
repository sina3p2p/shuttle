<template>
  <div>
    <div v-show="false">
      <textarea name="html" v-model="content" hidden></textarea>
      <slot></slot>
    </div>
    <editor
      id="editor"
      v-model="content"
      @init="editorInit"
      lang="html"
      theme="chrome"
      width="100%"
      height="700"
    ></editor>
  </div>
</template>

<script>
export default {
  components: {
    editor: require("vue2-ace-editor"),
  },
  data() {
    return {
      content: "",
    };
  },
  mounted() {
    const doc = document.getElementById("html");
    this.content = doc.value;
    doc.remove();
  },
  methods: {
    editorInit: function () {
      require("brace/ext/language_tools"); //language extension prerequsite...
      require("brace/mode/html");
      require("brace/mode/javascript"); //language
      require("brace/mode/less");
      require("brace/theme/chrome");
      require("brace/snippets/javascript"); //snippet
    },
    format(html) {
      var tab = "\t";
      var result = "";
      var indent = "";

      html.split(/>\s*</).forEach(function (element) {
        if (element.match(/^\/\w/)) {
          indent = indent.substring(tab.length);
        }

        result += indent + "<" + element + ">\r\n";

        if (element.match(/^<?\w[^>]*[^\/]$/) && !element.startsWith("input")) {
          indent += tab;
        }
      });

      return result.substring(1, result.length - 3);
    },
  },
};
</script>
