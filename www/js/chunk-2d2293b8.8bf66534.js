(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-2d2293b8"],{dd24:function(t,e,n){"use strict";n.r(e);var r=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",[n("ul",{staticClass:"nav",class:t.getClass(),attrs:{role:"tablist"}},[t._t("default")],2),n("div",{staticClass:"tab-content"},[n("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}],ref:"content",staticClass:"tab-pane active",attrs:{role:"tabpanel"}})])])},a=[],o=n("1da1"),s=(n("96cf"),n("159b"),n("9911"),{props:{type:{type:String,default:"tabs"}},data:function(){return{loading:!1}},mounted:function(){var t=this;return Object(o["a"])(regeneratorRuntime.mark((function e(){var n,r,a,o,s;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:for(n=[],t.$slots.default.forEach((function(t){void 0!=t.tag&&n.push(t.componentInstance)})),a=0,o=n;a<o.length;a++)s=o[a],s.$on("selected",(function(e){t.loadContent(e)})),s.active&&(r=s.link);if(!r){e.next=6;break}return e.next=6,t.loadContent(r);case 6:case"end":return e.stop()}}),e)})))()},methods:{loadContent:function(t){var e=this;return Object(o["a"])(regeneratorRuntime.mark((function n(){var r,a,o;return regeneratorRuntime.wrap((function(n){while(1)switch(n.prev=n.next){case 0:return r="/"!=t[0]?e.$route.path+"/"+t:t,e.loading=!0,n.prev=2,n.next=5,e.$vx.get(r);case 5:if(a=n.sent,o=a.data,e.loading=!1,!o.error){n.next=11;break}return e.$message.error(o.error.message),n.abrupt("return");case 11:window.$(e.$refs.content).html(o),n.next=19;break;case 14:return n.prev=14,n.t0=n["catch"](2),e.loading=!1,e.$alert(n.t0,{type:"error"}),n.abrupt("return");case 19:case"end":return n.stop()}}),n,null,[[2,14]])})))()},getClass:function(){return["nav-"+this.type]}}}),i=s,c=n("2877"),u=Object(c["a"])(i,r,a,!1,null,null,null);e["default"]=u.exports}}]);
//# sourceMappingURL=chunk-2d2293b8.8bf66534.js.map