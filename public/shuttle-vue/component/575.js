"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[575],{5575:(t,s,e)=>{e.r(s),e.d(s,{default:()=>o});var a=e(1485),i=e.n(a);e(5353);const l={props:{uploadUrl:{type:String,required:!0}},components:{vueDropzone:i()},data:function(){return{dropzoneOptions:{url:this.uploadUrl,headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}},files:[],isMultiple:!1,reqRef:""}},methods:{onHashParams:function(t){var s=(_.find(t,(function(t){return"multiple"===t.key}))||{}).value;this.reqRef=(_.find(t,(function(t){return"ref"===t.key}))||{}).value,s&&(this.isMultiple=!0)},successUpload:function(t,s){this.$refs.myVueDropzone.removeFile(t),this.files.push(s)},imageSelected:function(t,s){this.isMultiple||(eventBus.$emit("imageSelected",s,this.reqRef),this.$refs.mediaLibraryModal.closeModal())}}};const o=(0,e(1900).Z)(l,(function(){var t=this,s=t._self._c;return s("hash-modal",{ref:"mediaLibraryModal",attrs:{"modal-id":"media-library-modal",parentClass:"modal-right select-from-library2"},on:{onHashParams:t.onHashParams}},[s("div",{staticClass:"modal-header"},[s("h5",{staticClass:"modal-title"},[t._v("Select from Library")]),t._v(" "),s("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal","aria-label":"Close"}},[s("span",{attrs:{"aria-hidden":"true"}},[t._v("×")])])]),t._v(" "),s("div",{staticClass:"modal-body scroll pt-0 pb-0 mt-4 mb-4"},[s("div",{staticClass:"mb-2"},[s("div",{staticClass:"row"},[s("div",{staticClass:"col-12"},[s("vue-dropzone",{ref:"myVueDropzone",attrs:{id:"dropzone",options:t.dropzoneOptions},on:{"vdropzone-success":t.successUpload}})],1)]),t._v(" "),s("div",{staticClass:"list disable-text-selection mt-3"},[s("div",{staticClass:"row"},t._l(t.files,(function(e,a){return s("div",{key:a+"file",staticClass:"col-6 mb-1"},[s("div",{staticClass:"card d-flex mb-2 p-0 media-thumb-container"},[s("div",{staticClass:"d-flex align-self-stretch"},[s("img",{staticClass:"list-media-thumbnail responsive border-0",attrs:{src:e.url,alt:"uploaded image"}})]),t._v(" "),s("div",{staticClass:"d-flex flex-grow-1 min-width-zero"},[s("div",{staticClass:"card-body pr-1 pt-2 pb-2 align-self-center d-flex min-width-zero"},[s("div",{staticClass:"w-100"},[s("p",{staticClass:"truncate mb-0"},[t._v("chocolate-cake-thumb.jpg")])])]),t._v(" "),s("div",{staticClass:"custom-control custom-checkbox pl-1 pr-1 align-self-center"},[s("label",{staticClass:"custom-control custom-checkbox mb-0"},[s("input",{staticClass:"custom-control-input",attrs:{type:"checkbox"},on:{change:function(s){return t.imageSelected(s,e)}}}),t._v(" "),s("span",{staticClass:"custom-control-label"})])])])])])})),0)])])]),t._v(" "),t.isMultiple?s("div",{staticClass:"modal-footer"},[s("button",{staticClass:"btn btn-outline-primary",attrs:{type:"button","data-dismiss":"modal"}},[t._v("\n      Cancel\n    ")]),t._v(" "),s("button",{staticClass:"btn btn-primary sfl-submit",attrs:{type:"button"}},[t._v("Select")])]):t._e()])}),[],!1,null,null,null).exports}}]);