(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-2d0c1784"],{"45d1":function(e,t,r){"use strict";r.r(t);var n=function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{directives:[{name:"loading",rawName:"v-loading",value:e.loading,expression:"loading"}]},[e._t("default")],2)},a=[],o=r("1da1"),i=(r("96cf"),{props:{remote:String,autoReload:{type:Boolean,default:!0}},data:function(){return{loading:!1}},created:function(){var e=this;return Object(o["a"])(regeneratorRuntime.mark((function t(){return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:e.reload();case 1:case"end":return t.stop()}}),t)})))()},watch:{remote:function(){this.autoReload&&this.reload()}},methods:{reload:function(){var e=this;return Object(o["a"])(regeneratorRuntime.mark((function t(){var r,n,a;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:if(!e.remote){t.next=16;break}return e.loading=!0,e.$emit("loading"),t.next=5,e.$vx.get(e.remote);case 5:if(r=t.sent,n=r.data,a=r.status,e.loading=!1,200==a){t.next=12;break}return e.$alert(n.error.message,{type:"error"}),t.abrupt("return");case 12:window.$(e.$el).html(n),e.$emit("loaded"),t.next=17;break;case 16:console.warn("vx-div: remote not set");case 17:case"end":return t.stop()}}),t)})))()}}}),u=i,s=r("2877"),c=Object(s["a"])(u,n,a,!1,null,null,null);t["default"]=c.exports}}]);
//# sourceMappingURL=chunk-2d0c1784.4e3e4efd.js.map