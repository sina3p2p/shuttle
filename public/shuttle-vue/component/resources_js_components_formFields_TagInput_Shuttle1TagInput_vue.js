"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_formFields_TagInput_Shuttle1TagInput_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/formFields/TagInput/Shuttle1TagInput.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/formFields/TagInput/Shuttle1TagInput.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var fast_deep_equal__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! fast-deep-equal */ "./node_modules/fast-deep-equal/index.js");
/* harmony import */ var fast_deep_equal__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(fast_deep_equal__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vuedraggable__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vuedraggable */ "./node_modules/vuedraggable/dist/vuedraggable.umd.js");
/* harmony import */ var vuedraggable__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(vuedraggable__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _create_tags__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./create-tags */ "./resources/js/components/formFields/TagInput/create-tags.js");
/* harmony import */ var _vue_tags_input_props__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./vue-tags-input.props */ "./resources/js/components/formFields/TagInput/vue-tags-input.props.js");
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }





/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: _vue_tags_input_props__WEBPACK_IMPORTED_MODULE_3__["default"],
  components: {
    draggable: (vuedraggable__WEBPACK_IMPORTED_MODULE_1___default())
  },
  data: function data() {
    return {
      newTag: null,
      tagsCopy: null,
      tagsEditStatus: null,
      deletionMark: null,
      deletionMarkTime: null,
      selectedItem: null,
      focused: null
    };
  },
  computed: {
    // Property which calculates if the autocomplete should be opened or not
    autocompleteOpen: function autocompleteOpen() {
      if (this.autocompleteAlwaysOpen) return true;
      return this.newTag !== null && this.newTag.length >= this.autocompleteMinLength && this.filteredAutocompleteItems.length > 0 && this.focused;
    },
    // Returns validated autocomplete items. Maybe duplicates are filtered out
    filteredAutocompleteItems: function filteredAutocompleteItems() {
      var _this = this;

      var is = this.autocompleteItems.map(function (i) {
        return (0,_create_tags__WEBPACK_IMPORTED_MODULE_2__.createTag)(i, _this.tags, _this.validation, _this.isDuplicate);
      });
      if (!this.autocompleteFilterDuplicates) return is;
      return is.filter(this.duplicateFilter);
    }
  },
  methods: {
    createClasses: _create_tags__WEBPACK_IMPORTED_MODULE_2__.createClasses,
    // Returns the index which item should be selected, based on the parameter 'method'
    getSelectedIndex: function getSelectedIndex(method) {
      var items = this.filteredAutocompleteItems;
      var selectedItem = this.selectedItem;
      var lastItem = items.length - 1;
      if (items.length === 0) return;
      if (selectedItem === null) return 0;
      if (method === "before" && selectedItem === 0) return lastItem;else if (method === "after" && selectedItem === lastItem) return 0;else return method === "after" ? selectedItem + 1 : selectedItem - 1;
    },
    selectDefaultItem: function selectDefaultItem() {
      if (this.addOnlyFromAutocomplete && this.filteredAutocompleteItems.length > 0) {
        this.selectedItem = 0;
      } else this.selectedItem = null;
    },
    selectItem: function selectItem(e, method) {
      e.preventDefault();
      this.selectedItem = this.getSelectedIndex(method);
    },
    isSelected: function isSelected(index) {
      return this.selectedItem === index;
    },
    isMarked: function isMarked(index) {
      return this.deletionMark === index;
    },
    // Method which is called when the user presses backspace → remove the last tag
    invokeDelete: function invokeDelete() {
      var _this2 = this;

      // If we shouldn't delete tags on backspace or we have some characters in the input → stop
      if (!this.deleteOnBackspace || this.newTag.length > 0) return;
      var lastIndex = this.tagsCopy.length - 1;

      if (this.deletionMark === null) {
        this.deletionMarkTime = setTimeout(function () {
          return _this2.deletionMark = null;
        }, 1000);
        this.deletionMark = lastIndex;
      } else this.performDeleteTag(lastIndex);
    },
    addTagsFromPaste: function addTagsFromPaste() {
      var _this3 = this;

      if (!this.addFromPaste) return;
      setTimeout(function () {
        return _this3.performAddTags(_this3.newTag);
      }, 10);
    },
    // Method to call if a tag should switch to it's edit mode
    performEditTag: function performEditTag(index) {
      var _this4 = this;

      if (!this.allowEditTags) return;
      if (!this._events["before-editing-tag"]) this.editTag(index);
      /**
       * @description Emits before a tag toggles to it's edit mode
       * @name before-editing-tag
       * @property {events} hook
       * @returns {Object} Contains the to editing tag: 'tag'.
         The tag's index: 'index'. And a function: 'editTag'.
         If the function is invoked, the tag toggles to it's edit mode.
       */

      this.$emit("before-editing-tag", {
        index: index,
        tag: this.tagsCopy[index],
        editTag: function editTag() {
          return _this4.editTag(index);
        }
      });
    },
    // Opens the edit mode for a tag and focuses it
    editTag: function editTag(index) {
      if (!this.allowEditTags) return;
      this.toggleEditMode(index);
      this.focus(index);
    },
    // Toggles the edit mode for a tag
    toggleEditMode: function toggleEditMode(index) {
      if (!this.allowEditTags || this.disabled) return;
      this.$set(this.tagsEditStatus, index, !this.tagsEditStatus[index]);
    },
    // only called by the @input event from TagInput.
    // Creates a new tag model and applys it to this.tagsCopy[index]
    createChangedTag: function createChangedTag(index, event) {
      // If the text of a tag changes → we create a new one with a new validation.
      // we take the value from the event if possible, because on google android phones
      // this.tagsCopy[index].text is incorrect, when typing a space on the virtual keyboard.
      // yes, this sucks ...
      var tag = this.tagsCopy[index];
      tag.text = event ? event.target.value : this.tagsCopy[index].text;
      this.$set(this.tagsCopy, index, (0,_create_tags__WEBPACK_IMPORTED_MODULE_2__.createTag)(tag, this.tagsCopy, this.validation, this.isDuplicate));
    },
    // Focuses the input of a tag
    focus: function focus(index) {
      var _this5 = this;

      this.$nextTick(function () {
        var el = _this5.$refs.tagCenter[index].querySelector("input.ti-tag-input");

        if (el) el.focus();
      });
    },
    quote: function quote(regex) {
      return regex.replace(/([()[{*+.$^\\|?])/g, "\\$1");
    },
    // Cancels the edit mode for a tag → resets the tag to it's original model!
    cancelEdit: function cancelEdit(index) {
      if (!this.tags[index]) return;
      this.tagsCopy[index] = (0,_create_tags__WEBPACK_IMPORTED_MODULE_2__.clone)((0,_create_tags__WEBPACK_IMPORTED_MODULE_2__.createTag)(this.tags[index], this.tags, this.validation, this.isDuplicate));
      this.$set(this.tagsEditStatus, index, false);
    },
    hasForbiddingAddRule: function hasForbiddingAddRule(tiClasses) {
      var _this6 = this;

      // Does the tag has a rule, defined by the user, which prohibits adding?
      return tiClasses.some(function (type) {
        var rule = _this6.validation.find(function (rule) {
          return type === rule.classes;
        });

        return rule ? rule.disableAdd : false;
      });
    },
    // Creates multiple tags out of a string, based on the prop separators
    createTagTexts: function createTagTexts(string) {
      var _this7 = this;

      var regex = new RegExp(this.separators.map(function (s) {
        return _this7.quote(s);
      }).join("|"));
      return string.split(regex).map(function (text) {
        return {
          text: text
        };
      });
    },
    // Method to call to delete a tag
    performDeleteTag: function performDeleteTag(index) {
      var _this8 = this;

      if (!this._events["before-deleting-tag"]) this.deleteTag(index);
      /**
       * @description Emits before a tag is deleted
       * @name before-deleting-tag
       * @property {events} hook
       * @returns {Object} Contains the to editing tag: 'tag'. The tag's index: 'index'
         And a function: 'deleteTag'. If the function is invoked, the tag is deleted.
       */

      this.$emit("before-deleting-tag", {
        index: index,
        tag: this.tagsCopy[index],
        deleteTag: function deleteTag() {
          return _this8.deleteTag(index);
        }
      });
    },
    deleteTag: function deleteTag(index) {
      if (this.disabled) return;
      this.deletionMark = null; // Clears the debounce for the deletion mark and removes the tag

      clearTimeout(this.deletionMarkTime);
      this.tagsCopy.splice(index, 1); // Special update for the parent if .sync is on

      if (this._events["update:tags"]) this.$emit("update:tags", this.tagsCopy);
      /**
       * @description Emits if the tags array changes
       * @name tags-changed
       * @property {events}
       * @returns {Array} The modified tags array
       */

      this.$emit("tags-changed", this.tagsCopy);
    },
    // Decides wether the input keyCode is one, which is allowed to modify/add tags
    noTriggerKey: function noTriggerKey(event, category) {
      var triggerKey = this[category].indexOf(event.keyCode) !== -1 || this[category].indexOf(event.key) !== -1;
      if (triggerKey) event.preventDefault();
      return !triggerKey;
    },
    // Method to call to add a tag
    performAddTags: function performAddTags(tag, event, source) {
      var _this9 = this;

      // If the input is disabled or the function was invoked by no trigger key → stop
      if (this.disabled || event && this.noTriggerKey(event, "addOnKey")) return; // Convert the string or object into a tags array

      var tags = [];
      if (_typeof(tag) === "object") tags = [tag];
      if (typeof tag === "string") tags = this.createTagTexts(tag); // Filter out the tags with no content

      tags = tags.filter(function (tag) {
        return tag.text.trim().length > 0;
      }); // The basic checks are done → try to add all tags

      tags.forEach(function (tag) {
        tag = (0,_create_tags__WEBPACK_IMPORTED_MODULE_2__.createTag)(tag, _this9.tags, _this9.validation, _this9.isDuplicate);
        if (!_this9._events["before-adding-tag"]) _this9.addTag(tag, source);
        /**
         * @description Emits before a tag is added
         * @name before-adding-tag
         * @property {events} hook
         * @returns {Object} Contains the to editing tag: 'tag'. And a function: 'addTag'.
           If the function is invoked, the tag is added.
         */

        _this9.$emit("before-adding-tag", {
          tag: tag,
          addTag: function addTag() {
            return _this9.addTag(tag, source);
          }
        });
      });
      this.newTag = "";
    },
    duplicateFilter: function duplicateFilter(tag) {
      return this.isDuplicate ? !this.isDuplicate(this.tagsCopy, tag) : !this.tagsCopy.find(function (t) {
        return t.text === tag.text;
      });
    },
    addTag: function addTag(tag) {
      var _this10 = this;

      var source = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : "new-tag-input";
      // Check if we should only add items from autocomplete and if so,
      // does the tag exists as an option
      var options = this.filteredAutocompleteItems.map(function (i) {
        return i.text;
      });
      if (this.addOnlyFromAutocomplete && options.indexOf(tag.text) === -1) return; // We use $nextTick here, because this.tagsCopy.length would be wrong if tags are added fast
      // like in a loop. With $nextTick we get the correct length value

      this.$nextTick(function () {
        // Maybe we should not add a tag because the maximum has reached already
        var maximumReached = _this10.maxTags && _this10.maxTags <= _this10.tagsCopy.length;
        /**
         * @description Emits if the maximum, the tags array is allowed to hold, is reached.
           The maximum can be defined by the prop 'max-tags'.
         * @name max-tags-reached
         * @property {events}
         * @returns {Object} The 'tag' which could not be added because of the length limitation.
         */

        if (maximumReached) return _this10.$emit("max-tags-reached", tag); // If we shouldn't add duplicates and that is one → stop

        var dup = _this10.avoidAddingDuplicates && !_this10.duplicateFilter(tag);
        /**
         * @description Emits if the user tries to add a duplicate to the tag's array
           and adding duplicates is prevented by the prop 'avoid-adding-duplicates'
         * @name adding-duplicate
         * @property {events}
         */

        if (dup) return _this10.$emit("adding-duplicate", tag); // If we find a rule which avoids that the tag is added → stop

        if (_this10.hasForbiddingAddRule(tag.tiClasses)) return; // Everything is okay → add the tag

        _this10.$emit("input", "");

        _this10.tagsCopy.push(tag); // Special update for the parent if .sync is on


        if (_this10._events["update:tags"]) _this10.$emit("update:tags", _this10.tagsCopy); // if the tag was added by autocomplete, focus the input

        if (source === "autocomplete") _this10.$refs.newTagInput.focus();

        _this10.$emit("tags-changed", _this10.tagsCopy);
      });
    },
    // Method to call to save a tag
    performSaveTag: function performSaveTag(index, event) {
      var _this11 = this;

      var tag = this.tagsCopy[index]; // If the input is disabled or the function was invoked by no trigger key → stop

      if (this.disabled || event && this.noTriggerKey(event, "addOnKey")) return; // If the tag has no content → stop

      if (tag.text.trim().length === 0) return; // The basic checks are done → try to save the tag

      if (!this._events["before-saving-tag"]) this.saveTag(index, tag);
      /**
       * @description Emits before a tag is saved
       * @name before-saving-tag
       * @property {events} hook
       * @returns {Object} Contains the to editing tag: 'tag'.
         The tag's index: 'index'. And a function: 'saveTag'.
         If the function is invoked, the tag is saved.
       */

      this.$emit("before-saving-tag", {
        index: index,
        tag: tag,
        saveTag: function saveTag() {
          return _this11.saveTag(index, tag);
        }
      });
    },
    saveTag: function saveTag(index, tag) {
      // If we shouldn't save duplicates → stop
      if (this.avoidAddingDuplicates) {
        var tagsDiff = (0,_create_tags__WEBPACK_IMPORTED_MODULE_2__.clone)(this.tagsCopy);
        var inputTag = tagsDiff.splice(index, 1)[0];
        var dup = this.isDuplicate ? this.isDuplicate(tagsDiff, inputTag) : tagsDiff.map(function (t) {
          return t.text;
        }).indexOf(inputTag.text) !== -1;
        /**
         * @description Emits if the user tries to save a duplicate in the tag's array
           and saving duplicates is prevented by the prop 'avoid-adding-duplicates'
         * @name saving-duplicate
         * @property {events}
         */

        if (dup) return this.$emit("saving-duplicate", tag);
      } // If we find a rule which avoids that the tag is added → stop


      if (this.hasForbiddingAddRule(tag.tiClasses)) return; // Everything is okay → save the tag

      this.$set(this.tagsCopy, index, tag);
      this.toggleEditMode(index); // Special update for the parent if .sync is on

      if (this._events["update:tags"]) this.$emit("update:tags", this.tagsCopy);
      this.$emit("tags-changed", this.tagsCopy);
    },
    tagsEqual: function tagsEqual() {
      var _this12 = this;

      return !this.tagsCopy.some(function (t, i) {
        return !fast_deep_equal__WEBPACK_IMPORTED_MODULE_0___default()(t, _this12.tags[i]);
      });
    },
    updateNewTag: function updateNewTag(ievent) {
      var value = ievent.target.value;
      this.newTag = value;
      this.$emit("input", value);
    },
    initTags: function initTags() {
      // We always work with a copy of the "real" tags, to easier edit them
      this.tagsCopy = (0,_create_tags__WEBPACK_IMPORTED_MODULE_2__.createTags)(this.tags, this.validation, this.isDuplicate); // Let's create an array which defines whether a tag is in edit mode or not

      this.tagsEditStatus = (0,_create_tags__WEBPACK_IMPORTED_MODULE_2__.clone)(this.tags).map(function () {
        return false;
      }); // We check if the original and the copied and validated tags are equal →
      // Update the parent if not and sync is on.

      if (this._events["update:tags"] && !this.tagsEqual()) {
        this.$emit("update:tags", this.tagsCopy);
      }
    },
    blurredOnClick: function blurredOnClick(e) {
      // if the click occurs on tagsinput → don't hide
      if (this.$el.contains(e.target) || this.$el.contains(document.activeElement)) return;
      this.performBlur(e);
    },
    performBlur: function performBlur() {
      // If we should add tags before blurring → add tag
      if (this.addOnBlur && this.focused) this.performAddTags(this.newTag); // Hide autocomplete layer

      this.focused = false;
    }
  },
  watch: {
    value: function value(newValue) {
      // If v-model change outside, update the newTag model
      if (!this.addOnlyFromAutocomplete) this.selectedItem = null;
      this.newTag = newValue;
    },
    tags: {
      handler: function handler() {
        // If the tags change outside, update the tagsCopy model
        this.initTags();
      },
      deep: true
    },
    autocompleteOpen: "selectDefaultItem"
  },
  created: function created() {
    this.newTag = this.value;
    this.initTags();
  },
  mounted: function mounted() {
    // We select a default item based on props in the autocomplete
    this.selectDefaultItem(); // We add a event listener to hide autocomplete on blur

    document.addEventListener("click", this.blurredOnClick);
  },
  destroyed: function destroyed() {
    document.removeEventListener("click", this.blurredOnClick);
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/formFields/TagInput/Shuttle1TagInput.vue?vue&type=template&id=4c850780&scoped=true&":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/formFields/TagInput/Shuttle1TagInput.vue?vue&type=template&id=4c850780&scoped=true& ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
    staticClass: "vue-tags-input",
    "class": [{
      "ti-disabled": _vm.disabled
    }, {
      "ti-focus": _vm.focused
    }]
  }, [_c("div", {
    staticClass: "ti-input"
  }, [_vm.tagsCopy ? _c("draggable", {
    staticClass: "ti-tags",
    attrs: {
      tag: "ul",
      list: _vm.tagsCopy
    }
  }, [_vm._l(_vm.tagsCopy, function (tag, index) {
    return _c("li", {
      key: index,
      staticClass: "ti-tag",
      "class": [{
        "ti-editing": _vm.tagsEditStatus[index]
      }, tag.tiClasses, tag.classes, {
        "ti-deletion-mark": _vm.isMarked(index)
      }],
      style: tag.style,
      attrs: {
        tabindex: "0"
      },
      on: {
        click: function click($event) {
          return _vm.$emit("tag-clicked", {
            tag: tag,
            index: index
          });
        }
      }
    }, [_c("div", {
      staticClass: "ti-content"
    }, [_vm.$scopedSlots["tag-left"] ? _c("div", {
      staticClass: "ti-tag-left"
    }, [_vm._t("tag-left", null, {
      tag: tag,
      index: index,
      edit: _vm.tagsEditStatus[index],
      performSaveEdit: _vm.performSaveTag,
      performDelete: _vm.performDeleteTag,
      performCancelEdit: _vm.cancelEdit,
      performOpenEdit: _vm.performEditTag,
      deletionMark: _vm.isMarked(index)
    })], 2) : _vm._e(), _vm._v(" "), _c("div", {
      ref: "tagCenter",
      refInFor: true,
      staticClass: "ti-tag-center"
    }, [!_vm.$scopedSlots["tag-center"] ? _c("span", {
      "class": {
        "ti-hidden": _vm.tagsEditStatus[index]
      },
      on: {
        click: function click($event) {
          return _vm.performEditTag(index);
        }
      }
    }, [_c("input", {
      attrs: {
        name: "".concat(_vm.name, "[]"),
        hidden: ""
      },
      domProps: {
        value: tag.text
      }
    }), _vm._v("\n              " + _vm._s(tag.text))]) : _vm._e(), _vm._v(" "), !_vm.$scopedSlots["tag-center"] ? _c("tag-input", {
      attrs: {
        scope: {
          edit: _vm.tagsEditStatus[index],
          maxlength: _vm.maxlength,
          tag: tag,
          index: index,
          validateTag: _vm.createChangedTag,
          performCancelEdit: _vm.cancelEdit,
          performSaveEdit: _vm.performSaveTag
        }
      }
    }) : _vm._e(), _vm._v(" "), _vm._t("tag-center", null, {
      tag: tag,
      index: index,
      maxlength: _vm.maxlength,
      edit: _vm.tagsEditStatus[index],
      performSaveEdit: _vm.performSaveTag,
      performDelete: _vm.performDeleteTag,
      performCancelEdit: _vm.cancelEdit,
      validateTag: _vm.createChangedTag,
      performOpenEdit: _vm.performEditTag,
      deletionMark: _vm.isMarked(index)
    })], 2), _vm._v(" "), _vm.$scopedSlots["tag-right"] ? _c("div", {
      staticClass: "ti-tag-right"
    }, [_vm._t("tag-right", null, {
      tag: tag,
      index: index,
      edit: _vm.tagsEditStatus[index],
      performSaveEdit: _vm.performSaveTag,
      performDelete: _vm.performDeleteTag,
      performCancelEdit: _vm.cancelEdit,
      performOpenEdit: _vm.performEditTag,
      deletionMark: _vm.isMarked(index)
    })], 2) : _vm._e()]), _vm._v(" "), _c("div", {
      staticClass: "ti-actions"
    }, [!_vm.$scopedSlots["tag-actions"] ? _c("i", {
      directives: [{
        name: "show",
        rawName: "v-show",
        value: _vm.tagsEditStatus[index],
        expression: "tagsEditStatus[index]"
      }],
      staticClass: "iconsminds-undo",
      on: {
        click: function click($event) {
          return _vm.cancelEdit(index);
        }
      }
    }) : _vm._e(), _vm._v(" "), !_vm.$scopedSlots["tag-actions"] ? _c("i", {
      directives: [{
        name: "show",
        rawName: "v-show",
        value: !_vm.tagsEditStatus[index],
        expression: "!tagsEditStatus[index]"
      }],
      staticClass: "iconsminds-close",
      on: {
        click: function click($event) {
          return _vm.performDeleteTag(index);
        }
      }
    }) : _vm._e(), _vm._v(" "), _vm.$scopedSlots["tag-actions"] ? _vm._t("tag-actions", null, {
      tag: tag,
      index: index,
      edit: _vm.tagsEditStatus[index],
      performSaveEdit: _vm.performSaveTag,
      performDelete: _vm.performDeleteTag,
      performCancelEdit: _vm.cancelEdit,
      performOpenEdit: _vm.performEditTag,
      deletionMark: _vm.isMarked(index)
    }) : _vm._e()], 2)]);
  }), _vm._v(" "), _c("li", {
    staticClass: "ti-new-tag-input-wrapper"
  }, [_c("input", _vm._b({
    ref: "newTagInput",
    staticClass: "ti-new-tag-input",
    "class": [_vm.createClasses(_vm.newTag, _vm.tags, _vm.validation, _vm.isDuplicate)],
    attrs: {
      placeholder: _vm.placeholder,
      maxlength: _vm.maxlength,
      disabled: _vm.disabled,
      type: "text",
      size: "1"
    },
    domProps: {
      value: _vm.newTag
    },
    on: {
      keydown: [function ($event) {
        return _vm.performAddTags(_vm.filteredAutocompleteItems[_vm.selectedItem] || _vm.newTag, $event);
      }, function ($event) {
        if (!$event.type.indexOf("key") && $event.keyCode !== 8) return null;
        return _vm.invokeDelete.apply(null, arguments);
      }, function ($event) {
        if (!$event.type.indexOf("key") && $event.keyCode !== 9) return null;
        return _vm.performBlur.apply(null, arguments);
      }, function ($event) {
        if (!$event.type.indexOf("key") && $event.keyCode !== 38) return null;
        return _vm.selectItem($event, "before");
      }, function ($event) {
        if (!$event.type.indexOf("key") && $event.keyCode !== 40) return null;
        return _vm.selectItem($event, "after");
      }],
      paste: _vm.addTagsFromPaste,
      input: _vm.updateNewTag,
      blur: function blur($event) {
        return _vm.$emit("blur", $event);
      },
      focus: function focus($event) {
        _vm.focused = true;

        _vm.$emit("focus", $event);
      },
      click: function click($event) {
        _vm.addOnlyFromAutocomplete ? false : _vm.selectedItem = null;
      }
    }
  }, "input", _vm.$attrs, false))])], 2) : _vm._e()], 1), _vm._v(" "), _vm._t("between-elements"), _vm._v(" "), _vm.autocompleteOpen ? _c("div", {
    staticClass: "ti-autocomplete",
    on: {
      mouseout: function mouseout($event) {
        _vm.selectedItem = null;
      }
    }
  }, [_vm._t("autocomplete-header"), _vm._v(" "), _c("ul", _vm._l(_vm.filteredAutocompleteItems, function (item, index) {
    return _c("li", {
      key: index,
      staticClass: "ti-item",
      "class": [item.tiClasses, item.classes, {
        "ti-selected-item": _vm.isSelected(index)
      }],
      style: item.style,
      on: {
        mouseover: function mouseover($event) {
          _vm.disabled ? false : _vm.selectedItem = index;
        }
      }
    }, [!_vm.$scopedSlots["autocomplete-item"] ? _c("div", {
      on: {
        click: function click($event) {
          return _vm.performAddTags(item, undefined, "autocomplete");
        }
      }
    }, [_vm._v("\n          " + _vm._s(item.text) + "\n        ")]) : _vm._t("autocomplete-item", null, {
      item: item,
      index: index,
      performAdd: function performAdd(item) {
        return _vm.performAddTags(item, undefined, "autocomplete");
      },
      selected: _vm.isSelected(index)
    })], 2);
  }), 0), _vm._v(" "), _vm._t("autocomplete-footer")], 2) : _vm._e()], 2);
};

var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/js/components/formFields/TagInput/create-tags.js":
/*!********************************************************************!*\
  !*** ./resources/js/components/formFields/TagInput/create-tags.js ***!
  \********************************************************************/
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



/***/ }),

/***/ "./resources/js/components/formFields/TagInput/vue-tags-input.props.js":
/*!*****************************************************************************!*\
  !*** ./resources/js/components/formFields/TagInput/vue-tags-input.props.js ***!
  \*****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
// The file contains all props and validators which are provided by the component
var propValidatorTag = function propValidatorTag(value) {
  return !value.some(function (t) {
    var invalidText = !t.text;
    if (invalidText) console.warn('Missing property "text"', t);
    var invalidClasses = false;
    if (t.classes) invalidClasses = typeof t.classes !== "string";
    if (invalidClasses) console.warn('Property "classes" must be type of string', t);
    return invalidText || invalidClasses;
  });
};

var propValidatorStringNumeric = function propValidatorStringNumeric(value) {
  return !value.some(function (v) {
    if (typeof v === "number") {
      var numeric = isFinite(v) && Math.floor(v) === v;
      if (!numeric) console.warn("Only numerics are allowed for this prop. Found:", v);
      return !numeric;
    } else if (typeof v === "string") {
      /*
       * Regex: || Not totally fool-proof yet, still matches "0a" and such
       * - allow non-word characters (aka symbols e.g. ;, :, ' etc)
       * - allow alpha characters
       * - deny numbers
       */
      var string = /\W|[a-z]|!\d/i.test(v);
      if (!string) console.warn("Only alpha strings are allowed for this prop. Found:", v);
      return !string;
    } else {
      console.warn("Only numeric and string values are allowed. Found:", v);
      return false;
    }
  });
};

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  /**
     * @description Property to bind a model to the input.
       If the user changes the input value, the model updates, too.
       If the user presses enter with an valid input,
       a new tag is created with the value of this model.
       After creating the new tag, the model is cleared.
     * @property {props}
     * @required
     * @type {String}
     * @model
     * @default ''
     */
  value: {
    type: String,
    "default": "",
    required: true
  },

  /**
     * @description Pass an array containing objects like in the example below.
       The properties 'style' and 'class' are optional. Of course it is possible to add custom
       properties to a tag object. vue-tags-input won't change the key and value.
     * @property {props}
     * @type {Array}
     * @sync
     * @default []
     * @example
      {
      &emsp;text: 'My tag value', &#47;* The visible text on display *&#47;
      &emsp;style: 'background-color: #ccc', &#47;* Adding inline styles is possible *&#47;
      &emsp;classes: 'custom-class another', &#47;* The value will be added as css classes *&#47;
      }
     */
  tags: {
    type: Array,
    "default": function _default() {
      return [];
    } // validator: propValidatorTag,

  },

  /**
     * @description Expects an array containing objects inside. The objects
      can have the same properties as a tag object.
     * @property {props}
     * @type {Array}
     * @default []
     */
  autocompleteItems: {
    type: Array,
    "default": function _default() {
      return [];
    },
    validator: propValidatorTag
  },

  /**
   * @description Defines whether a tag is editable after creation or not.
   * @property {props}
   * @type {Boolean}
   * @default false
   */
  allowEditTags: {
    type: Boolean,
    "default": false
  },

  /**
   * @description Defines if duplicate autocomplete items are filtered out from the view or not.
   * @property {props}
   * @type {Boolean}
   * @default true
   */
  autocompleteFilterDuplicates: {
    "default": true,
    type: Boolean
  },

  /**
   * @description If it's true, the user can add tags only via the autocomplete layer.
   * @property {props}
   * @type {Boolean}
   * @default false
   */
  addOnlyFromAutocomplete: {
    type: Boolean,
    "default": false
  },

  /**
     * @description The minimum character length which is required
       until the autocomplete layer is shown. If set to 0,
       then it'll be shown on focus.
     * @property {props}
     * @type {Number}
     * @default 1
     */
  autocompleteMinLength: {
    type: Number,
    "default": 1
  },

  /**
     * @description If it's true, the autocomplete layer is always shown, regardless if
       an input or an autocomplete items exists.
     * @property {props}
     * @type {Boolean}
     * @default false
     */
  autocompleteAlwaysOpen: {
    type: Boolean,
    "default": false
  },

  /**
   * @description Property to disable vue-tags-input.
   * @property {props}
   * @type {Boolean}
   * @default false
   */
  disabled: {
    type: Boolean,
    "default": false
  },

  /**
   * @description The placeholder text which is shown in the input, when it's empty.
   * @property {props}
   * @type {String}
   * @default Add Tag
   */
  placeholder: {
    type: String,
    "default": "Add Tag"
  },

  /**
     * @description Custom trigger key codes can be registrated. If the user presses one of these,
       a tag will be generated out of the input value. Can be either a numeric keyCode or the key
       as a string.
     * @property {props}
     * @type {Array}
     * @default [13]
     * @example add-on-key="[13, ':', ';']"
     */
  addOnKey: {
    type: Array,
    "default": function _default() {
      return [13];
    },
    validator: propValidatorStringNumeric
  },

  /**
     * @description Custom trigger key codes can be registrated. If the user edits a tag
       and presses one of these, the edited tag will be saved.
       Can be either a numeric keyCode or the key as a string.
     * @property {props}
     * @type {Array}
     * @default [13]
     * @example save-on-key="[13, ':', ';']"
     */
  saveOnKey: {
    type: Array,
    "default": function _default() {
      return [13];
    },
    validator: propValidatorStringNumeric
  },

  /**
   * @description The maximum amount the tags array is allowed to hold.
   * @property {props}
   * @type {Number}
   */
  maxTags: {
    type: Number
  },

  /**
   * @description The maximum amount of characters the input is allowed to hold.
   * @property {props}
   * @type {Number}
   */
  maxlength: {
    type: Number
  },

  /**
     * @description Pass an array containing objects like in the example below.
       The property 'classes' will be added as css classes, if the property 'rule' matches the text
       of a tag, an autocomplete item or the input. The property 'rule' can be type of
       RegExp or function. If the property 'disableAdd' is 'true', the item can't be added
       to the tags array, if the appropriated rule matches.
     * @property {props}
     * @type {Array}
     * @default []
     * @example
      {
      &ensp;classes: 'class', &#47;* css class *&#47;
      &ensp;rule: /^([^0-9]*)$/, &#47;* RegExp *&#47;
      }, {
      &ensp;classes: 'no-braces', &#47;* css class *&#47;
      &ensp;rule(text) { &#47;* function with text as param *&#47;
      &ensp;&ensp;return text.indexOf('{') !== -1 || text.indexOf('}') !== -1;
      &ensp;},
      &ensp;disableAdd: true, &#47;* if the rule matches, the item cannot be added *&#47;,
      },
     */
  validation: {
    type: Array,
    "default": function _default() {
      return [];
    },
    validator: function validator(value) {
      return !value.some(function (v) {
        var missingRule = !v.rule;
        if (missingRule) console.warn('Property "rule" is missing', v);
        var validRule = v.rule && (typeof v.rule === "string" || v.rule instanceof RegExp || {}.toString.call(v.rule) === "[object Function]");

        if (!validRule) {
          console.warn("A rule must be type of string, RegExp or function. Found:", JSON.stringify(v.rule));
        }

        var missingClasses = !v.classes;
        if (missingClasses) console.warn('Property "classes" is missing', v);
        var invalidType = v.type && typeof v.type !== "string";
        if (invalidType) console.warn('Property "type" must be type of string. Found:', v);
        return !validRule || missingRule || missingClasses || invalidType;
      });
    }
  },

  /**
     * @description Defines the characters which splits a text into different pieces,
       to generate tags out of this pieces.
     * @property {props}
     * @type {Array}
     * @default [';']
     * @example
       separators: [';', ',']
       input: some; user input, has random; commas, an,d semicolons
       will split into: some - user input - has random - commas - an - d semicolons
     */
  separators: {
    type: Array,
    "default": function _default() {
      return [";"];
    },
    validator: function validator(value) {
      return !value.some(function (s) {
        var invalidType = typeof s !== "string";
        if (invalidType) console.warn("Separators must be type of string. Found:", s);
        return invalidType;
      });
    }
  },

  /**
     * @description If it's true, the user can't add or save a tag,
       if another exists, with the same text value.
     * @property {props}
     * @type {Boolean}
     * @default true
     */
  avoidAddingDuplicates: {
    type: Boolean,
    "default": true
  },

  /**
     * @description If the input holds a value and loses the focus,
       a tag will be generated out of this value, if possible.
     * @property {props}
     * @type {Boolean}
     * @default true
     */
  addOnBlur: {
    type: Boolean,
    "default": true
  },

  /**
     * @description Custom function to detect duplicates. If the function returns 'true',
      the tag will be marked as duplicate.
     * @property {props}
     * @type {Function}
     * @param {Array} tagsarray The Array of tags minus the one which is edited/created.
     * @param {Object} tag The tag which is edited or should be added to the tags array.
     * @example
       // The duplicate function to recreate the default behaviour, would look like this:
       isDuplicate(tags, tag) {
       &ensp;return tags.map(t => t.text).indexOf(tag.text) !== -1;
      }
     */
  isDuplicate: {
    type: Function,
    "default": null
  },

  /**
     * @description If it's true, the user can paste into the input element and
       vue-tags-input will create tags out of the incoming text.
     * @property {props}
     * @type {Boolean}
     * @default true
     */
  addFromPaste: {
    type: Boolean,
    "default": true
  },

  /**
     * @description Defines if it's possible to delete tags by pressing backspace.
       If so and the user wants to delete a tag,
       the tag gets the css class 'deletion-mark' for 1 second.
       If the user presses backspace again in that time period,
       the tag is removed from the tags array and the view.
     * @property {props}
     * @type {Boolean}
     * @default true
     */
  deleteOnBackspace: {
    "default": true,
    type: Boolean
  },
  name: {
    "default": "",
    type: String
  }
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-11.use[3]!./resources/js/components/formFields/TagInput/vue-tags-input.scss?vue&type=style&index=0&id=4c850780&lang=scss&scoped=true&":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-11.use[3]!./resources/js/components/formFields/TagInput/vue-tags-input.scss?vue&type=style&index=0&id=4c850780&lang=scss&scoped=true& ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
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
___CSS_LOADER_EXPORT___.push([module.id, "ul[data-v-4c850780] {\n  margin: 0px;\n  padding: 0px;\n  list-style-type: none;\n}\n*[data-v-4c850780],\n*[data-v-4c850780]:before,\n*[data-v-4c850780]:after {\n  box-sizing: border-box;\n}\ninput[data-v-4c850780]:focus {\n  outline: none;\n}\ninput[disabled][data-v-4c850780] {\n  background-color: transparent;\n}\ndiv.vue-tags-input.disabled[data-v-4c850780] {\n  opacity: 0.5;\n}\ndiv.vue-tags-input.disabled *[data-v-4c850780] {\n  cursor: default;\n}\n.ti-input[data-v-4c850780] {\n  display: flex;\n  flex-wrap: wrap;\n  border-radius: 0.1rem;\n  outline: initial !important;\n  box-shadow: initial !important;\n  font-size: 0.8rem;\n  padding: 0.35rem 0.75rem;\n  line-height: 1;\n  border: 1px solid #d7d7d7;\n  background: white;\n  color: #3a3a3a;\n  border-color: #d7d7d7;\n  min-height: calc(2em + 0.8rem);\n}\n.ti-tags[data-v-4c850780] {\n  display: flex;\n  flex-wrap: wrap;\n  width: 100%;\n  line-height: 1em;\n  height: 100%;\n}\n.ti-tag[data-v-4c850780] {\n  background-color: #5c6bc0;\n  color: #fff;\n  border-radius: 2px;\n  display: flex;\n  padding: 3px 5px;\n  margin-right: 2px;\n  margin-top: 1px;\n  margin-bottom: 1px;\n  font-size: 0.8rem;\n}\n.ti-tag[data-v-4c850780]:focus {\n  outline: none;\n}\n.ti-tag .ti-content[data-v-4c850780] {\n  display: flex;\n  align-items: center;\n}\n.ti-tag .ti-tag-center[data-v-4c850780] {\n  position: relative;\n}\n.ti-tag span[data-v-4c850780] {\n  line-height: 0.85em;\n}\n.ti-tag span.ti-hidden[data-v-4c850780] {\n  padding-left: 14px;\n  visibility: hidden;\n  height: 0px;\n  white-space: pre;\n}\n.ti-tag .ti-actions[data-v-4c850780] {\n  margin-left: 2px;\n  display: flex;\n  align-items: center;\n  font-size: 1.15em;\n}\n.ti-tag .ti-actions i[data-v-4c850780] {\n  cursor: pointer;\n}\n.ti-tag[data-v-4c850780]:last-child {\n  margin-right: 4px;\n}\n.ti-tag.ti-invalid[data-v-4c850780], .ti-tag.ti-tag.ti-deletion-mark[data-v-4c850780] {\n  background-color: #e54d42;\n}\n.ti-new-tag-input-wrapper[data-v-4c850780] {\n  display: flex;\n  flex: 1 0 auto;\n  padding: 3px 5px;\n  margin: 2px;\n  font-size: 0.8rem;\n}\n.ti-new-tag-input-wrapper input[data-v-4c850780] {\n  flex: 1 0 auto;\n  min-width: 100px;\n  border: none;\n  padding: 0px;\n  margin: 0px;\n}\n.ti-new-tag-input[data-v-4c850780] {\n  line-height: initial;\n}\n.ti-autocomplete[data-v-4c850780] {\n  border: 1px solid #ccc;\n  border-top: none;\n  position: absolute;\n  width: 100%;\n  background-color: #fff;\n  z-index: 20;\n}\n.ti-item > div[data-v-4c850780] {\n  cursor: pointer;\n  padding: 3px 6px;\n  width: 100%;\n}\n.ti-selected-item[data-v-4c850780] {\n  background-color: #5c6bc0;\n  color: #fff;\n}", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-11.use[3]!./resources/js/components/formFields/TagInput/vue-tags-input.scss?vue&type=style&index=0&id=4c850780&lang=scss&scoped=true&":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-11.use[3]!./resources/js/components/formFields/TagInput/vue-tags-input.scss?vue&type=style&index=0&id=4c850780&lang=scss&scoped=true& ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_11_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_11_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_11_use_3_vue_tags_input_scss_vue_type_style_index_0_id_4c850780_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!../../../../../node_modules/sass-loader/dist/cjs.js??clonedRuleSet-11.use[3]!./vue-tags-input.scss?vue&type=style&index=0&id=4c850780&lang=scss&scoped=true& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-11.use[3]!./resources/js/components/formFields/TagInput/vue-tags-input.scss?vue&type=style&index=0&id=4c850780&lang=scss&scoped=true&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_11_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_11_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_11_use_3_vue_tags_input_scss_vue_type_style_index_0_id_4c850780_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_11_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_11_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_11_use_3_vue_tags_input_scss_vue_type_style_index_0_id_4c850780_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./resources/js/components/formFields/TagInput/Shuttle1TagInput.vue":
/*!**************************************************************************!*\
  !*** ./resources/js/components/formFields/TagInput/Shuttle1TagInput.vue ***!
  \**************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Shuttle1TagInput_vue_vue_type_template_id_4c850780_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Shuttle1TagInput.vue?vue&type=template&id=4c850780&scoped=true& */ "./resources/js/components/formFields/TagInput/Shuttle1TagInput.vue?vue&type=template&id=4c850780&scoped=true&");
/* harmony import */ var _Shuttle1TagInput_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Shuttle1TagInput.vue?vue&type=script&lang=js& */ "./resources/js/components/formFields/TagInput/Shuttle1TagInput.vue?vue&type=script&lang=js&");
/* harmony import */ var _vue_tags_input_scss_vue_type_style_index_0_id_4c850780_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./vue-tags-input.scss?vue&type=style&index=0&id=4c850780&lang=scss&scoped=true& */ "./resources/js/components/formFields/TagInput/vue-tags-input.scss?vue&type=style&index=0&id=4c850780&lang=scss&scoped=true&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _Shuttle1TagInput_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Shuttle1TagInput_vue_vue_type_template_id_4c850780_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _Shuttle1TagInput_vue_vue_type_template_id_4c850780_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "4c850780",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/formFields/TagInput/Shuttle1TagInput.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/formFields/TagInput/Shuttle1TagInput.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/components/formFields/TagInput/Shuttle1TagInput.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Shuttle1TagInput_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Shuttle1TagInput.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/formFields/TagInput/Shuttle1TagInput.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Shuttle1TagInput_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/formFields/TagInput/Shuttle1TagInput.vue?vue&type=template&id=4c850780&scoped=true&":
/*!*********************************************************************************************************************!*\
  !*** ./resources/js/components/formFields/TagInput/Shuttle1TagInput.vue?vue&type=template&id=4c850780&scoped=true& ***!
  \*********************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Shuttle1TagInput_vue_vue_type_template_id_4c850780_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Shuttle1TagInput_vue_vue_type_template_id_4c850780_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Shuttle1TagInput_vue_vue_type_template_id_4c850780_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Shuttle1TagInput.vue?vue&type=template&id=4c850780&scoped=true& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/formFields/TagInput/Shuttle1TagInput.vue?vue&type=template&id=4c850780&scoped=true&");


/***/ }),

/***/ "./resources/js/components/formFields/TagInput/vue-tags-input.scss?vue&type=style&index=0&id=4c850780&lang=scss&scoped=true&":
/*!***********************************************************************************************************************************!*\
  !*** ./resources/js/components/formFields/TagInput/vue-tags-input.scss?vue&type=style&index=0&id=4c850780&lang=scss&scoped=true& ***!
  \***********************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_11_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_11_use_2_node_modules_sass_loader_dist_cjs_js_clonedRuleSet_11_use_3_vue_tags_input_scss_vue_type_style_index_0_id_4c850780_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader/dist/cjs.js!../../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!../../../../../node_modules/sass-loader/dist/cjs.js??clonedRuleSet-11.use[3]!./vue-tags-input.scss?vue&type=style&index=0&id=4c850780&lang=scss&scoped=true& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-11.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-11.use[2]!./node_modules/sass-loader/dist/cjs.js??clonedRuleSet-11.use[3]!./resources/js/components/formFields/TagInput/vue-tags-input.scss?vue&type=style&index=0&id=4c850780&lang=scss&scoped=true&");


/***/ })

}]);