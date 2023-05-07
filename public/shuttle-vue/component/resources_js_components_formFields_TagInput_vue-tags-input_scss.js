"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_formFields_TagInput_vue-tags-input_scss"],{

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!./resources/js/components/formFields/TagInput/vue-tags-input.scss":
/*!***************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!./resources/js/components/formFields/TagInput/vue-tags-input.scss ***!
  \***************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "ul {\n  margin: 0px;\n  padding: 0px;\n  list-style-type: none;\n}\n\n*,\n*:before,\n*:after {\n  box-sizing: border-box;\n}\n\ninput:focus {\n  outline: none;\n}\n\ninput[disabled] {\n  background-color: transparent;\n}\n\ndiv.vue-tags-input.disabled {\n  opacity: 0.5;\n}\ndiv.vue-tags-input.disabled * {\n  cursor: default;\n}\n\n.ti-input {\n  display: flex;\n  flex-wrap: wrap;\n  border-radius: 0.1rem;\n  outline: initial !important;\n  box-shadow: initial !important;\n  font-size: 0.8rem;\n  padding: 0.35rem 0.75rem;\n  line-height: 1;\n  border: 1px solid #d7d7d7;\n  background: white;\n  color: #3a3a3a;\n  border-color: #d7d7d7;\n  min-height: calc(2em + 0.8rem);\n}\n\n.ti-tags {\n  display: flex;\n  flex-wrap: wrap;\n  width: 100%;\n  line-height: 1em;\n  height: 100%;\n}\n\n.ti-tag {\n  background-color: #5c6bc0;\n  color: #fff;\n  border-radius: 2px;\n  display: flex;\n  padding: 3px 5px;\n  margin-right: 2px;\n  margin-top: 1px;\n  margin-bottom: 1px;\n  font-size: 0.8rem;\n}\n.ti-tag:focus {\n  outline: none;\n}\n.ti-tag .ti-content {\n  display: flex;\n  align-items: center;\n}\n.ti-tag .ti-tag-center {\n  position: relative;\n}\n.ti-tag span {\n  line-height: 0.85em;\n}\n.ti-tag span.ti-hidden {\n  padding-left: 14px;\n  visibility: hidden;\n  height: 0px;\n  white-space: pre;\n}\n.ti-tag .ti-actions {\n  margin-left: 2px;\n  display: flex;\n  align-items: center;\n  font-size: 1.15em;\n}\n.ti-tag .ti-actions i {\n  cursor: pointer;\n}\n.ti-tag:last-child {\n  margin-right: 4px;\n}\n.ti-tag.ti-invalid, .ti-tag.ti-tag.ti-deletion-mark {\n  background-color: #e54d42;\n}\n\n.ti-new-tag-input-wrapper {\n  display: flex;\n  flex: 1 0 auto;\n  padding: 3px 5px;\n  margin: 2px;\n  font-size: 0.8rem;\n}\n.ti-new-tag-input-wrapper input {\n  flex: 1 0 auto;\n  min-width: 100px;\n  border: none;\n  padding: 0px;\n  margin: 0px;\n}\n\n.ti-new-tag-input {\n  line-height: initial;\n}\n\n.ti-autocomplete {\n  border: 1px solid #ccc;\n  border-top: none;\n  position: absolute;\n  width: 100%;\n  background-color: #fff;\n  z-index: 20;\n}\n\n.ti-item > div {\n  cursor: pointer;\n  padding: 3px 6px;\n  width: 100%;\n}\n\n.ti-selected-item {\n  background-color: #5c6bc0;\n  color: #fff;\n}", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./resources/js/components/formFields/TagInput/vue-tags-input.scss":
/*!*************************************************************************!*\
  !*** ./resources/js/components/formFields/TagInput/vue-tags-input.scss ***!
  \*************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_use_1_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_use_3_vue_tags_input_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!../../../../../node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!./vue-tags-input.scss */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-12.use[1]!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-12.use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-12.use[3]!./resources/js/components/formFields/TagInput/vue-tags-input.scss");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_use_1_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_use_3_vue_tags_input_scss__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_12_use_1_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_12_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_12_use_3_vue_tags_input_scss__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ })

}]);