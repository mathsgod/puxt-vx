import{_ as v,r as s,o as V,d as g,w as o,b as e,a as z,t as y,e as d}from"./index.3443763f.js";const S={data(){return{form:{}}},async created(){let{data:r}=await this.$vx.get("style");this.form=r},methods:{async save(){(await vx.post("style",this.form)).status==204&&this.$message.success("Successfully updated")}}},w=d("Form"),x=d("Button"),B=d("Table"),C=d("Description");function U(r,a,h,k,t,f){const u=s("el-divider"),l=s("el-option"),i=s("el-select"),n=s("el-form-item"),_=s("el-switch"),b=s("el-button"),p=s("el-form"),c=s("el-card");return V(),g(c,{header:r.$t("Style")},{default:o(()=>[e(p,{"label-width":"auto"},{default:o(()=>[e(u,null,{default:o(()=>[w]),_:1}),e(n,{label:"Size"},{default:o(()=>[e(i,{modelValue:t.form.form_size,"onUpdate:modelValue":a[0]||(a[0]=m=>t.form.form_size=m),clearable:""},{default:o(()=>[e(l,{value:"large",label:"large"}),e(l,{value:"medium",label:"medium"}),e(l,{value:"small",label:"small"}),e(l,{value:"mini",label:"mini"})]),_:1},8,["modelValue"])]),_:1}),e(u,null,{default:o(()=>[x]),_:1}),e(n,{label:"Size"},{default:o(()=>[e(i,{modelValue:t.form.button_size,"onUpdate:modelValue":a[1]||(a[1]=m=>t.form.button_size=m),clearable:""},{default:o(()=>[e(l,{value:"large",label:"large"}),e(l,{value:"medium ",label:"medium"}),e(l,{value:"small",label:"small"}),e(l,{value:"mini",label:"mini"})]),_:1},8,["modelValue"])]),_:1}),e(u,null,{default:o(()=>[B]),_:1}),e(n,{label:"Size"},{default:o(()=>[e(i,{modelValue:t.form.table_size,"onUpdate:modelValue":a[2]||(a[2]=m=>t.form.table_size=m),clearable:""},{default:o(()=>[e(l,{value:"large",label:"large"}),e(l,{value:"medium ",label:"medium"}),e(l,{value:"small",label:"small"}),e(l,{value:"mini",label:"mini"})]),_:1},8,["modelValue"])]),_:1}),e(n,{label:"Border"},{default:o(()=>[e(_,{modelValue:t.form.table_border,"onUpdate:modelValue":a[3]||(a[3]=m=>t.form.table_border=m)},null,8,["modelValue"])]),_:1}),e(u,null,{default:o(()=>[C]),_:1}),e(n,{label:"Size"},{default:o(()=>[e(i,{modelValue:t.form.description_size,"onUpdate:modelValue":a[4]||(a[4]=m=>t.form.description_size=m),clearable:""},{default:o(()=>[e(l,{value:"large",label:"large"}),e(l,{value:"medium ",label:"medium"}),e(l,{value:"small",label:"small"}),e(l,{value:"mini",label:"mini"})]),_:1},8,["modelValue"])]),_:1}),e(n,{label:"Border"},{default:o(()=>[e(_,{modelValue:t.form.description_border,"onUpdate:modelValue":a[5]||(a[5]=m=>t.form.description_border=m)},null,8,["modelValue"])]),_:1}),z("div",null,[e(b,{type:"primary",onClick:f.save,textContent:y(r.$t("Save changes"))},null,8,["onClick","textContent"])])]),_:1})]),_:1},8,["header"])}var D=v(S,[["render",U]]);export{D as default};
