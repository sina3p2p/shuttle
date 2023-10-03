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
            <button class="remove-it" @click="removeItem(f.id)">
              <svg
                width="800px"
                height="800px"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M20.5001 6H3.5"
                  stroke="#1C274C"
                  stroke-width="1.5"
                  stroke-linecap="round"
                />
                <path
                  d="M9.5 11L10 16"
                  stroke="#1C274C"
                  stroke-width="1.5"
                  stroke-linecap="round"
                />
                <path
                  d="M14.5 11L14 16"
                  stroke="#1C274C"
                  stroke-width="1.5"
                  stroke-linecap="round"
                />
                <path
                  d="M6.5 6C6.55588 6 6.58382 6 6.60915 5.99936C7.43259 5.97849 8.15902 5.45491 8.43922 4.68032C8.44784 4.65649 8.45667 4.62999 8.47434 4.57697L8.57143 4.28571C8.65431 4.03708 8.69575 3.91276 8.75071 3.8072C8.97001 3.38607 9.37574 3.09364 9.84461 3.01877C9.96213 3 10.0932 3 10.3553 3H13.6447C13.9068 3 14.0379 3 14.1554 3.01877C14.6243 3.09364 15.03 3.38607 15.2493 3.8072C15.3043 3.91276 15.3457 4.03708 15.4286 4.28571L15.5257 4.57697C15.5433 4.62992 15.5522 4.65651 15.5608 4.68032C15.841 5.45491 16.5674 5.97849 17.3909 5.99936C17.4162 6 17.4441 6 17.5 6"
                  stroke="#1C274C"
                  stroke-width="1.5"
                />
                <path
                  d="M18.3735 15.3991C18.1965 18.054 18.108 19.3815 17.243 20.1907C16.378 21 15.0476 21 12.3868 21H11.6134C8.9526 21 7.6222 21 6.75719 20.1907C5.89218 19.3815 5.80368 18.054 5.62669 15.3991L5.16675 8.5M18.8334 8.5L18.6334 11.5"
                  stroke="#1C274C"
                  stroke-width="1.5"
                  stroke-linecap="round"
                />
              </svg>
            </button>
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
                    <p class="truncate mb-0">{{ f.name }}</p>
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
        <div class="list disable-text-selection mt-3" v-if="!isLoading">
          <div class="row">
            <div class="col-md-12 mb-1">
              <h3 class="title">Library</h3>
            </div>

            <div class="col-md-12" v-if="uploadedFiles.length == 0">
              <div class="alert alert-danger">
                <p>We Havenot Images In Library</p>
              </div>
            </div>

            <div
              class="col-3 mb-1 position-relative"
              v-for="(f, i) in uploadedFiles"
              :key="i + 'file'"
            >
              <button class="remove-it" @click="removeItem(f.id)">
                <svg
                  width="800px"
                  height="800px"
                  viewBox="0 0 24 24"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M20.5001 6H3.5"
                    stroke="#1C274C"
                    stroke-width="1.5"
                    stroke-linecap="round"
                  />
                  <path
                    d="M9.5 11L10 16"
                    stroke="#1C274C"
                    stroke-width="1.5"
                    stroke-linecap="round"
                  />
                  <path
                    d="M14.5 11L14 16"
                    stroke="#1C274C"
                    stroke-width="1.5"
                    stroke-linecap="round"
                  />
                  <path
                    d="M6.5 6C6.55588 6 6.58382 6 6.60915 5.99936C7.43259 5.97849 8.15902 5.45491 8.43922 4.68032C8.44784 4.65649 8.45667 4.62999 8.47434 4.57697L8.57143 4.28571C8.65431 4.03708 8.69575 3.91276 8.75071 3.8072C8.97001 3.38607 9.37574 3.09364 9.84461 3.01877C9.96213 3 10.0932 3 10.3553 3H13.6447C13.9068 3 14.0379 3 14.1554 3.01877C14.6243 3.09364 15.03 3.38607 15.2493 3.8072C15.3043 3.91276 15.3457 4.03708 15.4286 4.28571L15.5257 4.57697C15.5433 4.62992 15.5522 4.65651 15.5608 4.68032C15.841 5.45491 16.5674 5.97849 17.3909 5.99936C17.4162 6 17.4441 6 17.5 6"
                    stroke="#1C274C"
                    stroke-width="1.5"
                  />
                  <path
                    d="M18.3735 15.3991C18.1965 18.054 18.108 19.3815 17.243 20.1907C16.378 21 15.0476 21 12.3868 21H11.6134C8.9526 21 7.6222 21 6.75719 20.1907C5.89218 19.3815 5.80368 18.054 5.62669 15.3991L5.16675 8.5M18.8334 8.5L18.6334 11.5"
                    stroke="#1C274C"
                    stroke-width="1.5"
                    stroke-linecap="round"
                  />
                </svg>
              </button>
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
                      <p class="truncate mb-0">{{ f.name }}</p>
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
      uploadedFiles: [],
      isLoading: false,
    };
  },
  methods: {
    async onHashParams(data) {
      const isMultiple = (
        _.find(data, (param) => param.key === "multiple") || {}
      ).value;
      this.reqRef = (_.find(data, (param) => param.key === "ref") || {}).value;

      if (isMultiple) {
        this.isMultiple = true;
      }

      this.isLoading = true;
      this.uploadedFiles = (await axios.get("/mypanel/media")).data;
      this.isLoading = false;
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
    async removeItem(id) {
      await axios.delete(`/mypanel/media/${id}`);
      this.uploadedFiles = (await axios.get("/mypanel/media")).data;
    },
  },
};
</script>
