"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_shared_HashModal_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/shared/HashModal.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/shared/HashModal.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: {
    modalId: {
      type: String,
      required: true
    },
    isFade: {
      type: Boolean,
      required: false,
      "default": true
    },
    parentClass: {
      type: String,
      required: false,
      "default": ""
    },
    isShown: {
      type: Boolean,
      "default": function _default() {
        return false;
      }
    },
    preventDefault: {
      type: Boolean,
      "default": function _default() {
        return false;
      }
    },
    isSingleParam: {
      type: Boolean,
      "default": function _default() {
        return false;
      }
    },
    centered: {
      type: Boolean,
      "default": function _default() {
        return false;
      }
    },
    size: {
      type: String,
      "default": function _default() {
        return "xl";
      }
    }
  },
  data: function data() {
    return {
      isShowModal: false
    };
  },
  computed: {
    modalSize: function modalSize() {
      return this.size == "md" ? "" : "modal-" + this.size;
    }
  },
  watch: {
    isShown: function isShown() {
      if (this.isShown && this.preventDefault) {
        this.openModal();
      } else {
        this.closeModal();
      }
    }
  },
  mounted: function mounted() {
    var me = this;
    me.hashCheckForEditing();
    $(window).on("hashchange", function () {
      me.hashCheckForEditing();
    });
  },
  methods: {
    hashCheckForEditing: function hashCheckForEditing() {
      this.isShowModal = false; // caInterface.waitIndicatorShow();

      var hash = caHash.get();

      if (!_.startsWith(hash, "#" + this.modalId)) {
        return;
      }

      var params = this.isSingleParam ? caHash.getParamSingleAndClear(hash) : caHash.getParamsMultipleAndClear(hash);
      if (this.isSingleParam && params == "#" + this.modalId) params = null;
      this.$emit("onHashParams", params);
      if (!this.preventDefault) this.openModal();
    },
    openModal: function openModal() {
      // caInterface.waitIndicatorHide();
      // this.$store.commit("setNotificationMessage", "");
      var me = this;
      this.$nextTick(function () {
        me.isShowModal = true;
        $("#" + me.modalId).modal("show");

        _.delay(function () {
          validationBootstrap.init();
        });
      });
    },
    closeModal: function closeModal() {
      $("#" + this.modalId).modal("hide");
      this.isShowModal = false;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/shared/HashModal.vue?vue&type=template&id=40ba9680&":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/shared/HashModal.vue?vue&type=template&id=40ba9680& ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm = this,
      _c = _vm._self._c;

  return _c("div", {
    "class": ["modal fade", _vm.isFade ? "fade" : "", _vm.parentClass ? _vm.parentClass : ""],
    attrs: {
      id: _vm.modalId,
      tabindex: "-1",
      role: "dialog"
    }
  }, [_c("div", {
    staticClass: "modal-dialog",
    "class": [{
      "modal-dialog-centered": _vm.centered
    }, _vm.modalSize],
    attrs: {
      role: "document"
    }
  }, [_vm.isShowModal ? _c("div", {
    staticClass: "modal-content"
  }, [_vm._t("default")], 2) : _vm._e()])]);
};

var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/components/shared/HashModal.vue":
/*!******************************************************!*\
  !*** ./resources/js/components/shared/HashModal.vue ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _HashModal_vue_vue_type_template_id_40ba9680___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./HashModal.vue?vue&type=template&id=40ba9680& */ "./resources/js/components/shared/HashModal.vue?vue&type=template&id=40ba9680&");
/* harmony import */ var _HashModal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./HashModal.vue?vue&type=script&lang=js& */ "./resources/js/components/shared/HashModal.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _HashModal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _HashModal_vue_vue_type_template_id_40ba9680___WEBPACK_IMPORTED_MODULE_0__.render,
  _HashModal_vue_vue_type_template_id_40ba9680___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/shared/HashModal.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/shared/HashModal.vue?vue&type=script&lang=js&":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/shared/HashModal.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_HashModal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./HashModal.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/shared/HashModal.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_HashModal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/shared/HashModal.vue?vue&type=template&id=40ba9680&":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/shared/HashModal.vue?vue&type=template&id=40ba9680& ***!
  \*************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_HashModal_vue_vue_type_template_id_40ba9680___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_HashModal_vue_vue_type_template_id_40ba9680___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_HashModal_vue_vue_type_template_id_40ba9680___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./HashModal.vue?vue&type=template&id=40ba9680& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/shared/HashModal.vue?vue&type=template&id=40ba9680&");


/***/ })

}]);