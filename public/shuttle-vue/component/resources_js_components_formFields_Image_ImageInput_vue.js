"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_formFields_Image_ImageInput_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/formFields/Image/ImageInput.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/formFields/Image/ImageInput.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var uuid__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! uuid */ "./node_modules/uuid/dist/esm-browser/v4.js");
/* harmony import */ var glightbox__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! glightbox */ "./node_modules/glightbox/dist/js/glightbox.min.js");
/* harmony import */ var glightbox__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(glightbox__WEBPACK_IMPORTED_MODULE_0__);


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: {
    name: {
      type: String,
      "default": ""
    },
    path: {
      type: String,
      "default": null
    },
    preview: {
      type: String,
      "default": null
    }
  },
  data: function data() {
    return {
      selected: null,
      value: "",
      uuid: (0,uuid__WEBPACK_IMPORTED_MODULE_1__["default"])()
    };
  },
  watch: {
    path: function path() {
      this.initValue();
    },
    preview: function preview() {
      this.initValue();
    }
  },
  mounted: function mounted() {
    eventBus.$on("imageSelected", this.imageSelected);
    this.initValue();
  },
  methods: {
    initValue: function initValue() {
      if (this.path && this.preview) {
        this.selected = {
          url: this.preview,
          path: this.path
        };
        this.value = this.path;
        this.$nextTick(function () {
          glightbox__WEBPACK_IMPORTED_MODULE_0___default()({});
        });
      }
    },
    imageSelected: function imageSelected(f, ref) {
      if (ref == this.uuid) {
        this.selected = f;
        this.value = f.path;
        this.$nextTick(function () {
          glightbox__WEBPACK_IMPORTED_MODULE_0___default()({});
        });
      }
    },
    removeFile: function removeFile() {
      this.selected = null;
      this.value = null;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/formFields/Image/ImageInput.vue?vue&type=template&id=0cb47b4c&":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/formFields/Image/ImageInput.vue?vue&type=template&id=0cb47b4c& ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************/
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
    staticClass: "select-from-library-container mb-1"
  }, [_c("div", {
    staticClass: "row"
  }, [_c("div", {
    staticClass: "col-12"
  }, [!_vm.value ? _c("div", {
    staticClass: "select-from-library-button sfl-single"
  }, [_c("input", {
    attrs: {
      name: _vm.name,
      value: "",
      hidden: ""
    }
  }), _vm._v(" "), _c("a", {
    staticClass: "card d-flex flex-row mb-4 media-thumb-container justify-content-center align-items-center",
    attrs: {
      href: "#media-library-modal=ref:".concat(_vm.uuid)
    }
  }, [_vm._v("\n          Select an item from library\n        ")])]) : _c("div", {
    staticClass: "selected-library-item"
  }, [_c("input", {
    attrs: {
      name: _vm.name,
      hidden: ""
    },
    domProps: {
      value: _vm.value
    }
  }), _vm._v(" "), _c("div", {
    staticClass: "card d-flex flex-row media-thumb-container"
  }, [_c("a", {
    staticClass: "glightbox d-flex align-self-center",
    attrs: {
      href: _vm.selected.url
    }
  }, [_c("img", {
    staticClass: "list-media-thumbnail responsive border-0 sfl-selected-item-image",
    attrs: {
      src: _vm.selected.url,
      alt: "uploaded image"
    }
  })]), _vm._v(" "), _c("div", {
    staticClass: "d-flex flex-grow-1 min-width-zero"
  }, [_c("div", {
    staticClass: "card-body align-self-center d-flex flex-column justify-content-between min-width-zero align-items-lg-center"
  }, [_c("a", {
    staticClass: "w-100"
  }, [_c("p", {
    staticClass: "list-item-heading mb-1 truncate sfl-selected-item-label"
  }, [_vm._v("\n                  " + _vm._s(_vm.selected.path) + "\n                ")])])]), _vm._v(" "), _c("div", {
    staticClass: "pl-1 align-self-center"
  }, [_c("a", {
    staticClass: "btn-link delete-library-item sfl-delete-item",
    attrs: {
      href: "#"
    },
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.removeFile.apply(null, arguments);
      }
    }
  }, [_c("i", {
    staticClass: "simple-icon-trash"
  })])])])])])])])]);
};

var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/components/formFields/Image/ImageInput.vue":
/*!*****************************************************************!*\
  !*** ./resources/js/components/formFields/Image/ImageInput.vue ***!
  \*****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _ImageInput_vue_vue_type_template_id_0cb47b4c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ImageInput.vue?vue&type=template&id=0cb47b4c& */ "./resources/js/components/formFields/Image/ImageInput.vue?vue&type=template&id=0cb47b4c&");
/* harmony import */ var _ImageInput_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ImageInput.vue?vue&type=script&lang=js& */ "./resources/js/components/formFields/Image/ImageInput.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ImageInput_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ImageInput_vue_vue_type_template_id_0cb47b4c___WEBPACK_IMPORTED_MODULE_0__.render,
  _ImageInput_vue_vue_type_template_id_0cb47b4c___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/formFields/Image/ImageInput.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/formFields/Image/ImageInput.vue?vue&type=script&lang=js&":
/*!******************************************************************************************!*\
  !*** ./resources/js/components/formFields/Image/ImageInput.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ImageInput_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ImageInput.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/formFields/Image/ImageInput.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ImageInput_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/formFields/Image/ImageInput.vue?vue&type=template&id=0cb47b4c&":
/*!************************************************************************************************!*\
  !*** ./resources/js/components/formFields/Image/ImageInput.vue?vue&type=template&id=0cb47b4c& ***!
  \************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ImageInput_vue_vue_type_template_id_0cb47b4c___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ImageInput_vue_vue_type_template_id_0cb47b4c___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ImageInput_vue_vue_type_template_id_0cb47b4c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ImageInput.vue?vue&type=template&id=0cb47b4c& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/formFields/Image/ImageInput.vue?vue&type=template&id=0cb47b4c&");


/***/ })

}]);