<template>
  <div class="select-from-library-container mb-1">
    <div class="row">
      <div class="col-12">
        <div v-if="!value" class="select-from-library-button sfl-single">
          <input :name="name" value="" hidden />
          <a
            :href="`#media-library-modal=ref:${uuid}`"
            class="card d-flex flex-row mb-4 media-thumb-container justify-content-center align-items-center"
          >
            Select an item from library
          </a>
        </div>
        <div class="selected-library-item" v-else>
          <input :name="name" :value="value" hidden />
          <div class="card d-flex flex-row media-thumb-container">
            <a :href="selected.url" class="glightbox d-flex align-self-center">
              <img
                :src="selected.url"
                alt="uploaded image"
                class="list-media-thumbnail responsive border-0 sfl-selected-item-image"
              />
            </a>
            <div class="d-flex flex-grow-1 min-width-zero">
              <div
                class="card-body align-self-center d-flex flex-column justify-content-between min-width-zero align-items-lg-center"
              >
                <a class="w-100">
                  <p
                    class="list-item-heading mb-1 truncate sfl-selected-item-label"
                  >
                    {{ selected.path }}
                  </p>
                </a>
              </div>
              <div class="pl-1 align-self-center">
                <a
                  href="#"
                  @click.prevent="removeFile"
                  class="btn-link delete-library-item sfl-delete-item"
                  ><i class="simple-icon-trash"></i
                ></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { v4 as uuidv4 } from "uuid";
import GLightbox from "glightbox";

export default {
  props: {
    name: {
      type: String,
      default: "",
    },
    path: {
      type: String,
      default: null,
    },
    preview: {
      type: String,
      default: null,
    },
  },
  data() {
    return {
      selected: null,
      value: "",
      uuid: uuidv4(),
    };
  },
  watch: {
    path() {
      this.initValue();
    },
    preview() {
      this.initValue();
    },
  },
  mounted() {
    eventBus.$on("imageSelected", this.imageSelected);
    this.initValue();
  },
  methods: {
    initValue() {
      if (this.path && this.preview) {
        this.selected = {
          url: this.preview,
          path: this.path,
        };
        this.value = this.path;
        GLightbox({});
      }
    },
    imageSelected(f, ref) {
      if (ref == this.uuid) {
        this.selected = f;
        this.value = f.path;
      }
    },
    removeFile() {
      this.selected = null;
      this.value = null;
    },
  },
};
</script>
