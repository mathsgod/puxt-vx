import{_ as V,r as n,h as b,o as i,d as u,w as l,i as h,b as t,e as g}from"./index.1734ac50.js";const v={data(){return{data:{},loading:!0}},async mounted(){let{data:s}=await vx.get("/User/setting/information");this.data=s,this.loading=!1},methods:{submit(){this.$refs.form1.validate(async s=>{if(s){let{status:e}=await vx.patch(`/User/${this.data.user_id}`,this.data);console.log(e),e==204&&this.$message.success("Successfully updated")}})}}},x=g("Submit");function U(s,e,k,w,o,m){const r=n("el-input"),d=n("el-form-item"),p=n("el-button"),_=n("el-form"),c=n("el-card"),f=b("loading");return i(),u(c,null,{default:l(()=>[h((i(),u(_,{model:o.data,"label-position":"top",ref:"form1"},{default:l(()=>[t(d,{label:"Phone",prop:"phone"},{default:l(()=>[t(r,{modelValue:o.data.phone,"onUpdate:modelValue":e[0]||(e[0]=a=>o.data.phone=a)},null,8,["modelValue"])]),_:1}),t(d,{label:"Address 1",prop:"addr1"},{default:l(()=>[t(r,{modelValue:o.data.addr1,"onUpdate:modelValue":e[1]||(e[1]=a=>o.data.addr1=a)},null,8,["modelValue"])]),_:1}),t(d,{label:"Address 2",prop:"addr2"},{default:l(()=>[t(r,{modelValue:o.data.addr2,"onUpdate:modelValue":e[2]||(e[2]=a=>o.data.addr2=a)},null,8,["modelValue"])]),_:1}),t(d,{label:"Address 3",prop:"addr3"},{default:l(()=>[t(r,{modelValue:o.data.addr3,"onUpdate:modelValue":e[3]||(e[3]=a=>o.data.addr3=a)},null,8,["modelValue"])]),_:1}),t(d,null,{default:l(()=>[t(p,{type:"primary",icon:"el-icon-check",onClick:m.submit},{default:l(()=>[x]),_:1},8,["onClick"])]),_:1})]),_:1},8,["model"])),[[f,o.loading]])]),_:1})}var C=V(v,[["render",U]]);export{C as default};