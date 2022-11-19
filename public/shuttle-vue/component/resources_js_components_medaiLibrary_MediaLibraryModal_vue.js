"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_medaiLibrary_MediaLibraryModal_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/medaiLibrary/MediaLibraryModal.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/medaiLibrary/MediaLibraryModal.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vue2_dropzone__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue2-dropzone */ "./node_modules/vue2-dropzone/dist/vue2Dropzone.js");
/* harmony import */ var vue2_dropzone__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue2_dropzone__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue2_dropzone_dist_vue2Dropzone_min_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue2-dropzone/dist/vue2Dropzone.min.css */ "./node_modules/vue2-dropzone/dist/vue2Dropzone.min.css");


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: {
    uploadUrl: {
      type: String,
      required: true
    }
  },
  components: {
    vueDropzone: (vue2_dropzone__WEBPACK_IMPORTED_MODULE_0___default())
  },
  data: function data() {
    return {
      dropzoneOptions: {
        url: this.uploadUrl,
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
      },
      files: [],
      isMultiple: false,
      reqRef: ""
    };
  },
  methods: {
    onHashParams: function onHashParams(data) {
      var isMultiple = (_.find(data, function (param) {
        return param.key === "multiple";
      }) || {}).value;
      this.reqRef = (_.find(data, function (param) {
        return param.key === "ref";
      }) || {}).value;

      if (isMultiple) {
        this.isMultiple = true;
      }
    },
    successUpload: function successUpload(file, res) {
      this.$refs.myVueDropzone.removeFile(file);
      this.files.push(res);
    },
    imageSelected: function imageSelected($event, f) {
      if (this.isMultiple) {
        return;
      }

      eventBus.$emit("imageSelected", f, this.reqRef);
      this.$refs.mediaLibraryModal.closeModal();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/medaiLibrary/MediaLibraryModal.vue?vue&type=template&id=7f44cdb9&":
/*!************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/medaiLibrary/MediaLibraryModal.vue?vue&type=template&id=7f44cdb9& ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm = this,
      _c = _vm._self._c;

  return _c("hash-modal", {
    ref: "mediaLibraryModal",
    attrs: {
      "modal-id": "media-library-modal",
      parentClass: "modal-right select-from-library2"
    },
    on: {
      onHashParams: _vm.onHashParams
    }
  }, [_c("div", {
    staticClass: "modal-header"
  }, [_c("h5", {
    staticClass: "modal-title"
  }, [_vm._v("Select from Library")]), _vm._v(" "), _c("button", {
    staticClass: "close",
    attrs: {
      type: "button",
      "data-dismiss": "modal",
      "aria-label": "Close"
    }
  }, [_c("span", {
    attrs: {
      "aria-hidden": "true"
    }
  }, [_vm._v("×")])])]), _vm._v(" "), _c("div", {
    staticClass: "modal-body scroll pt-0 pb-0 mt-4 mb-4"
  }, [_c("div", {
    staticClass: "mb-2"
  }, [_c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-12"
  }, [_c("vue-dropzone", {
    ref: "myVueDropzone",
    attrs: {
      id: "dropzone",
      options: _vm.dropzoneOptions
    },
    on: {
      "vdropzone-success": _vm.successUpload
    }
  })], 1)]), _vm._v(" "), _c("div", {
    staticClass: "list disable-text-selection mt-3"
  }, [_c("div", {
    staticClass: "row"
  }, _vm._l(_vm.files, function (f, i) {
    return _c("div", {
      key: i + "file",
      staticClass: "col-6 mb-1"
    }, [_c("div", {
      staticClass: "card d-flex mb-2 p-0 media-thumb-container"
    }, [_c("div", {
      staticClass: "d-flex align-self-stretch"
    }, [_c("img", {
      staticClass: "list-media-thumbnail responsive border-0",
      attrs: {
        src: f.url,
        alt: "uploaded image"
      }
    })]), _vm._v(" "), _c("div", {
      staticClass: "d-flex flex-grow-1 min-width-zero"
    }, [_c("div", {
      staticClass: "card-body pr-1 pt-2 pb-2 align-self-center d-flex min-width-zero"
    }, [_c("div", {
      staticClass: "w-100"
    }, [_c("p", {
      staticClass: "truncate mb-0"
    }, [_vm._v("chocolate-cake-thumb.jpg")])])]), _vm._v(" "), _c("div", {
      staticClass: "custom-control custom-checkbox pl-1 pr-1 align-self-center"
    }, [_c("label", {
      staticClass: "custom-control custom-checkbox mb-0"
    }, [_c("input", {
      staticClass: "custom-control-input",
      attrs: {
        type: "checkbox"
      },
      on: {
        change: function change($event) {
          return _vm.imageSelected($event, f);
        }
      }
    }), _vm._v(" "), _c("span", {
      staticClass: "custom-control-label"
    })])])])])]);
  }), 0)])])]), _vm._v(" "), _vm.isMultiple ? _c("div", {
    staticClass: "modal-footer"
  }, [_c("button", {
    staticClass: "btn btn-outline-primary",
    attrs: {
      type: "button",
      "data-dismiss": "modal"
    }
  }, [_vm._v("\n      Cancel\n    ")]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-primary sfl-submit",
    attrs: {
      type: "button"
    }
  }, [_vm._v("Select")])]) : _vm._e()]);
};

var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/components/medaiLibrary/MediaLibraryModal.vue":
/*!********************************************************************!*\
  !*** ./resources/js/components/medaiLibrary/MediaLibraryModal.vue ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _MediaLibraryModal_vue_vue_type_template_id_7f44cdb9___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./MediaLibraryModal.vue?vue&type=template&id=7f44cdb9& */ "./resources/js/components/medaiLibrary/MediaLibraryModal.vue?vue&type=template&id=7f44cdb9&");
/* harmony import */ var _MediaLibraryModal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./MediaLibraryModal.vue?vue&type=script&lang=js& */ "./resources/js/components/medaiLibrary/MediaLibraryModal.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _MediaLibraryModal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _MediaLibraryModal_vue_vue_type_template_id_7f44cdb9___WEBPACK_IMPORTED_MODULE_0__.render,
  _MediaLibraryModal_vue_vue_type_template_id_7f44cdb9___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/medaiLibrary/MediaLibraryModal.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/medaiLibrary/MediaLibraryModal.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************!*\
  !*** ./resources/js/components/medaiLibrary/MediaLibraryModal.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MediaLibraryModal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./MediaLibraryModal.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/medaiLibrary/MediaLibraryModal.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_MediaLibraryModal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/medaiLibrary/MediaLibraryModal.vue?vue&type=template&id=7f44cdb9&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/components/medaiLibrary/MediaLibraryModal.vue?vue&type=template&id=7f44cdb9& ***!
  \***************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_MediaLibraryModal_vue_vue_type_template_id_7f44cdb9___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_MediaLibraryModal_vue_vue_type_template_id_7f44cdb9___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_MediaLibraryModal_vue_vue_type_template_id_7f44cdb9___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./MediaLibraryModal.vue?vue&type=template&id=7f44cdb9& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/medaiLibrary/MediaLibraryModal.vue?vue&type=template&id=7f44cdb9&");


/***/ })

}]);