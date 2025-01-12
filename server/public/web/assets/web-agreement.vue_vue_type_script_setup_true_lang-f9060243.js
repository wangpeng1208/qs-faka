import{g as b,e as y}from"./config-6561e667.js";import{M as _,I as V,F as U,B as h,S as v,e as R,b as C}from"./ui-ba7aaa7e.js";import{e as k,l as w,r as x,P as L,a3 as B,a4 as l,f as a,H as m}from"./vue-bf422dc1.js";const F={name:"WebAgreement"},O=k({...F,setup(I){const t=w({privacy_policy_id:"",register_agreement_id:"",goods_release_id:"",prohibited_catalog_id:"",infringement_report_id:""});(async()=>{const{data:r}=await b({field:Object.keys(t)});for(const e in r)t[e]=r[e]})();const p={privacy_policy_id:[{required:!0,message:"请输入隐私政策"}]},i=x(),c=async()=>{const r=await i.value.validate();if(typeof r!="object"&&r){const e=await y({data:t});e.code===1?_.success("操作成功"):_.error(e.msg)}};return(r,e)=>{const d=V,n=U,s=h,u=v,f=R,g=C;return L(),B(g,{style:{"padding-top":"20px"},class:"basic-container",bordered:!1},{default:l(()=>[a(f,{ref_key:"formRef",ref:i,"label-align":"left",data:t,rules:p,"label-width":150,style:{width:"500px"}},{default:l(()=>[a(n,{label:"隐私政策",name:"privacy_policy_id",help:""},{default:l(()=>[a(d,{modelValue:t.privacy_policy_id,"onUpdate:modelValue":e[0]||(e[0]=o=>t.privacy_policy_id=o),clearable:"",placeholder:"请输入隐私政策URL地址"},null,8,["modelValue"])]),_:1}),a(n,{label:"注册协议",name:"register_agreement_id",help:""},{default:l(()=>[a(d,{modelValue:t.register_agreement_id,"onUpdate:modelValue":e[1]||(e[1]=o=>t.register_agreement_id=o),clearable:"",placeholder:"请输入注册协议URL地址"},null,8,["modelValue"])]),_:1}),a(n,{label:"商品发布条例",name:"goods_release_id",help:""},{default:l(()=>[a(d,{modelValue:t.goods_release_id,"onUpdate:modelValue":e[2]||(e[2]=o=>t.goods_release_id=o),clearable:"",placeholder:"请输入商品发布条例URL地址"},null,8,["modelValue"])]),_:1}),a(n,{label:"禁售目录",name:"prohibited_catalog_id"},{default:l(()=>[a(d,{modelValue:t.prohibited_catalog_id,"onUpdate:modelValue":e[3]||(e[3]=o=>t.prohibited_catalog_id=o),clearable:"",placeholder:"请输入禁售目录URL地址"},null,8,["modelValue"])]),_:1}),a(n,{label:"侵权举报",name:"infringement_report_id"},{default:l(()=>[a(d,{modelValue:t.infringement_report_id,"onUpdate:modelValue":e[4]||(e[4]=o=>t.infringement_report_id=o),clearable:"",placeholder:"请输入侵权举报URL地址"},null,8,["modelValue"])]),_:1}),a(n,null,{default:l(()=>[a(u,{size:"small"},{default:l(()=>[a(s,{theme:"primary",onClick:c},{default:l(()=>[m("提交")]),_:1}),a(s,{theme:"default",variant:"base",type:"reset"},{default:l(()=>[m("重置")]),_:1})]),_:1})]),_:1})]),_:1},8,["data"])]),_:1})}}});export{O as _};
