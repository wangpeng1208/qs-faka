import{c as M,a as P}from"./user-2cd65a42.js";import{M as v,R as A,F as B,I as N,r as O,e as S,f as j}from"./ui-ba7aaa7e.js";import{e as G,r as i,M as L,P as d,a3 as c,a4 as t,A as Q,f as o,Q as b,a9 as p}from"./vue-bf422dc1.js";import{_ as T}from"./index-8db2df2c.js";import"./icons-a8498fb6.js";import"./libs-51817cd7.js";import"./plugins-ca970193.js";import"./others-9f318174.js";import"./echarts-bf9d612c.js";const q={key:0,class:"type"},z={key:1,class:"type"},H={name:"CollectPopup"},J=G({...H,emits:["success"],setup(K,{expose:V,emit:y}){const k=[{label:"支付宝",value:1},{label:"微信",value:2},{label:"银行卡",value:3}],g=[{label:"是",value:1},{label:"否",value:0}],_={id:0,user_id:0,type:1,info:{},allow_update:1,collect_img:""},e=i({..._}),r=i(!1),w=s=>{U(s),r.value=!0},U=async s=>{const{data:l}=await M({id:s});for(const u in e.value)l[u]!=null&&l[u]!==void 0?e.value[u]=l[u]:e.value[u]=_[u];e.value.user_id=s};V({init:w});const D={},x=y,f=i(),R=async()=>{const s=await f.value.validate();if(typeof s!="object"&&s){const l=await P(e.value);l.code===1?(v.success(l.msg),r.value=!1,x("success")):v.error(l.msg)}};return(s,l)=>{const u=A,n=B,m=N,C=O,I=S,E=j,F=L("perms");return d(),c(E,{visible:r.value,"onUpdate:visible":l[9]||(l[9]=a=>r.value=a),"close-on-overlay-click":!1,"destroy-on-close":!0,header:"收款信息","on-confirm":R},{default:t(()=>[Q((d(),c(I,{ref_key:"formRef",ref:f,"label-align":"left",data:e.value,rules:D,"label-width":80},{default:t(()=>[o(n,{label:"收款类型",name:"type"},{default:t(()=>[o(u,{modelValue:e.value.type,"onUpdate:modelValue":l[0]||(l[0]=a=>e.value.type=a),name:"type",options:k},null,8,["modelValue"])]),_:1}),e.value.type===1||e.value.type===2?(d(),b("div",q,[o(n,{label:"收款账号",name:"account"},{default:t(()=>[o(m,{modelValue:e.value.info.account,"onUpdate:modelValue":l[1]||(l[1]=a=>e.value.info.account=a),clearable:"",placeholder:"请输入收款账号"},null,8,["modelValue"])]),_:1}),o(n,{label:"姓名",name:"realname"},{default:t(()=>[o(m,{modelValue:e.value.info.realname,"onUpdate:modelValue":l[2]||(l[2]=a=>e.value.info.realname=a),clearable:"",placeholder:"请输入邮箱"},null,8,["modelValue"])]),_:1})])):p("",!0),e.value.type===3?(d(),b("div",z,[o(n,{label:"银行",name:"bank_name"},{default:t(()=>[o(m,{modelValue:e.value.info.bank_name,"onUpdate:modelValue":l[3]||(l[3]=a=>e.value.info.bank_name=a),clearable:"",placeholder:"请输入银行"},null,8,["modelValue"])]),_:1}),o(n,{label:"开户行",name:"bank_branch"},{default:t(()=>[o(m,{modelValue:e.value.info.bank_branch,"onUpdate:modelValue":l[4]||(l[4]=a=>e.value.info.bank_branch=a),clearable:"",placeholder:"请输入开户行"},null,8,["modelValue"])]),_:1}),o(n,{label:"银行卡号",name:"bank_card"},{default:t(()=>[o(m,{modelValue:e.value.info.bank_card,"onUpdate:modelValue":l[5]||(l[5]=a=>e.value.info.bank_card=a),clearable:"",placeholder:"请输入银行卡号"},null,8,["modelValue"])]),_:1}),o(n,{label:"姓名",name:"realname"},{default:t(()=>[o(m,{modelValue:e.value.info.realname,"onUpdate:modelValue":l[6]||(l[6]=a=>e.value.info.realname=a),clearable:"",placeholder:"请输入姓名"},null,8,["modelValue"])]),_:1})])):p("",!0),o(n,{label:"身份证号码",name:"idcard_number"},{default:t(()=>[o(m,{modelValue:e.value.info.idcard_number,"onUpdate:modelValue":l[7]||(l[7]=a=>e.value.info.idcard_number=a),clearable:"",placeholder:"请输入身份证号码"},null,8,["modelValue"])]),_:1}),e.value.collect_img?(d(),c(n,{key:2,label:"收款图",name:"collect_img"},{default:t(()=>[o(C,{src:"formData.collect_img",style:{width:"200px"}})]),_:1})):p("",!0),o(n,{label:"允许更新",name:"allow_update"},{default:t(()=>[o(u,{modelValue:e.value.allow_update,"onUpdate:modelValue":l[8]||(l[8]=a=>e.value.allow_update=a),options:g},null,8,["modelValue"])]),_:1})]),_:1},8,["data"])),[[F,["adminapi/merchant/user/collectEdit"]]])]),_:1},8,["visible"])}}});const oe=T(J,[["__scopeId","data-v-83bf2f2e"]]);export{oe as default};