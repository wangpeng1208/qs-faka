import{d as R,g as S}from"./user-2cd65a42.js";import{M as d,n as T,o as N,p as P,d as B,F as C,h as O,I as j,e as q,f as E}from"./ui-ba7aaa7e.js";import{e as H,l as p,r as _,P as L,a3 as G,a4 as o,f as t,H as m,ab as i}from"./vue-bf422dc1.js";const J={name:"MoneyPopup"},Z=H({...J,emits:["success"],setup(K,{expose:b,emit:y}){const v=[{label:"加钱",value:"inc"},{label:"扣钱",value:"dec"},{label:"解冻",value:"unfreeze"},{label:"冻结",value:"freeze"},{label:"加预存",value:"customchannelfeeadd"},{label:"扣预存",value:"customchannelfeedec"},{label:"加保证金",value:"customchanneldepositadd"},{label:"扣保证金",value:"customchanneldepositdec"}],a=p({...{user_id:0,action:"inc",money:"",mark:""}}),n=p({money:0,freeze_money:0,fee_money:0,deposit_money:0}),f=_(),r=_(!1),g=_("资金管理"),V=l=>{D(l),r.value=!0},D=async l=>{a.user_id=l;const{data:e}=await R({id:l});for(const s in n)n[s]=e[s]};b({init:V});const k={money:[{required:!0,message:"必填",type:"error"}]},h=y,x=async()=>{const l=await f.value.validate();if(typeof l!="object"&&l)try{const e=await S(a);e.code===1?(d.success("操作成功"),r.value=!1,h("success")):d.error(e.msg)}catch(e){d.error(e.msg)}};return(l,e)=>{const s=T,w=N,I=P,U=B,u=C,z=O,A=j,F=q,M=E;return L(),G(M,{visible:r.value,"onUpdate:visible":e[3]||(e[3]=c=>r.value=c),"close-on-overlay-click":!1,"destroy-on-close":!0,header:g.value,"on-confirm":x},{default:o(()=>[t(w,{title:""},{default:o(()=>[m(i(n)+" ",1),t(s,{label:"可用余额："},{default:o(()=>[m(i(n.money)+"元",1)]),_:1}),t(s,{label:"冻结余额："},{default:o(()=>[m(i(n.freeze_money)+"元",1)]),_:1}),t(s,{label:"预存："},{default:o(()=>[m(i(n.fee_money)+"元",1)]),_:1}),t(s,{label:"保证金："},{default:o(()=>[m(i(n.deposit_money)+"元",1)]),_:1})]),_:1}),t(I,null,{default:o(()=>[m("资金操作")]),_:1}),t(F,{ref_key:"formRef",ref:f,"label-align":"left",data:a,rules:k,"label-width":80},{default:o(()=>[t(u,{label:"操作类型",name:"action"},{default:o(()=>[t(U,{modelValue:a.action,"onUpdate:modelValue":e[0]||(e[0]=c=>a.action=c),options:v},null,8,["modelValue"])]),_:1}),t(u,{label:"操作金额",name:"money"},{default:o(()=>[t(z,{modelValue:a.money,"onUpdate:modelValue":e[1]||(e[1]=c=>a.money=c),clearable:"",placeholder:"请输入操作金额",theme:"column",suffix:"元",min:"0",style:{width:"600px"}},null,8,["modelValue"])]),_:1}),t(u,{label:"操作备注",name:"mark"},{default:o(()=>[t(A,{modelValue:a.mark,"onUpdate:modelValue":e[2]||(e[2]=c=>a.mark=c),clearable:"",placeholder:"请输入操作备注"},null,8,["modelValue"])]),_:1})]),_:1},8,["data"])]),_:1},8,["visible","header"])}}});export{Z as _};
