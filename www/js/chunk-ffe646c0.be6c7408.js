(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-ffe646c0"],{"25f0":function(e,t,r){"use strict";var n=r("6eeb"),a=r("825a"),o=r("d039"),s=r("ad6d"),i="toString",c=RegExp.prototype,u=c[i],l=o((function(){return"/a/b"!=u.call({source:"a",flags:"b"})})),f=u.name!=i;(l||f)&&n(RegExp.prototype,i,(function(){var e=a(this),t=String(e.source),r=e.flags,n=String(void 0===r&&e instanceof RegExp&&!("flags"in c)?s.call(e):r);return"/"+t+"/"+n}),{unsafe:!0})},6978:function(e,t,r){"use strict";r.r(t);var n=function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("vx-card",{directives:[{name:"loading",rawName:"v-loading",value:e.loading,expression:"loading"}]},[r("vx-card-body",[r("el-form",{ref:"form1",staticClass:"vx-form",attrs:{"label-position":e.labelPosition,model:e.form,"label-width":"auto",size:e.size},nativeOn:{submit:function(e){e.preventDefault()}}},[e._t("default",null,{form:e.form})],2)],1),r("vx-card-footer",[r("el-button",{attrs:{icon:"el-icon-check",type:"primary"},on:{click:function(t){return e.onSubmit()}}},[e._v(e._s(e.$t("Submit")))]),r("el-button",{on:{click:e.onBack}},[e._v(e._s(e.$t("Back")))])],1)],1)},a=[],o=r("1da1"),s=(r("96cf"),r("159b"),r("b0c0"),r("d3b7"),r("25f0"),r("ac1f"),r("5319"),{props:{action:String,size:String,successUrl:String,restJWT:String,method:{type:String,default:"post"},data:{type:Object,default:function(){return{}}}},data:function(){return{labelPosition:"left",form:this.data,loading:!1}},created:function(){this.labelPosition=this.$vx.breakpoint.sm?"top":"left"},methods:{onSubmit:function(){var e=this;this.$refs.form1.validate(function(){var t=Object(o["a"])(regeneratorRuntime.mark((function t(r){var n,a,o,s,i;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:if(!r){t.next=37;break}if(n=e.$route.path,e.action&&(n=e.action),e.loading=!0,!(e.$el.querySelectorAll("input.el-upload__input").length>0)){t.next=13;break}return o=new FormData,e.$el.querySelectorAll("input.el-upload__input").forEach((function(e){e.multiple?e.files.forEach((function(t){o.append(e.name+"[]",t)})):e.files.forEach((function(t){o.append(e.name,t)}))})),o.append("vx",new Blob([JSON.stringify(e.form)],{type:"application/json"})),t.next=10,e.$vx.post(n,o,{headers:{"Content-Type":"multipart/form-data","rest-jwt":e.restJWT}});case 10:a=t.sent,t.next=23;break;case 13:if("post"!=e.method){t.next=19;break}return t.next=16,e.$vx.post(n,e.form);case 16:a=t.sent,t.next=23;break;case 19:if("patch"!=e.method){t.next=23;break}return t.next=22,e.$vx.patch(n,e.form);case 22:a=t.sent;case 23:if(e.loading=!1,s=a.data,"2"!=a.status.toString()[0]){t.next=30;break}return 204==a.status&&e.$message.success("Updated"),201==a.status&&e.$message.success("Created"),e.successUrl&&(i=e.successUrl,i=i.replace(":content-location",a.headers["content-location"]),e.$router.push(i)),t.abrupt("return");case 30:if("4"!=a.status.toString()[0]){t.next=36;break}if(401!=a.status){t.next=34;break}return e.$router.push("/"),t.abrupt("return");case 34:return s.error&&e.$message.error(s.error.message),t.abrupt("return");case 36:s.error&&e.$message.error(s.error.message);case 37:case"end":return t.stop()}}),t)})));return function(e){return t.apply(this,arguments)}}())},onBack:function(){window.history.go(-1)}}}),i=s,c=r("2877"),u=Object(c["a"])(i,n,a,!1,null,null,null);t["default"]=u.exports}}]);
//# sourceMappingURL=chunk-ffe646c0.be6c7408.js.map