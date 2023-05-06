<template>
  <transition name="fade">
    <div
      v-if="isShow"
      @click="handleClickOverlay"
      class="vc-overlay"
      id="vueConfirm"
    >
      <transition name="zoom">
        <div
          v-if="isShow"
          ref="vueConfirmDialog"
          :class="['vc-container', 'vc-container-' + (dialog.size ?? 'sm')]"
        >
          <div class="vc-header" v-if="dialog.title">
            <div class="vc-title">
              <span>{{ dialog.title }}</span>
            </div>
          </div>
          <div
            v-if="dialog.message || dialog.html"
            class="vc-content"
            :style="dialog.styles.content"
          >
            <div
              v-if="dialog.html"
              class="vc-message"
              v-html="dialog.html.replaceAll('\\n', '<br />')"
            ></div>
            <div v-else class="vc-message">
              <p>{{ dialog.message }}</p>
            </div>
          </div>
          <div class="vc-btns-flex" v-if="dialog.flex">
            <button
              v-for="(btn, key) in dialog.button"
              :key="key"
              @click.stop="(e) => handleClickButton(e, key)"
              class="btn btn-primary"
              type="button"
            >
              {{ btn }}
            </button>
          </div>
          <div class="vc-btns" :style="dialog.styles.button" v-else>
            <button
              v-if="dialog.button.no"
              @click.stop="(e) => handleClickButton(e, false)"
              :class="[
                'mr-2',
                dialog.button.noClass
                  ? dialog.button.noClass
                  : 'btn btn-secondary',
              ]"
              type="button"
            >
              {{ dialog.button.no }}
            </button>

            <button
              v-if="dialog.button.yes"
              @click.stop="(e) => handleClickButton(e, true)"
              :class="
                dialog.button.yesClass
                  ? dialog.button.yesClass
                  : 'btn btn-primary'
              "
              type="button"
            >
              {{ dialog.button.yes }}
            </button>
          </div>
        </div>
      </transition>
    </div>
  </transition>
</template>

<script>
export default {
  data() {
    return {
      isShow: false,
      dialog: {
        title: "",
        message: "",
        button: {},
        html: "",
        cancelable: true,
        flex: false,
        styles: {},
        size: "sm",
      },
      params: {},
    };
  },
  methods: {
    resetState() {
      this.dialog = {
        title: "",
        message: "",
        button: {},
        html: "",
        cancelable: true,
        callback: () => {},
        flex: false,
        styles: {},
        size: "sm",
      };
    },
    handleClickButton({ target }, confirm) {
      if (target.id == "vueConfirm") return;
      this.isShow = false;
      // callback
      if (this.params.callback) {
        this.params.callback(confirm);
      }
    },
    handleClickOverlay({ target }) {
      if (target.id == "vueConfirm" && this.dialog.cancelable) {
        this.isShow = false;
        // callback
        if (this.params.callback) {
          this.params.callback(false);
        }
      }
    },
    handleKeyUp({ keyCode }) {
      if (keyCode == 27) {
        this.handleClickOverlay({ target: { id: "vueConfirm" } });
      }
      if (keyCode == 13) {
        this.handleClickButton({ target: { id: "" } }, true);
      }
    },
    open(params) {
      this.resetState();
      this.params = params;
      this.isShow = true;
      // set params to dialog state
      Object.entries(params).forEach((param) => {
        if (typeof param[1] == typeof this.dialog[param[0]]) {
          this.dialog[param[0]] = param[1];
        }
      });
    },
  },
};
</script>

<style>
/**
* Dialog
*/
.vc-overlay *,
.vc-overlay *:before,
.vc-overlay *:after {
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  text-decoration: none;
  -webkit-touch-callout: none;
  -moz-osx-font-smoothing: grayscale;
  margin: 0;
}
.vc-title {
  padding-left: 0;
  margin-bottom: 0;
  font-size: 18px;
  line-height: 1;
  color: #303133;
}
.vc-content {
  padding: 10px 15px;
  color: #606266;
  font-size: 14px;
}
.vc-btns {
  padding: 5px 15px 0;
  text-align: right;
}
.vc-btns-flex {
  padding: 5px 15px 0;
  display: flex;
  gap: 10px;
}
.vc-btns-flex > * {
  flex: 1;
}

.vc-overlay {
  background-color: #0000004a;
  width: 100%;
  height: 100%;
  transition: all 0.1s ease-in;
  left: 0;
  top: 0;
  z-index: 999999999999;
  position: fixed;
  display: flex;
  justify-content: center;
  align-items: center;
  align-content: baseline;
}
.vc-container {
  display: inline-block;
  padding-bottom: 10px;
  vertical-align: middle;
  background-color: #fff;
  border-radius: 4px;
  border: 1px solid #ebeef5;
  font-size: 18px;
  box-shadow: 0 2px 12px 0 rgb(0 0 0 / 10%);
  text-align: left;
  overflow: hidden;
  -webkit-backface-visibility: hidden;
  backface-visibility: hidden;
}
.vc-container-sm {
  width: 480px;
}
.vc-container-md {
  width: 720px;
}
.vc-header {
  position: relative;
  padding: 15px 15px 10px;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.21s;
}
.fade-enter,
.fade-leave-to {
  opacity: 0;
}
.zoom-enter-active,
.zoom-leave-active {
  animation-duration: 0.21s;
  animation-fill-mode: both;
  animation-name: zoom;
}
.zoom-leave-active {
  animation-direction: reverse;
}
@keyframes zoom {
  from {
    opacity: 0;
    transform: scale3d(1.1, 1.1, 1.1);
  }
  100% {
    opacity: 1;
    transform: scale3d(1, 1, 1);
  }
}
</style>
