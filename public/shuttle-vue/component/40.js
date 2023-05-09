"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[40,31,86],{2031:(t,e,a)=>{a.r(e),a.d(e,{clone:()=>n,createClasses:()=>r,createTag:()=>o,createTags:()=>l});var i=function(t,e){return e.filter((function(e){var a=t.text;return"string"==typeof e.rule?!new RegExp(e.rule).test(a):e.rule instanceof RegExp?!e.rule.test(a):"[object Function]"==={}.toString.call(e.rule)?e.rule(t):void 0})).map((function(t){return t.classes}))},n=function(t){return JSON.parse(JSON.stringify(t))},s=function(t,e){for(var a=0;a<t.length;){if(e(t[a],a,t))return a;a++}return-1},r=function(t,e){var a=arguments.length>2&&void 0!==arguments[2]?arguments[2]:[],r=arguments.length>3?arguments[3]:void 0;void 0===t.text&&(t={text:t});var o=i(t,a),l=s(e,(function(e){return e===t})),d=n(e),c=-1!==l?d.splice(l,1)[0]:n(t),u=r?r(d,c):-1!==d.map((function(t){return t.text})).indexOf(c.text);return u&&o.push("ti-duplicate"),0===o.length?o.push("ti-valid"):o.push("ti-invalid"),o},o=function(t){void 0===t.text&&(t={text:t});for(var e=n(t),a=arguments.length,i=new Array(a>1?a-1:0),s=1;s<a;s++)i[s-1]=arguments[s];return e.tiClasses=r.apply(void 0,[t].concat(i)),e},l=function(t){for(var e=arguments.length,a=new Array(e>1?e-1:0),i=1;i<e;i++)a[i-1]=arguments[i];return t.map((function(e){return o.apply(void 0,[e,t].concat(a))}))}},1086:(t,e,a)=>{a.r(e),a.d(e,{default:()=>n});var i=function(t){return!t.some((function(t){if("number"==typeof t){var e=isFinite(t)&&Math.floor(t)===t;return e||console.warn("Only numerics are allowed for this prop. Found:",t),!e}if("string"==typeof t){var a=/\W|[a-z]|!\d/i.test(t);return a||console.warn("Only alpha strings are allowed for this prop. Found:",t),!a}return console.warn("Only numeric and string values are allowed. Found:",t),!1}))};const n={value:{type:[Array,String],default:"",required:!0},autocompleteItems:{type:Array,default:function(){return[]},validator:function(t){return!t.some((function(t){var e=!t.text;e&&console.warn('Missing property "text"',t);var a=!1;return t.classes&&(a="string"!=typeof t.classes),a&&console.warn('Property "classes" must be type of string',t),e||a}))}},allowEditTags:{type:Boolean,default:!1},autocompleteFilterDuplicates:{default:!0,type:Boolean},addOnlyFromAutocomplete:{type:Boolean,default:!1},autocompleteMinLength:{type:Number,default:1},autocompleteAlwaysOpen:{type:Boolean,default:!1},disabled:{type:Boolean,default:!1},placeholder:{type:String,default:"Add Tag"},addOnKey:{type:Array,default:function(){return[13]},validator:i},saveOnKey:{type:Array,default:function(){return[13]},validator:i},maxTags:{type:Number},maxlength:{type:Number},validation:{type:Array,default:function(){return[]},validator:function(t){return!t.some((function(t){var e=!t.rule;e&&console.warn('Property "rule" is missing',t);var a=t.rule&&("string"==typeof t.rule||t.rule instanceof RegExp||"[object Function]"==={}.toString.call(t.rule));a||console.warn("A rule must be type of string, RegExp or function. Found:",JSON.stringify(t.rule));var i=!t.classes;i&&console.warn('Property "classes" is missing',t);var n=t.type&&"string"!=typeof t.type;return n&&console.warn('Property "type" must be type of string. Found:',t),!a||e||i||n}))}},separators:{type:Array,default:function(){return[";"]},validator:function(t){return!t.some((function(t){var e="string"!=typeof t;return e&&console.warn("Separators must be type of string. Found:",t),e}))}},avoidAddingDuplicates:{type:Boolean,default:!0},addOnBlur:{type:Boolean,default:!0},isDuplicate:{type:Function,default:null},addFromPaste:{type:Boolean,default:!0},deleteOnBackspace:{default:!0,type:Boolean},name:{default:"",type:String}}},9678:(t,e,a)=>{a.d(e,{Z:()=>s});var i=a(3645),n=a.n(i)()((function(t){return t[1]}));n.push([t.id,"ul[data-v-0c8e11c3]{list-style-type:none;margin:0;padding:0}*[data-v-0c8e11c3],[data-v-0c8e11c3]:after,[data-v-0c8e11c3]:before{box-sizing:border-box}input[data-v-0c8e11c3]:focus{outline:none}input[disabled][data-v-0c8e11c3]{background-color:transparent}div.vue-tags-input.disabled[data-v-0c8e11c3]{opacity:.5}div.vue-tags-input.disabled *[data-v-0c8e11c3]{cursor:default}.ti-input[data-v-0c8e11c3]{background:#fff;border:1px solid #d7d7d7;border-radius:.1rem;box-shadow:none!important;color:#3a3a3a;font-size:.8rem;line-height:1;min-height:calc(2em + .8rem);outline:initial!important;padding:.35rem .75rem}.ti-input[data-v-0c8e11c3],.ti-tags[data-v-0c8e11c3]{display:flex;flex-wrap:wrap}.ti-tags[data-v-0c8e11c3]{height:100%;line-height:1em;width:100%}.ti-tag[data-v-0c8e11c3]{background-color:#5c6bc0;border-radius:2px;color:#fff;display:flex;font-size:.8rem;margin-bottom:1px;margin-right:2px;margin-top:1px;padding:3px 5px}.ti-tag[data-v-0c8e11c3]:focus{outline:none}.ti-tag .ti-content[data-v-0c8e11c3]{align-items:center;display:flex}.ti-tag .ti-tag-center[data-v-0c8e11c3]{position:relative}.ti-tag span[data-v-0c8e11c3]{line-height:.85em}.ti-tag span.ti-hidden[data-v-0c8e11c3]{height:0;padding-left:14px;visibility:hidden;white-space:pre}.ti-tag .ti-actions[data-v-0c8e11c3]{align-items:center;display:flex;font-size:1.15em;margin-left:2px}.ti-tag .ti-actions i[data-v-0c8e11c3]{cursor:pointer}.ti-tag[data-v-0c8e11c3]:last-child{margin-right:4px}.ti-tag.ti-invalid[data-v-0c8e11c3],.ti-tag.ti-tag.ti-deletion-mark[data-v-0c8e11c3]{background-color:#e54d42}.ti-new-tag-input-wrapper[data-v-0c8e11c3]{display:flex;flex:1 0 auto;font-size:.8rem;margin:2px;padding:3px 5px}.ti-new-tag-input-wrapper input[data-v-0c8e11c3]{border:none;flex:1 0 auto;margin:0;min-width:100px;padding:0}.ti-new-tag-input[data-v-0c8e11c3]{line-height:normal}.ti-autocomplete[data-v-0c8e11c3]{background-color:#fff;border:1px solid #ccc;border-top:none;position:absolute;width:100%;z-index:20}.ti-item>div[data-v-0c8e11c3]{cursor:pointer;padding:3px 6px;width:100%}.ti-selected-item[data-v-0c8e11c3]{background-color:#5c6bc0;color:#fff}",""]);const s=n},7040:(t,e,a)=>{a.r(e),a.d(e,{default:()=>f});var i=a(4063),n=a.n(i),s=a(9980),r=a.n(s),o=a(2031);function l(t){return l="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},l(t)}const d={props:a(1086).default,components:{draggable:r()},data:function(){return{newTag:null,tagsCopy:null,tagsEditStatus:null,deletionMark:null,deletionMarkTime:null,selectedItem:null,focused:null,tags:[]}},methods:{createClasses:o.createClasses,getSelectedIndex:function(t){var e=this.filteredAutocompleteItems,a=this.selectedItem,i=e.length-1;if(0!==e.length)return null===a?0:"before"===t&&0===a?i:"after"===t&&a===i?0:"after"===t?a+1:a-1},selectItem:function(t,e){t.preventDefault(),this.selectedItem=this.getSelectedIndex(e)},isSelected:function(t){return this.selectedItem===t},isMarked:function(t){return this.deletionMark===t},invokeDelete:function(){var t=this;if(this.deleteOnBackspace&&!(this.newTag.length>0)){var e=this.tagsCopy.length-1;null===this.deletionMark?(this.deletionMarkTime=setTimeout((function(){return t.deletionMark=null}),1e3),this.deletionMark=e):this.performDeleteTag(e)}},addTagsFromPaste:function(){var t=this;this.addFromPaste&&setTimeout((function(){return t.performAddTags(t.newTag)}),10)},performEditTag:function(t){var e=this;this.allowEditTags&&(this._events["before-editing-tag"]||this.editTag(t),this.$emit("before-editing-tag",{index:t,tag:this.tagsCopy[t],editTag:function(){return e.editTag(t)}}))},editTag:function(t){this.allowEditTags&&(this.toggleEditMode(t),this.focus(t))},toggleEditMode:function(t){this.allowEditTags&&!this.disabled&&this.$set(this.tagsEditStatus,t,!this.tagsEditStatus[t])},createChangedTag:function(t,e){var a=this.tagsCopy[t];a.text=e?e.target.value:this.tagsCopy[t].text,this.$set(this.tagsCopy,t,(0,o.createTag)(a,this.tagsCopy,this.validation,this.isDuplicate))},focus:function(t){var e=this;this.$nextTick((function(){var a=e.$refs.tagCenter[t].querySelector("input.ti-tag-input");a&&a.focus()}))},quote:function(t){return t.replace(/([()[{*+.$^\\|?])/g,"\\$1")},cancelEdit:function(t){this.tags[t]&&(this.tagsCopy[t]=(0,o.clone)((0,o.createTag)(this.tags[t],this.tags,this.validation,this.isDuplicate)),this.$set(this.tagsEditStatus,t,!1))},hasForbiddingAddRule:function(t){var e=this;return t.some((function(t){var a=e.validation.find((function(e){return t===e.classes}));return!!a&&a.disableAdd}))},createTagTexts:function(t){var e=this,a=new RegExp(this.separators.map((function(t){return e.quote(t)})).join("|"));return t.split(a).map((function(t){return{text:t}}))},performDeleteTag:function(t){var e=this;this._events["before-deleting-tag"]||this.deleteTag(t),this.$emit("before-deleting-tag",{index:t,tag:this.tagsCopy[t],deleteTag:function(){return e.deleteTag(t)}})},deleteTag:function(t){this.disabled||(this.deletionMark=null,clearTimeout(this.deletionMarkTime),this.tagsCopy.splice(t,1),this._events["update:tags"]&&this.$emit("update:tags",this.tagsCopy),this.$emit("tags-changed",this.tagsCopy))},noTriggerKey:function(t,e){var a=-1!==this[e].indexOf(t.keyCode)||-1!==this[e].indexOf(t.key);return a&&t.preventDefault(),!a},performAddTags:function(t,e,a){var i=this;if(!(this.disabled||e&&this.noTriggerKey(e,"addOnKey"))){var n=[];"object"===l(t)&&(n=[t]),"string"==typeof t&&(n=this.createTagTexts(t)),n=n.filter((function(t){return t.text.trim().length>0})),n.forEach((function(t){t=(0,o.createTag)(t,i.tags,i.validation,i.isDuplicate),i._events["before-adding-tag"]||i.addTag(t,a),i.$emit("before-adding-tag",{tag:t,addTag:function(){return i.addTag(t,a)}})})),this.newTag=""}},duplicateFilter:function(t){return this.isDuplicate?!this.isDuplicate(this.tagsCopy,t):!this.tagsCopy.find((function(e){return e.text===t.text}))},addTag:function(t){var e=this,a=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"new-tag-input";this.$nextTick((function(){return e.maxTags&&e.maxTags<=e.tagsCopy.length?e.$emit("max-tags-reached",t):e.avoidAddingDuplicates&&!e.duplicateFilter(t)?e.$emit("adding-duplicate",t):void(e.hasForbiddingAddRule(t.tiClasses)||(e.$emit("input",""),e.tagsCopy.push(t),e._events["update:tags"]&&e.$emit("update:tags",e.tagsCopy),"autocomplete"===a&&e.$refs.newTagInput.focus(),e.$emit("tags-changed",e.tagsCopy)))}))},performSaveTag:function(t,e){var a=this,i=this.tagsCopy[t];this.disabled||e&&this.noTriggerKey(e,"addOnKey")||0!==i.text.trim().length&&(this._events["before-saving-tag"]||this.saveTag(t,i),this.$emit("before-saving-tag",{index:t,tag:i,saveTag:function(){return a.saveTag(t,i)}}))},saveTag:function(t,e){if(this.avoidAddingDuplicates){var a=(0,o.clone)(this.tagsCopy),i=a.splice(t,1)[0];if(this.isDuplicate?this.isDuplicate(a,i):-1!==a.map((function(t){return t.text})).indexOf(i.text))return this.$emit("saving-duplicate",e)}this.hasForbiddingAddRule(e.tiClasses)||(this.$set(this.tagsCopy,t,e),this.toggleEditMode(t),this._events["update:tags"]&&this.$emit("update:tags",this.tagsCopy),this.$emit("tags-changed",this.tagsCopy))},tagsEqual:function(){var t=this;return!this.tagsCopy.some((function(e,a){return!n()(e,t.tags[a])}))},updateNewTag:function(t){var e=t.target.value;this.newTag=e,this.$emit("input",e)},initTags:function(){this.tagsCopy=(0,o.createTags)(this.tags,this.validation,this.isDuplicate),this.tagsEditStatus=(0,o.clone)(this.tags).map((function(){return!1})),this._events["update:tags"]&&!this.tagsEqual()&&this.$emit("update:tags",this.tagsCopy)},blurredOnClick:function(t){this.$el.contains(t.target)||this.$el.contains(document.activeElement)||this.performBlur(t)},performBlur:function(){this.addOnBlur&&this.focused&&this.performAddTags(this.newTag),this.focused=!1}},watch:{},created:function(){("string"==typeof this.value||this.value instanceof String)&&0!==this.value.trim().length?this.tags=this.value.split(","):this.value&&this.value.length&&(this.tags=this.value),this.newTag="",this.initTags()},mounted:function(){document.addEventListener("click",this.blurredOnClick)},destroyed:function(){document.removeEventListener("click",this.blurredOnClick)}};var c=a(3379),u=a.n(c),g=a(9678),p={insert:"head",singleton:!1};u()(g.Z,p);g.Z.locals;const f=(0,a(1900).Z)(d,(function(){var t=this,e=t._self._c;return e("div",{staticClass:"vue-tags-input",class:[{"ti-disabled":t.disabled},{"ti-focus":t.focused}]},[e("div",{staticClass:"ti-input"},[t.tagsCopy?e("draggable",{staticClass:"ti-tags",attrs:{tag:"ul",list:t.tagsCopy}},[t._l(t.tagsCopy,(function(a,i){return e("li",{key:i,staticClass:"ti-tag",class:[{"ti-editing":t.tagsEditStatus[i]},a.tiClasses,a.classes,{"ti-deletion-mark":t.isMarked(i)}],style:a.style,attrs:{tabindex:"0"},on:{click:function(e){return t.$emit("tag-clicked",{tag:a,index:i})}}},[e("div",{staticClass:"ti-content"},[t.$scopedSlots["tag-left"]?e("div",{staticClass:"ti-tag-left"},[t._t("tag-left",null,{tag:a,index:i,edit:t.tagsEditStatus[i],performSaveEdit:t.performSaveTag,performDelete:t.performDeleteTag,performCancelEdit:t.cancelEdit,performOpenEdit:t.performEditTag,deletionMark:t.isMarked(i)})],2):t._e(),t._v(" "),e("div",{ref:"tagCenter",refInFor:!0,staticClass:"ti-tag-center"},[t.$scopedSlots["tag-center"]?t._e():e("span",{class:{"ti-hidden":t.tagsEditStatus[i]},on:{click:function(e){return t.performEditTag(i)}}},[e("input",{attrs:{name:"".concat(t.name,"[]"),hidden:""},domProps:{value:a.text}}),t._v("\n              "+t._s(a.text))]),t._v(" "),t.$scopedSlots["tag-center"]?t._e():e("shuttle-tag-input",{attrs:{scope:{edit:t.tagsEditStatus[i],maxlength:t.maxlength,tag:a,index:i,validateTag:t.createChangedTag,performCancelEdit:t.cancelEdit,performSaveEdit:t.performSaveTag}}}),t._v(" "),t._t("tag-center",null,{tag:a,index:i,maxlength:t.maxlength,edit:t.tagsEditStatus[i],performSaveEdit:t.performSaveTag,performDelete:t.performDeleteTag,performCancelEdit:t.cancelEdit,validateTag:t.createChangedTag,performOpenEdit:t.performEditTag,deletionMark:t.isMarked(i)})],2),t._v(" "),t.$scopedSlots["tag-right"]?e("div",{staticClass:"ti-tag-right"},[t._t("tag-right",null,{tag:a,index:i,edit:t.tagsEditStatus[i],performSaveEdit:t.performSaveTag,performDelete:t.performDeleteTag,performCancelEdit:t.cancelEdit,performOpenEdit:t.performEditTag,deletionMark:t.isMarked(i)})],2):t._e()]),t._v(" "),e("div",{staticClass:"ti-actions"},[t.$scopedSlots["tag-actions"]?t._e():e("i",{directives:[{name:"show",rawName:"v-show",value:t.tagsEditStatus[i],expression:"tagsEditStatus[index]"}],staticClass:"iconsminds-undo",on:{click:function(e){return t.cancelEdit(i)}}}),t._v(" "),t.$scopedSlots["tag-actions"]?t._e():e("i",{directives:[{name:"show",rawName:"v-show",value:!t.tagsEditStatus[i],expression:"!tagsEditStatus[index]"}],staticClass:"iconsminds-close",on:{click:function(e){return t.performDeleteTag(i)}}}),t._v(" "),t.$scopedSlots["tag-actions"]?t._t("tag-actions",null,{tag:a,index:i,edit:t.tagsEditStatus[i],performSaveEdit:t.performSaveTag,performDelete:t.performDeleteTag,performCancelEdit:t.cancelEdit,performOpenEdit:t.performEditTag,deletionMark:t.isMarked(i)}):t._e()],2)])})),t._v(" "),e("li",{staticClass:"ti-new-tag-input-wrapper"},[e("input",t._b({ref:"newTagInput",staticClass:"ti-new-tag-input",class:[t.createClasses(t.newTag,t.tags,t.validation,t.isDuplicate)],attrs:{placeholder:t.placeholder,maxlength:t.maxlength,disabled:t.disabled,type:"text",size:"1"},domProps:{value:t.newTag},on:{keydown:[function(e){return t.performAddTags(t.newTag,e)},function(e){return e.type.indexOf("key")||8===e.keyCode?t.invokeDelete.apply(null,arguments):null},function(e){return e.type.indexOf("key")||9===e.keyCode?t.performBlur.apply(null,arguments):null},function(e){return e.type.indexOf("key")||38===e.keyCode?t.selectItem(e,"before"):null},function(e){return e.type.indexOf("key")||40===e.keyCode?t.selectItem(e,"after"):null}],paste:t.addTagsFromPaste,input:t.updateNewTag,blur:function(e){return t.$emit("blur",e)},focus:function(e){t.focused=!0,t.$emit("focus",e)},click:function(e){!t.addOnlyFromAutocomplete&&(t.selectedItem=null)}}},"input",t.$attrs,!1))])],2):t._e()],1),t._v(" "),t._t("between-elements")],2)}),[],!1,null,"0c8e11c3",null).exports}}]);