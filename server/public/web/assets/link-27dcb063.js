import{c as A,r as E,a as H,g as W,s as j}from"./link-1b41ef85.js";import{g as q,a as G}from"./link-cc8ac83f.js";import{c as x,_ as J}from"./index-8db2df2c.js";import{V as L,W as P}from"./icons-a8498fb6.js";import{M as _,S as K,L as O,T as R,Q as X,f as Y}from"./ui-ba7aaa7e.js";import{e as Z,r as c,a2 as ee,P as k,a3 as S,a4 as a,a7 as o,f as t,H as r,ab as y,I as d,Q as ae,F as te,aa as se,ac as oe,ad as le}from"./vue-bf422dc1.js";import"./libs-51817cd7.js";import"./plugins-ca970193.js";import"./others-9f318174.js";import"./echarts-bf9d612c.js";const i=p=>(oe("data-v-286d19d9"),p=p(),le(),p),ne={class:"info-block"},ie={class:"info-item"},ce=i(()=>o("h1",null,"链接状态",-1)),re=i(()=>o("div",{class:"help"},"选择暂停将仅当前分类链接不可用",-1)),de={class:"info-item"},ue=i(()=>o("h1",null,"绿标短链",-1)),_e=i(()=>o("div",{class:"help"},"绿标短链接打开就是分类长链接，强烈建议使用绿标短链接作为访问链接；如果在朋友圈等地方打广告请发【绿标短链】这个链接，这样可以让您的朋友直接进入您的店铺",-1)),pe={class:"info-item"},me=i(()=>o("h1",null,"分类链接",-1)),ve=i(()=>o("div",{class:"help"},"重置分类链接后，当前分类的原短链长连接都会失效；严禁使用此链接发广告",-1)),he={class:"info-item"},fe=i(()=>o("h1",null,"电脑端风格",-1)),ge=i(()=>o("div",{class:"help"},"当前分类链接PC页面风格",-1)),ke={name:"CategoryLinkPopup"},ye=Z({...ke,setup(p,{expose:V}){const s=c({id:0,link:"",short_link:"",status:0}),h=c(!1),f=c(!1),g=async l=>{h.value=!0;const{data:e}=await A({id:l});e?(s.value={...e},f.value=!0):_.error("获取链接失败"),h.value=!1},b=async l=>{const e=await E({type:"category",id:s.value.id,status:l});e.code===1&&(_.success(e.msg),g(s.value.id))},D=async l=>{const e=await H({type:"category",id:s.value.id,status:l});e.code===1&&(_.success(e.msg),g(s.value.id))},T=c([]),I=c([]),$=async()=>{const l=await q(),e=await G();T.value=l.data,I.value=e.data},C=c(""),z=c(""),B=async l=>{const{data:e}=await W({id:l,type:"category"});C.value=e.pc_template,z.value=e.mobile_template},M=async(l,e)=>{const u=await j({field:l,value:e,id:s.value.id,type:"category"});u.code===1?_.success(u.msg):_.error(u.msg)},N=[{label:"开启",value:1},{label:"暂停",value:0}];return V({getTemplate:$,featchCategoryLink:g,getUserTemplate:B}),(l,e)=>{const u=ee("wp-check-tag"),m=K,w=O,v=R,U=X,F=Y;return k(),S(F,{visible:f.value,"onUpdate:visible":e[5]||(e[5]=n=>f.value=n),loading:h.value,"destroy-on-close":!0,"close-on-overlay-click":!1,width:"750",header:"分类链接",footer:!1},{body:a(()=>[o("div",ne,[o("div",ie,[t(m,null,{default:a(()=>[ce,t(u,{modelValue:s.value.status,"onUpdate:modelValue":e[0]||(e[0]=n=>s.value.status=n),items:N,onActions:D},null,8,["modelValue"])]),_:1}),re]),o("div",de,[t(m,null,{default:a(()=>[ue,t(w,{theme:"primary",href:s.value.short_link,target:"_blank"},{default:a(()=>[r(y(s.value.short_link),1)]),_:1},8,["href"]),t(v,{class:"hand-cursor",theme:"primary",variant:"light",size:"small",onClick:e[1]||(e[1]=n=>d(x)(s.value.short_link))},{icon:a(()=>[t(d(L))]),default:a(()=>[r("复制 ")]),_:1}),t(v,{class:"hand-cursor",theme:"primary",size:"small",onClick:e[2]||(e[2]=n=>b(0))},{icon:a(()=>[t(d(P))]),default:a(()=>[r("重置短链 ")]),_:1})]),_:1}),_e]),o("div",pe,[t(m,null,{default:a(()=>[me,t(w,{theme:"primary",href:s.value.link,target:"_blank"},{default:a(()=>[r(y(s.value.link),1)]),_:1},8,["href"]),t(v,{class:"hand-cursor",theme:"primary",variant:"light",size:"small",onClick:e[3]||(e[3]=n=>d(x)(s.value.link))},{icon:a(()=>[t(d(L))]),default:a(()=>[r("复制 ")]),_:1}),t(v,{class:"hand-cursor",theme:"primary",size:"small",onClick:e[4]||(e[4]=n=>b(1))},{icon:a(()=>[t(d(P))]),default:a(()=>[r("重置分接 ")]),_:1})]),_:1}),ve]),o("div",he,[t(m,null,{default:a(()=>[fe,(k(!0),ae(te,null,se(T.value,(n,Q)=>(k(),S(U,{key:Q,checked:n.value==C.value,onChange:be=>M("theme",n.value)},{default:a(()=>[r(y(n.label),1)]),_:2},1032,["checked","onChange"]))),128))]),_:1}),ge])])]),_:1},8,["visible","loading"])}}});const $e=J(ye,[["__scopeId","data-v-286d19d9"]]);export{$e as default};
