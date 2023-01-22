"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_developers_database_DatabaseType_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/developers/database/DatabaseType.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/developers/database/DatabaseType.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: {
    column: {
      type: Object,
      required: true
    },
    value: {
      type: Object,
      "default": null
    }
  },
  //   data() {
  //     return {
  //       dbTypes: databaseTypes,
  //     };
  //   },
  computed: {
    dbTypes: function dbTypes() {
      return window.dbTypes;
    }
  },
  methods: {
    onTypeChange: function onTypeChange(event) {
      this.$emit("input", this.getDbType(event.target.value));
    },
    getDbType: function getDbType(name) {
      var type;
      name = name.toLowerCase().trim();

      for (var category in this.dbTypes) {
        type = this.dbTypes[category].find(function (type) {
          return name == type.name.toLowerCase();
        });

        if (type) {
          return type;
        }
      } // toastr.error("{{ __('voyager::database.unknown_type') }}: " + name);


      return databaseTypes.Numbers[0];
    },
    getType: function getType(name) {
      return getDbType(name);
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/developers/database/DatabaseType.vue?vue&type=template&id=77dc5aa4&":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/developers/database/DatabaseType.vue?vue&type=template&id=77dc5aa4& ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm = this,
      _c = _vm._self._c;

  return _c("select", {
    staticClass: "form-control",
    domProps: {
      value: _vm.column.type.name
    },
    on: {
      change: _vm.onTypeChange
    }
  }, _vm._l(_vm.dbTypes, function (types, category) {
    return _c("optgroup", {
      key: category,
      attrs: {
        label: category
      }
    }, _vm._l(types, function (type) {
      return _c("option", {
        key: type.name,
        domProps: {
          value: type.name
        }
      }, [_vm._v("\n      " + _vm._s(type.name.toUpperCase()) + "\n    ")]);
    }), 0);
  }), 0);
};

var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/components/developers/database/DatabaseType.vue":
/*!**********************************************************************!*\
  !*** ./resources/js/components/developers/database/DatabaseType.vue ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _DatabaseType_vue_vue_type_template_id_77dc5aa4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./DatabaseType.vue?vue&type=template&id=77dc5aa4& */ "./resources/js/components/developers/database/DatabaseType.vue?vue&type=template&id=77dc5aa4&");
/* harmony import */ var _DatabaseType_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./DatabaseType.vue?vue&type=script&lang=js& */ "./resources/js/components/developers/database/DatabaseType.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _DatabaseType_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _DatabaseType_vue_vue_type_template_id_77dc5aa4___WEBPACK_IMPORTED_MODULE_0__.render,
  _DatabaseType_vue_vue_type_template_id_77dc5aa4___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/developers/database/DatabaseType.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/developers/database/DatabaseType.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************!*\
  !*** ./resources/js/components/developers/database/DatabaseType.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_DatabaseType_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./DatabaseType.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/developers/database/DatabaseType.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_DatabaseType_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/developers/database/DatabaseType.vue?vue&type=template&id=77dc5aa4&":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/components/developers/database/DatabaseType.vue?vue&type=template&id=77dc5aa4& ***!
  \*****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_DatabaseType_vue_vue_type_template_id_77dc5aa4___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_DatabaseType_vue_vue_type_template_id_77dc5aa4___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_DatabaseType_vue_vue_type_template_id_77dc5aa4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./DatabaseType.vue?vue&type=template&id=77dc5aa4& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/developers/database/DatabaseType.vue?vue&type=template&id=77dc5aa4&");


/***/ })

}]);