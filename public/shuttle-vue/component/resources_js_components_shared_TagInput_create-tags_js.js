"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_shared_TagInput_create-tags_js"],{

/***/ "./resources/js/components/shared/TagInput/create-tags.js":
/*!****************************************************************!*\
  !*** ./resources/js/components/shared/TagInput/create-tags.js ***!
  \****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "clone": () => (/* binding */ clone),
/* harmony export */   "createClasses": () => (/* binding */ createClasses),
/* harmony export */   "createTag": () => (/* binding */ createTag),
/* harmony export */   "createTags": () => (/* binding */ createTags)
/* harmony export */ });
// helper functions
var validateUserRules = function validateUserRules(tag, validation) {
  return validation.filter(function (val) {
    var text = tag.text; // if the rule is a string, we convert it to RegExp

    if (typeof val.rule === "string") return !new RegExp(val.rule).test(text);
    if (val.rule instanceof RegExp) return !val.rule.test(text); // if we deal with a function, invoke it

    var isFunction = {}.toString.call(val.rule) === "[object Function]";
    if (isFunction) return val.rule(tag);
  }).map(function (val) {
    return val.classes;
  });
};

var clone = function clone(node) {
  return JSON.parse(JSON.stringify(node));
};

var findIndex = function findIndex(arr, callback) {
  var index = 0;

  while (index < arr.length) {
    if (callback(arr[index], index, arr)) return index;
    index++;
  }

  return -1;
};

var createClasses = function createClasses(tag, tags) {
  var validation = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : [];
  var customDuplicateFn = arguments.length > 3 ? arguments[3] : undefined;
  if (tag.text === undefined) tag = {
    text: tag
  }; // create css classes from the user validation array

  var classes = validateUserRules(tag, validation); // if we find the tag, it's an exsting one which is edited.
  // in this case we must splice it out

  var index = findIndex(tags, function (t) {
    return t === tag;
  });
  var tagsDiff = clone(tags);
  var inputTag = index !== -1 ? tagsDiff.splice(index, 1)[0] : clone(tag); // check whether the tag is a duplicate or not

  var duplicate = customDuplicateFn ? customDuplicateFn(tagsDiff, inputTag) : tagsDiff.map(function (t) {
    return t.text;
  }).indexOf(inputTag.text) !== -1; // if it's a duplicate, push the class duplicate to the array

  if (duplicate) classes.push("ti-duplicate"); // if we find no classes, the tag is valid → push the class valid

  classes.length === 0 ? classes.push("ti-valid") : classes.push("ti-invalid");
  return classes;
};
/**
 * @description Create one tag out of a String or validate an existing one
 * @property {helpers}
 * @param {Object|String} tag A tag which should be validated | A String to create a tag
 * @param {Array} tagsarray The tags array
 * @param {Array} [validation=[]] The validation Array is optional (pass it if you use one)
 * @returns {Object} The created (validated) tag
 */


var createTag = function createTag(tag) {
  // if text is undefined, a string is passed. let's make a tag out of it
  if (tag.text === undefined) tag = {
    text: tag
  }; // we better make a clone to not getting reference trouble

  var t = clone(tag); // create the validation classes

  for (var _len = arguments.length, rest = new Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
    rest[_key - 1] = arguments[_key];
  }

  t.tiClasses = createClasses.apply(void 0, [tag].concat(rest));
  return t;
};
/**
   * @description Create multiple tags out of Strings or validate existing tags
   * @property {helpers}
   * @param {Array} tagsarray An Array containing tags or strings. See example below.
   * @param {Array} [validation=[]] The validation Array is optional (pass it if you use one)
   * @returns {Array} An array containing (validated) tags
   * @example  &#47;* Example to call the function *&#47;
     const validatedTags = createTags(['tag1Text', 'tag2Text'], [{ type: 'length', rule: /[0-9]/ }])
   */


var createTags = function createTags(tags) {
  for (var _len2 = arguments.length, rest = new Array(_len2 > 1 ? _len2 - 1 : 0), _key2 = 1; _key2 < _len2; _key2++) {
    rest[_key2 - 1] = arguments[_key2];
  }

  return tags.map(function (t) {
    return createTag.apply(void 0, [t, tags].concat(rest));
  });
};



/***/ })

}]);