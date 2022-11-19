<template>
  <div>
    <textarea :name="name" v-model="editorData" hidden></textarea>
    <ckeditor v-model="editorData" :config="editorConfig"></ckeditor>
  </div>
</template>

<script>
import CKEditor from "ckeditor4-vue";

export default {
  props: {
    name: {
      type: String,
      default: "",
    },
    value: {
      type: String,
      default: "",
    },
  },
  components: {
    // Use the <ckeditor> component in this view.
    ckeditor: CKEditor.component,
  },
  data() {
    return {
      editorData: this.value ?? "",
      editorConfig: {
        // The configuration of the editor.
      },
    };
  },
};
</script>
