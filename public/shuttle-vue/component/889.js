"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[889,332],{2332:(e,t,n)=>{n.r(t),n.d(t,{store:()=>a});var a={state:{types:["text","array","image","rich_text_box","svg","text_area","map","model","arrayModel","c_relationship","multiple_images","tag"]}}},8889:(e,t,n)=>{n.r(t),n.d(t,{default:()=>o});var a=n(2332);const i={props:["item","index"],data:function(){return{inputTypes:a.store.state.types}},methods:{addClick:function(e){this.$emit("on-add-click",e)},removeClick:function(e,t){this.$emit("on-remove-click",e,t)}}};const o=(0,n(1900).Z)(i,(function(){var e=this,t=e._self._c;return t("ul",[t("button",{on:{click:function(t){return t.preventDefault(),e.$emit("on-add-click",e.item)}}},[e._v("Add")]),e._v(" "),e._l(e.item.children,(function(n,a){return t("li",{key:a},[t("input",{directives:[{name:"model",rawName:"v-model",value:n.field,expression:"object.field"}],attrs:{name:"data["+e.index+"][object]["+a+"][field]"},domProps:{value:n.field},on:{input:function(t){t.target.composing||e.$set(n,"field",t.target.value)}}}),e._v(" "),t("select",{directives:[{name:"model",rawName:"v-model",value:n.type,expression:"object.type"}],attrs:{name:"data["+e.index+"][object]["+a+"][type]"},on:{change:function(t){var a=Array.prototype.filter.call(t.target.options,(function(e){return e.selected})).map((function(e){return"_value"in e?e._value:e.value}));e.$set(n,"type",t.target.multiple?a:a[0])}}},e._l(e.inputTypes,(function(n,a){return t("option",{key:a},[e._v("\n        "+e._s(n)+"\n      ")])})),0),e._v(" "),"array"==n.type?t("component-tab-data-array",{attrs:{item:n,index:a},on:{"on-add-click":e.addClick,"on-remove-click":e.removeClick}}):t("input",{directives:[{name:"model",rawName:"v-model",value:n.display_name,expression:"object.display_name"}],domProps:{value:n.display_name},on:{input:function(t){t.target.composing||e.$set(n,"display_name",t.target.value)}}}),e._v(" "),t("button",{on:{click:function(t){return t.preventDefault(),e.$emit("on-remove-click",e.item,a)}}},[e._v("\n      Remove\n    ")])],1)}))],2)}),[],!1,null,null,null).exports}}]);