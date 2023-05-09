"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[356,332],{2332:(e,t,a)=>{a.r(t),a.d(t,{store:()=>n});var n={state:{types:["text","array","image","rich_text_box","svg","text_area","map","model","arrayModel","c_relationship","multiple_images","tag"]}}},5356:(e,t,a)=>{a.r(t),a.d(t,{default:()=>i});var n=a(2332);const o={props:{rows:{type:Array,value:[]},modelSetting:{type:Object,default:function(){return{}}}},computed:{myData:function(){return JSON.stringify(this.data)},myModelData:function(){return JSON.stringify(this.model)}},data:function(){var e;return{fromDatabase:!!this.modelSetting,types:n.store.state.types,model:null!==(e=this.modelSetting)&&void 0!==e?e:{},data:this.rows}},methods:{update:function(e,t,a){Vue.set(e,t,a.target.value)},addRow:function(){this.data.push({field:"",type:"text",display_name:"",details:{},children:[]})},addModelRow:function(){this.model.conditions.push({field:"",type:"where",display_name:""})},removeModelRow:function(e){this.model.conditions.splice(e,1)},removeRow:function(e){this.data.splice(e,1)},removeObjectFromData:function(e,t,a){e.children.splice(t,1)},addObjectToData:function(e){e.children.push({field:"",type:"text",children:[],display_name:""})},showResult:function(){console.log(this.model)},getDefaultModelSetting:function(){return this.modelSetting?JSON.parse(this.modelSetting).model:{name:"",order:"",conditions:[],limit:0}}}};const i=(0,a(1900).Z)(o,(function(){var e=this,t=e._self._c;return t("div",[t("input",{directives:[{name:"model",rawName:"v-model",value:e.fromDatabase,expression:"fromDatabase"}],attrs:{type:"checkbox"},domProps:{checked:Array.isArray(e.fromDatabase)?e._i(e.fromDatabase,null)>-1:e.fromDatabase},on:{change:function(t){var a=e.fromDatabase,n=t.target,o=!!n.checked;if(Array.isArray(a)){var i=e._i(a,null);n.checked?i<0&&(e.fromDatabase=a.concat([null])):i>-1&&(e.fromDatabase=a.slice(0,i).concat(a.slice(i+1)))}else e.fromDatabase=o}}}),e._v(" Load data from database\n  "),t("button",{on:{click:function(t){return t.preventDefault(),e.addRow.apply(null,arguments)}}},[e._v("Add")]),e._v(" "),t("ul",[t("textarea",{attrs:{name:"myData",hidden:""}},[e._v(e._s(e.myData))]),e._v(" "),e._l(e.data,(function(a,n){return t("li",{key:n},[t("input",{directives:[{name:"model",rawName:"v-model",value:a.field,expression:"item.field"}],attrs:{name:"data["+n+"][field]"},domProps:{value:a.field},on:{input:function(t){t.target.composing||e.$set(a,"field",t.target.value)}}}),e._v(" "),t("select",{directives:[{name:"model",rawName:"v-model",value:a.type,expression:"item.type"}],attrs:{name:"data["+n+"][type]"},on:{change:function(t){var n=Array.prototype.filter.call(t.target.options,(function(e){return e.selected})).map((function(e){return"_value"in e?e._value:e.value}));e.$set(a,"type",t.target.multiple?n:n[0])}}},e._l(e.types,(function(a,n){return t("option",{key:n},[e._v("\n          "+e._s(a)+"\n        ")])})),0),e._v(" "),t("input",{directives:[{name:"model",rawName:"v-model",value:a.display_name,expression:"item.display_name"}],domProps:{value:a.display_name},on:{input:function(t){t.target.composing||e.$set(a,"display_name",t.target.value)}}}),e._v(" "),"array"==a.type?t("component-tab-data-array",{attrs:{item:a,index:n},on:{"on-add-click":e.addObjectToData,"on-remove-click":e.removeObjectFromData}}):e._e(),e._v(" "),"c_relationship"==a.type?t("div",[e._v("\n        type:\n        "),t("input",{domProps:{value:a.details.type},on:{input:function(t){return e.update(a.details,"type",t)}}}),e._v("\n        key:\n        "),t("input",{domProps:{value:a.details.key},on:{input:function(t){return e.update(a.details,"key",t)}}}),e._v("\n        label:\n        "),t("input",{domProps:{value:a.details.label},on:{input:function(t){return e.update(a.details,"label",t)}}}),e._v("\n        column:\n        "),t("input",{domProps:{value:a.details.column},on:{input:function(t){return e.update(a.details,"column",t)}}}),e._v("\n        model:\n        "),t("input",{domProps:{value:a.details.model},on:{input:function(t){return e.update(a.details,"model",t)}}}),e._v("\n        scope:\n        "),t("input",{domProps:{value:a.details.scope},on:{input:function(t){return e.update(a.details,"scope",t)}}})]):e._e(),e._v(" "),t("button",{on:{click:function(t){return t.preventDefault(),e.removeRow(n)}}},[e._v("Remove")])],1)}))],2),e._v(" "),e.fromDatabase?t("div",[t("textarea",{attrs:{name:"myModelData"}},[e._v(e._s(e.myModelData))]),e._v(" "),t("button",{on:{click:function(t){return t.preventDefault(),e.addModelRow.apply(null,arguments)}}},[e._v("Add")]),e._v(" "),t("ul",e._l(e.model.conditions,(function(a,n){return t("li",{key:n},[t("input",{directives:[{name:"model",rawName:"v-model",value:a.field,expression:"item.field"}],domProps:{value:a.field},on:{input:function(t){t.target.composing||e.$set(a,"field",t.target.value)}}}),e._v(" "),t("input",{directives:[{name:"model",rawName:"v-model",value:a.type,expression:"item.type"}],domProps:{value:a.type},on:{input:function(t){t.target.composing||e.$set(a,"type",t.target.value)}}}),e._v(" "),t("input",{directives:[{name:"model",rawName:"v-model",value:a.display_name,expression:"item.display_name"}],domProps:{value:a.display_name},on:{input:function(t){t.target.composing||e.$set(a,"display_name",t.target.value)}}}),e._v(" "),t("button",{on:{click:function(t){return t.preventDefault(),e.removeModelRow(n)}}},[e._v("Remove")])])})),0),e._v(" "),t("input",{directives:[{name:"model",rawName:"v-model",value:e.model.name,expression:"model.name"}],domProps:{value:e.model.name},on:{input:function(t){t.target.composing||e.$set(e.model,"name",t.target.value)}}}),e._v(" "),t("input",{directives:[{name:"model",rawName:"v-model",value:e.model.order,expression:"model.order"}],domProps:{value:e.model.order},on:{input:function(t){t.target.composing||e.$set(e.model,"order",t.target.value)}}}),e._v(" "),t("input",{directives:[{name:"model",rawName:"v-model",value:e.model.scope,expression:"model.scope"}],domProps:{value:e.model.scope},on:{input:function(t){t.target.composing||e.$set(e.model,"scope",t.target.value)}}}),e._v(" "),t("input",{directives:[{name:"model",rawName:"v-model",value:e.model.limit,expression:"model.limit"}],domProps:{value:e.model.limit},on:{input:function(t){t.target.composing||e.$set(e.model,"limit",t.target.value)}}})]):e._e()])}),[],!1,null,null,null).exports}}]);