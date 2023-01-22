"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_developers_component_Tabs_Data_ComponentTabData_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/developers/component/Tabs/Data/ComponentTabData.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/developers/component/Tabs/Data/ComponentTabData.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _mixin__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./mixin */ "./resources/js/components/developers/component/Tabs/Data/mixin.js");

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: {
    rows: {
      type: Array,
      value: []
    },
    modelSetting: {
      type: Object,
      "default": function _default() {
        return {};
      }
    }
  },
  computed: {
    myData: function myData() {
      return JSON.stringify(this.data);
    },
    myModelData: function myModelData() {
      return JSON.stringify(this.model);
    }
  },
  data: function data() {
    var _this$modelSetting;

    return {
      fromDatabase: this.modelSetting ? true : false,
      types: _mixin__WEBPACK_IMPORTED_MODULE_0__.store.state.types,
      model: (_this$modelSetting = this.modelSetting) !== null && _this$modelSetting !== void 0 ? _this$modelSetting : {},
      data: this.rows
    };
  },
  methods: {
    update: function update(obj, prop, event) {
      Vue.set(obj, prop, event.target.value);
    },
    addRow: function addRow() {
      this.data.push({
        field: "",
        type: "text",
        display_name: "",
        details: {},
        children: []
      });
    },
    addModelRow: function addModelRow() {
      this.model.conditions.push({
        field: "",
        type: "where",
        display_name: ""
      });
    },
    removeModelRow: function removeModelRow(key) {
      this.model.conditions.splice(key, 1);
    },
    removeRow: function removeRow(key) {
      this.data.splice(key, 1);
    },
    removeObjectFromData: function removeObjectFromData(obj, key2, key) {
      obj.children.splice(key2, 1);
    },
    addObjectToData: function addObjectToData(obj) {
      obj.children.push({
        field: "",
        type: "text",
        children: [],
        display_name: ""
      });
    },
    showResult: function showResult() {
      console.log(this.model);
    },
    getDefaultModelSetting: function getDefaultModelSetting() {
      return this.modelSetting ? JSON.parse(this.modelSetting).model : {
        name: "",
        order: "",
        conditions: [],
        limit: 0
      };
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/developers/component/Tabs/Data/ComponentTabData.vue?vue&type=template&id=6883af73&":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/developers/component/Tabs/Data/ComponentTabData.vue?vue&type=template&id=6883af73& ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm = this,
      _c = _vm._self._c;

  return _c("div", [_c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.fromDatabase,
      expression: "fromDatabase"
    }],
    attrs: {
      type: "checkbox"
    },
    domProps: {
      checked: Array.isArray(_vm.fromDatabase) ? _vm._i(_vm.fromDatabase, null) > -1 : _vm.fromDatabase
    },
    on: {
      change: function change($event) {
        var $$a = _vm.fromDatabase,
            $$el = $event.target,
            $$c = $$el.checked ? true : false;

        if (Array.isArray($$a)) {
          var $$v = null,
              $$i = _vm._i($$a, $$v);

          if ($$el.checked) {
            $$i < 0 && (_vm.fromDatabase = $$a.concat([$$v]));
          } else {
            $$i > -1 && (_vm.fromDatabase = $$a.slice(0, $$i).concat($$a.slice($$i + 1)));
          }
        } else {
          _vm.fromDatabase = $$c;
        }
      }
    }
  }), _vm._v(" Load data from database\n  "), _c("button", {
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.addRow.apply(null, arguments);
      }
    }
  }, [_vm._v("Add")]), _vm._v(" "), _c("ul", [_c("textarea", {
    attrs: {
      name: "myData",
      hidden: ""
    }
  }, [_vm._v(_vm._s(_vm.myData))]), _vm._v(" "), _vm._l(_vm.data, function (item, index) {
    return _c("li", {
      key: index
    }, [_c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: item.field,
        expression: "item.field"
      }],
      attrs: {
        name: "data[" + index + "][field]"
      },
      domProps: {
        value: item.field
      },
      on: {
        input: function input($event) {
          if ($event.target.composing) return;

          _vm.$set(item, "field", $event.target.value);
        }
      }
    }), _vm._v(" "), _c("select", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: item.type,
        expression: "item.type"
      }],
      attrs: {
        name: "data[" + index + "][type]"
      },
      on: {
        change: function change($event) {
          var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
            return o.selected;
          }).map(function (o) {
            var val = "_value" in o ? o._value : o.value;
            return val;
          });

          _vm.$set(item, "type", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
        }
      }
    }, _vm._l(_vm.types, function (type, tIndex) {
      return _c("option", {
        key: tIndex
      }, [_vm._v("\n          " + _vm._s(type) + "\n        ")]);
    }), 0), _vm._v(" "), _c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: item.display_name,
        expression: "item.display_name"
      }],
      domProps: {
        value: item.display_name
      },
      on: {
        input: function input($event) {
          if ($event.target.composing) return;

          _vm.$set(item, "display_name", $event.target.value);
        }
      }
    }), _vm._v(" "), item.type == "array" ? _c("component-tab-data-array", {
      attrs: {
        item: item,
        index: index
      },
      on: {
        "on-add-click": _vm.addObjectToData,
        "on-remove-click": _vm.removeObjectFromData
      }
    }) : _vm._e(), _vm._v(" "), item.type == "c_relationship" ? _c("div", [_vm._v("\n        type:\n        "), _c("input", {
      domProps: {
        value: item.details.type
      },
      on: {
        input: function input($event) {
          return _vm.update(item.details, "type", $event);
        }
      }
    }), _vm._v("\n        key:\n        "), _c("input", {
      domProps: {
        value: item.details.key
      },
      on: {
        input: function input($event) {
          return _vm.update(item.details, "key", $event);
        }
      }
    }), _vm._v("\n        label:\n        "), _c("input", {
      domProps: {
        value: item.details.label
      },
      on: {
        input: function input($event) {
          return _vm.update(item.details, "label", $event);
        }
      }
    }), _vm._v("\n        column:\n        "), _c("input", {
      domProps: {
        value: item.details.column
      },
      on: {
        input: function input($event) {
          return _vm.update(item.details, "column", $event);
        }
      }
    }), _vm._v("\n        model:\n        "), _c("input", {
      domProps: {
        value: item.details.model
      },
      on: {
        input: function input($event) {
          return _vm.update(item.details, "model", $event);
        }
      }
    }), _vm._v("\n        scope:\n        "), _c("input", {
      domProps: {
        value: item.details.scope
      },
      on: {
        input: function input($event) {
          return _vm.update(item.details, "scope", $event);
        }
      }
    })]) : _vm._e(), _vm._v(" "), _c("button", {
      on: {
        click: function click($event) {
          $event.preventDefault();
          return _vm.removeRow(index);
        }
      }
    }, [_vm._v("Remove")])], 1);
  })], 2), _vm._v(" "), _vm.fromDatabase ? _c("div", [_c("textarea", {
    attrs: {
      name: "myModelData"
    }
  }, [_vm._v(_vm._s(_vm.myModelData))]), _vm._v(" "), _c("button", {
    on: {
      click: function click($event) {
        $event.preventDefault();
        return _vm.addModelRow.apply(null, arguments);
      }
    }
  }, [_vm._v("Add")]), _vm._v(" "), _c("ul", _vm._l(_vm.model.conditions, function (item, index) {
    return _c("li", {
      key: index
    }, [_c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: item.field,
        expression: "item.field"
      }],
      domProps: {
        value: item.field
      },
      on: {
        input: function input($event) {
          if ($event.target.composing) return;

          _vm.$set(item, "field", $event.target.value);
        }
      }
    }), _vm._v(" "), _c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: item.type,
        expression: "item.type"
      }],
      domProps: {
        value: item.type
      },
      on: {
        input: function input($event) {
          if ($event.target.composing) return;

          _vm.$set(item, "type", $event.target.value);
        }
      }
    }), _vm._v(" "), _c("input", {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: item.display_name,
        expression: "item.display_name"
      }],
      domProps: {
        value: item.display_name
      },
      on: {
        input: function input($event) {
          if ($event.target.composing) return;

          _vm.$set(item, "display_name", $event.target.value);
        }
      }
    }), _vm._v(" "), _c("button", {
      on: {
        click: function click($event) {
          $event.preventDefault();
          return _vm.removeModelRow(index);
        }
      }
    }, [_vm._v("Remove")])]);
  }), 0), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.model.name,
      expression: "model.name"
    }],
    domProps: {
      value: _vm.model.name
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;

        _vm.$set(_vm.model, "name", $event.target.value);
      }
    }
  }), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.model.order,
      expression: "model.order"
    }],
    domProps: {
      value: _vm.model.order
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;

        _vm.$set(_vm.model, "order", $event.target.value);
      }
    }
  }), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.model.scope,
      expression: "model.scope"
    }],
    domProps: {
      value: _vm.model.scope
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;

        _vm.$set(_vm.model, "scope", $event.target.value);
      }
    }
  }), _vm._v(" "), _c("input", {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.model.limit,
      expression: "model.limit"
    }],
    domProps: {
      value: _vm.model.limit
    },
    on: {
      input: function input($event) {
        if ($event.target.composing) return;

        _vm.$set(_vm.model, "limit", $event.target.value);
      }
    }
  })]) : _vm._e()]);
};

var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/components/developers/component/Tabs/Data/mixin.js":
/*!*************************************************************************!*\
  !*** ./resources/js/components/developers/component/Tabs/Data/mixin.js ***!
  \*************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "store": () => (/* binding */ store)
/* harmony export */ });
var store = {
  state: {
    types: ["text", "array", "image", "rich_text_box", "svg", "text_area", "map", "model", "arrayModel", "c_relationship", "multiple_images", "tag"]
  }
};

/***/ }),

/***/ "./resources/js/components/developers/component/Tabs/Data/ComponentTabData.vue":
/*!*************************************************************************************!*\
  !*** ./resources/js/components/developers/component/Tabs/Data/ComponentTabData.vue ***!
  \*************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _ComponentTabData_vue_vue_type_template_id_6883af73___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ComponentTabData.vue?vue&type=template&id=6883af73& */ "./resources/js/components/developers/component/Tabs/Data/ComponentTabData.vue?vue&type=template&id=6883af73&");
/* harmony import */ var _ComponentTabData_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ComponentTabData.vue?vue&type=script&lang=js& */ "./resources/js/components/developers/component/Tabs/Data/ComponentTabData.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ComponentTabData_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ComponentTabData_vue_vue_type_template_id_6883af73___WEBPACK_IMPORTED_MODULE_0__.render,
  _ComponentTabData_vue_vue_type_template_id_6883af73___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/developers/component/Tabs/Data/ComponentTabData.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/developers/component/Tabs/Data/ComponentTabData.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************!*\
  !*** ./resources/js/components/developers/component/Tabs/Data/ComponentTabData.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ComponentTabData_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ComponentTabData.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/developers/component/Tabs/Data/ComponentTabData.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ComponentTabData_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/developers/component/Tabs/Data/ComponentTabData.vue?vue&type=template&id=6883af73&":
/*!********************************************************************************************************************!*\
  !*** ./resources/js/components/developers/component/Tabs/Data/ComponentTabData.vue?vue&type=template&id=6883af73& ***!
  \********************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ComponentTabData_vue_vue_type_template_id_6883af73___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ComponentTabData_vue_vue_type_template_id_6883af73___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_ComponentTabData_vue_vue_type_template_id_6883af73___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ComponentTabData.vue?vue&type=template&id=6883af73& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/developers/component/Tabs/Data/ComponentTabData.vue?vue&type=template&id=6883af73&");


/***/ })

}]);