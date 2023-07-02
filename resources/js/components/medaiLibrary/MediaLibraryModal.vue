<template>
  <hash-modal
    ref="mediaLibraryModal"
    modal-id="media-library-modal"
    parentClass="modal-right select-from-library2"
    @onHashParams="onHashParams"
    size="xxl"
  >
    <div class="modal-header">
      <h5 class="modal-title">Select from Library</h5>
      <button
        type="button"
        class="close"
        data-dismiss="modal"
        aria-label="Close"
      >
        <span aria-hidden="true">&times;</span>
      </button>
    </div>

    <div class="modal-body list scroll pt-0 pb-0 mt-4 mb-4">
      <div class="mb-2">
        <div class="row">
          <div class="col-3">
            <vue-dropzone
              ref="myVueDropzone"
              id="dropzone"
              :options="dropzoneOptions"
              @vdropzone-success="successUpload"
            ></vue-dropzone>
          </div>
           <div class="col-3 mb-1" v-for="(f, i) in files" :key="i + 'file'">
              <div class="card d-flex mb-2 mt-0 p-0 media-thumb-container">
                <div class="d-flex height-100 align-self-stretch">
                  <img
                    :src="f.url"
                    alt="uploaded image"
                    class="list-media-thumbnail responsive border-0"
                  />
                </div>
                <div class="d-flex flex-grow-1 min-width-zero">
                  <div
                    class="card-body pr-1 pt-2 pb-2 align-self-center d-flex min-width-zero"
                  >
                    <div class="w-100">
                      <p class="truncate mb-0">chocolate-cake-thumb.jpg</p>
                    </div>
                  </div>
                  <div
                    class="custom-control custom-checkbox pl-1 pr-1 align-self-center"
                  >
                    <label class="custom-control custom-checkbox mb-0">
                      <input
                        type="checkbox"
                        class="custom-control-input"
                        @change="imageSelected($event, f)"
                      />
                      <span class="custom-control-label"></span>
                    </label>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <div class="list disable-text-selection mt-3">
          <div class="row">
           <div class="col-md-12 mb-5">
            <h3 class="title">Library</h3>
           </div>
           <!-- /.col-md-12 -->


             <div class="col-md-12">
                                <div class="alert alert-danger">
                                  <p>We Havenot Images In Library</p>
                                </div>
                                <!-- /.alert alert-danger -->
             </div>
                  <!-- /.col-md-12 -->
                  
  <div class="col-3 mb-1" v-for="(f, i) in files" :key="i + 'file'">
              <div class="card d-flex mb-2 p-0 media-thumb-container">
                <div class="d-flex height-100 align-self-stretch">
                  <img
                    :src="f.url"
                    alt="uploaded image"
                    class="list-media-thumbnail responsive border-0"
                  />
                </div>
                <div class="d-flex flex-grow-1 min-width-zero">
                  <div
                    class="card-body pr-1 pt-2 pb-2 align-self-center d-flex min-width-zero"
                  >
                    <div class="w-100">
                      <p class="truncate mb-0">chocolate-cake-thumb.jpg</p>
                    </div>
                  </div>
                  <div
                    class="custom-control custom-checkbox pl-1 pr-1 align-self-center"
                  >
                    <label class="custom-control custom-checkbox mb-0">
                      <input
                        type="checkbox"
                        class="custom-control-input"
                        @change="imageSelected($event, f)"
                      />
                      <span class="custom-control-label"></span>
                    </label>
                  </div>
                </div>
              </div>
            </div>
                

          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer" v-if="isMultiple">
      <button
        type="button"
        class="btn btn-outline-primary"
        data-dismiss="modal"
      >
        Cancel
      </button>
      <button type="button" class="btn btn-primary sfl-submit">Select</button>
    </div>
  </hash-modal>
</template>

<script>
import vue2Dropzone from "vue2-dropzone";
import "vue2-dropzone/dist/vue2Dropzone.min.css";

export default {
  props: {
    uploadUrl: {
      type: String,
      required: true,
    },
  },
  components: {
    vueDropzone: vue2Dropzone,
  },
  data() {
    return {
      dropzoneOptions: {
        url: this.uploadUrl,
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
      },
      files: [],
      isMultiple: false,
      reqRef: "",
    };
  },
  methods: {
    onHashParams(data) {
      const isMultiple = (
        _.find(data, (param) => param.key === "multiple") || {}
      ).value;
      this.reqRef = (_.find(data, (param) => param.key === "ref") || {}).value;

      if (isMultiple) {
        this.isMultiple = true;
      }
    },
    successUpload(file, res) {
      this.$refs.myVueDropzone.removeFile(file);
      this.files.push(res);
    },
    imageSelected($event, f) {
      if (this.isMultiple) {
        return;
      }

      eventBus.$emit("imageSelected", f, this.reqRef);
      this.$refs.mediaLibraryModal.closeModal();
    },
  },
};
</script>
