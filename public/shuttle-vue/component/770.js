"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[770],{770:(e,t,i)=>{i.r(t),i.d(t,{default:()=>r});var l=i(7632),s=i(7727),a=i.n(s);const n={props:{name:{type:String,default:""},path:{type:String,default:null},preview:{type:String,default:null}},data:function(){return{selected:null,value:"",uuid:(0,l.Z)()}},watch:{path:function(){this.initValue()},preview:function(){this.initValue()}},mounted:function(){eventBus.$on("imageSelected",this.imageSelected),this.initValue()},methods:{initValue:function(){this.path&&this.preview&&(this.selected={url:this.preview,path:this.path},this.value=this.path,this.$nextTick((function(){a()({})})))},imageSelected:function(e,t){t==this.uuid&&(this.selected=e,this.value=e.path)},removeFile:function(){this.selected=null,this.value=null}}};const r=(0,i(1900).Z)(n,(function(){var e=this,t=e._self._c;return t("div",{staticClass:"select-from-library-container mb-1"},[t("div",{staticClass:"row"},[t("div",{staticClass:"col-12"},[e.value?t("div",{staticClass:"selected-library-item"},[t("input",{attrs:{name:e.name,hidden:""},domProps:{value:e.value}}),e._v(" "),t("div",{staticClass:"card d-flex flex-row media-thumb-container"},[t("a",{staticClass:"glightbox d-flex align-self-center",attrs:{href:e.selected.url}},[t("img",{staticClass:"list-media-thumbnail responsive border-0 sfl-selected-item-image",attrs:{src:e.selected.url,alt:"uploaded image"}})]),e._v(" "),t("div",{staticClass:"d-flex flex-grow-1 min-width-zero"},[t("div",{staticClass:"card-body align-self-center d-flex flex-column justify-content-between min-width-zero align-items-lg-center"},[t("a",{staticClass:"w-100"},[t("p",{staticClass:"list-item-heading mb-1 truncate sfl-selected-item-label"},[e._v("\n                  "+e._s(e.selected.path)+"\n                ")])])]),e._v(" "),t("div",{staticClass:"pl-1 align-self-center"},[t("a",{staticClass:"btn-link delete-library-item sfl-delete-item",attrs:{href:"#"},on:{click:function(t){return t.preventDefault(),e.removeFile.apply(null,arguments)}}},[t("i",{staticClass:"simple-icon-trash"})])])])])]):t("div",{staticClass:"select-from-library-button sfl-single"},[t("input",{attrs:{name:e.name,value:"",hidden:""}}),e._v(" "),t("a",{staticClass:"card d-flex flex-row mb-4 media-thumb-container justify-content-center align-items-center",attrs:{href:"#media-library-modal=ref:".concat(e.uuid)}},[e._v("\n          Select an item from library\n        ")])])])])])}),[],!1,null,null,null).exports}}]);