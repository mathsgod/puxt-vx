(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-2d0aef29"],{"0bde":function(t,a,e){"use strict";e.r(a);var i=function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",[e("el-input",{attrs:{clearable:""},on:{focus:t.focusInput},model:{value:t.localData,callback:function(a){t.localData=a},expression:"localData"}}),t.dialogVisible?[e("el-dialog",{attrs:{visible:t.dialogVisible,width:"80%",title:"File manager",top:"2vh"},on:{"update:visible":function(a){t.dialogVisible=a}}},[e("vx-file-manager",{attrs:{"default-action":"select",base:t.base},on:{input:function(a){return t.fileSelected(a)}}})],1)]:t._e()],2)},l=[],n=e("1a53"),o={components:{vxFileManager:n["default"]},props:{value:String,base:String},data:function(){return{localData:this.value,dialogVisible:!1}},watch:{localData:function(){this.$emit("input",this.localData)}},methods:{focusInput:function(){this.dialogVisible=!0},fileSelected:function(t){this.$emit("input",t),this.dialogVisible=!1,this.localData=t}}},s=o,c=e("2877"),u=Object(c["a"])(s,i,l,!1,null,null,null);a["default"]=u.exports}}]);
//# sourceMappingURL=chunk-2d0aef29.7483ef7b.js.map