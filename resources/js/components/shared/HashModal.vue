<template>
  <div
    :class="[
      'modal fade',
      isFade ? 'fade' : '',
      parentClass ? parentClass : '',
    ]"
    :id="modalId"
    tabindex="-1"
    role="dialog"
  >
    <div
      class="modal-dialog"
      :class="[{ 'modal-dialog-centered': centered }, modalSize]"
      role="document"
    >
      <div class="modal-content" v-if="isShowModal">
        <slot></slot>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    modalId: {
      type: String,
      required: true,
    },
    isFade: {
      type: Boolean,
      required: false,
      default: true,
    },
    parentClass: {
      type: String,
      required: false,
      default: "",
    },
    isShown: {
      type: Boolean,
      default() {
        return false;
      },
    },
    preventDefault: {
      type: Boolean,
      default() {
        return false;
      },
    },
    isSingleParam: {
      type: Boolean,
      default() {
        return false;
      },
    },
    centered: {
      type: Boolean,
      default: () => false,
    },
    size: {
      type: String,
      default: () => "xl",
    },
  },
  data() {
    return {
      isShowModal: false,
    };
  },
  computed: {
    modalSize() {
      return this.size == "md" ? "" : "modal-" + this.size;
    },
  },
  watch: {
    isShown() {
      if (this.isShown && this.preventDefault) {
        this.openModal();
      } else {
        this.closeModal();
      }
    },
  },
  mounted() {
    var me = this;
    me.hashCheckForEditing();
    $(window).on("hashchange", function () {
      me.hashCheckForEditing();
    });
  },
  methods: {
    hashCheckForEditing() {
      this.isShowModal = false;
      // caInterface.waitIndicatorShow();
      const hash = caHash.get();
      if (!_.startsWith(hash, "#" + this.modalId)) {
        return;
      }
      let params = this.isSingleParam
        ? caHash.getParamSingleAndClear(hash)
        : caHash.getParamsMultipleAndClear(hash);
      if (this.isSingleParam && params == "#" + this.modalId) params = null;
      this.$emit("onHashParams", params);
      if (!this.preventDefault) this.openModal();
    },
    openModal() {
      // caInterface.waitIndicatorHide();
      // this.$store.commit("setNotificationMessage", "");
      const me = this;
      this.$nextTick(() => {
        me.isShowModal = true;
        $("#" + me.modalId).modal("show");
        _.delay(() => {
          validationBootstrap.init();
        });
      });
    },
    closeModal() {
      $("#" + this.modalId).modal("hide");
      this.isShowModal = false;
    },
  },
};
</script>
