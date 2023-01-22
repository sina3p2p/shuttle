"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_developers_database_DatabaseTableEditor_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/developers/database/DatabaseTableEditor.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/developers/database/DatabaseTableEditor.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vue_switches__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-switches */ "./node_modules/vue-switches/src/switches.vue");

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    Switches: vue_switches__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  props: {
    originalTable: {
      type: Object,
      required: false,
      "default": function _default() {
        return {};
      }
    },
    types: {
      type: Object,
      "default": function _default() {
        return {};
      }
    }
  },
  data: function data() {
    return {
      table: {
        name: "",
        columns: []
      },
      tableJson: ""
    };
  },
  mounted: function mounted() {
    this.table = this.originalTable;
  },
  methods: {
    // addNewColumn() {
    //   this.table.columns.push({});
    // },
    addColumn: function addColumn(column) {
      this.table.columns.push(column);
    },
    makeColumn: function makeColumn(options) {
      return $.extend({
        name: "",
        oldName: "",
        type: {
          name: "bigint",
          category: "Numbers",
          "default": {
            type: "number",
            step: "any"
          }
        },
        length: null,
        fixed: false,
        unsigned: false,
        autoincrement: false,
        notnull: false,
        "default": null
      }, options);
    },
    addNewColumn: function addNewColumn() {
      this.addColumn(this.makeColumn());
    },
    addTimestamps: function addTimestamps() {
      this.addColumn(this.makeColumn({
        name: "created_at",
        type: "timestamp"
      }));
      this.addColumn(this.makeColumn({
        name: "updated_at",
        type: "timestamp"
      }));
    },
    addSoftDeletes: function addSoftDeletes() {
      this.addColumn(this.makeColumn({
        name: "deleted_at",
        type: "timestamp"
      }));
    },
    addTranslations: function addTranslations() {
      this.addColumn(this.makeColumn({
        name: "locale",
        type: "varchar",
        length: 4
      }));
      this.addColumn(this.makeColumn({
        name: this.tableName.replace("_translations", "_id"),
        type: "integer"
      }));
    },
    saveTable: function saveTable() {
      var _this = this;

      this.tableJson = JSON.stringify(this.table);
      this.$nextTick(function () {
        return _this.$emit("submit");
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/developers/database/DatabaseTableEditor.vue?vue&type=template&id=769092d2&":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/developers/database/DatabaseTableEditor.vue?vue&type=template&id=769092d2& ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************************/
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
    staticClass: "row"
  }, [_c("textarea", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.tableJson,
      expression: "tableJson"
    }],
    attrs: {
      hidden: "",
      name: "table"
    },
    domProps: {
      value: _vm.tableJson
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;
        _vm.tableJson = $event.target.value;
      }
    }
  }), _vm._v(" "), _c("div", {
    staticClass: "col-md-6"
  }, [_c("label", {
    attrs: {
      "for": "name"
    }
  }, [_vm._v("Table name")]), _c("br"), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model.trim",
      value: _vm.table.name,
      expression: "table.name",
      modifiers: {
        trim: true
      }
    }],
    staticClass: "form-control",
    attrs: {
      type: "text",
      required: ""
    },
    domProps: {
      value: _vm.table.name
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;

        _vm.$set(_vm.table, "name", $event.target.value.trim());
      },
      blur: function blur($event) {
        return _vm.$forceUpdate();
      }
    }
  })]), _vm._v(" "), _c("div", {
    staticClass: "col-md-2"
  }, [_c("label", {
    attrs: {
      "for": "name"
    }
  }, [_vm._v("Table name")]), _c("br"), _vm._v(" "), _c("switches")], 1), _vm._v(" "), _c("div", {
    staticClass: "col-md-2"
  }, [_c("label", {
    attrs: {
      "for": "name"
    }
  }, [_vm._v("Table name")]), _c("br"), _vm._v(" "), _c("switches")], 1), _vm._v(" "), _c("div", {
    staticClass: "col-md-2 text-right"
  }, [_c("br"), _vm._v(" "), _c("button", {
    staticClass: "btn btn-primary",
    attrs: {
      type: "button"
    },
    on: {
      click: _vm.saveTable
    }
  }, [_vm._v("\n      Save\n    ")])]), _vm._v(" "), _c("div", {
    staticClass: "col-12 mt-3"
  }, [_c("table", {
    staticClass: "table table-bordered"
  }, [_vm._m(0), _vm._v(" "), _c("tbody", _vm._l(_vm.table.columns, function (column, index) {
    return _c("database-table-row", {
      key: index,
      model: {
        value: _vm.table.columns[index],
        callback: function callback($$v) {
          _vm.$set(_vm.table.columns, index, $$v);
        },
        expression: "table.columns[index]"
      }
    });
  }), 1)])]), _vm._v(" "), _c("div", {
    staticClass: "col-12 text-center"
  }, [_c("button", {
    staticClass: "btn btn-success",
    attrs: {
      type: "button"
    },
    on: {
      click: _vm.addNewColumn
    }
  }, [_vm._v("\n      + New Column\n    ")]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-success",
    attrs: {
      type: "button"
    },
    on: {
      click: _vm.addTimestamps
    }
  }, [_vm._v("\n      + Add Timestamps\n    ")]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-success",
    attrs: {
      type: "button"
    }
  }, [_vm._v("+ Add Soft Deletes")]), _vm._v(" "), _c("button", {
    staticClass: "btn btn-success",
    attrs: {
      type: "button"
    }
  }, [_vm._v("+ Add Translations")])])]);
};

var staticRenderFns = [function () {
  var _vm = this,
      _c = _vm._self._c;

  return _c("thead", {
    staticClass: "thead-light"
  }, [_c("tr", [_c("th", [_vm._v("Name")]), _vm._v(" "), _c("th", [_vm._v("Type")]), _vm._v(" "), _c("th", [_vm._v("Length")]), _vm._v(" "), _c("th", [_vm._v("Default")]), _vm._v(" "), _c("th", [_vm._v("Unsigned")]), _vm._v(" "), _c("th", [_vm._v("Required")]), _vm._v(" "), _c("th", [_vm._v("A_I")]), _vm._v(" "), _c("th")])]);
}];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/components/developers/database/DatabaseTableEditor.vue":
/*!*****************************************************************************!*\
  !*** ./resources/js/components/developers/database/DatabaseTableEditor.vue ***!
  \*****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _DatabaseTableEditor_vue_vue_type_template_id_769092d2___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./DatabaseTableEditor.vue?vue&type=template&id=769092d2& */ "./resources/js/components/developers/database/DatabaseTableEditor.vue?vue&type=template&id=769092d2&");
/* harmony import */ var _DatabaseTableEditor_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./DatabaseTableEditor.vue?vue&type=script&lang=js& */ "./resources/js/components/developers/database/DatabaseTableEditor.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _DatabaseTableEditor_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _DatabaseTableEditor_vue_vue_type_template_id_769092d2___WEBPACK_IMPORTED_MODULE_0__.render,
  _DatabaseTableEditor_vue_vue_type_template_id_769092d2___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/developers/database/DatabaseTableEditor.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/developers/database/DatabaseTableEditor.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************!*\
  !*** ./resources/js/components/developers/database/DatabaseTableEditor.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_DatabaseTableEditor_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./DatabaseTableEditor.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/developers/database/DatabaseTableEditor.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_DatabaseTableEditor_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/developers/database/DatabaseTableEditor.vue?vue&type=template&id=769092d2&":
/*!************************************************************************************************************!*\
  !*** ./resources/js/components/developers/database/DatabaseTableEditor.vue?vue&type=template&id=769092d2& ***!
  \************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_DatabaseTableEditor_vue_vue_type_template_id_769092d2___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_DatabaseTableEditor_vue_vue_type_template_id_769092d2___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_DatabaseTableEditor_vue_vue_type_template_id_769092d2___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./DatabaseTableEditor.vue?vue&type=template&id=769092d2& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/developers/database/DatabaseTableEditor.vue?vue&type=template&id=769092d2&");


/***/ })

}]);