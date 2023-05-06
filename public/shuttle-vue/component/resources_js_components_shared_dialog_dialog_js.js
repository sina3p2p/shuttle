"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_shared_dialog_dialog_js"],{

/***/ "./resources/js/components/shared/dialog/dialog.js":
/*!*********************************************************!*\
  !*** ./resources/js/components/shared/dialog/dialog.js ***!
  \*********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm.js");

var state = vue__WEBPACK_IMPORTED_MODULE_0__["default"].observable({
  type: "alert",
  active: false,
  message: ""
}); //-----------------------------------
// Private Methods
//-----------------------------------

var close; // will hold our promise resolve function

var dialogPromise = function dialogPromise() {
  return new Promise(function (resolve) {
    return close = resolve;
  });
};

var open = function open(message) {
  state.message = message;
  state.active = true;
  return dialogPromise();
};

var reset = function reset() {
  state.active = false;
  state.message = "";
  state.type = "alert";
}; //-----------------------------------
// Public interface
//-----------------------------------


var dialog = {
  get state() {
    return state;
  },

  alert: function alert(message) {
    state.type = "alert";
    return open(message);
  },
  confirm: function confirm(message) {
    state.type = "confirm";
    return open(message);
  },
  prompt: function prompt(message) {
    state.type = "prompt";
    return open(message);
  },
  cancel: function cancel() {
    close(false);
    reset();
  },
  ok: function ok() {
    var input = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : true;
    input = state.type === "prompt" ? input : true;
    close(input);
    reset();
  }
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (dialog);

/***/ })

}]);