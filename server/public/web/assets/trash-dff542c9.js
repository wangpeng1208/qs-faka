import{e as j,a8 as E,r,l as H,d as Q,o as q,P as w,a3 as F,a4 as t,f as o,H as c,Q as J,ab as O,a9 as W,I as B,a7 as V,ac as X,ad as Y}from"./vue-bf422dc1.js";import{g as Z,t as ee,r as ae,b as te}from"./card-c6ac5d29.js";import{l as oe}from"./category-7ca503b8.js";import{g as se}from"./good-8f08fe48.js";import{R as le}from"./index-efe651b4.js";import{p as ne}from"./global-0d825ba6.js";import{u as ie,_ as re}from"./index-c2dd6a24.js";import{t as ce}from"./constant-7e13a34d.js";import de from"./detail-488e114f.js";import{m as y,M as f,B as ue,l as pe,d as me,S as fe,L as _e,j as he,b as ge}from"./ui-ba7aaa7e.js";import"./no-list-e2f85d5e.js";import"./libs-51817cd7.js";import"./plugins-ca970193.js";import"./others-9f318174.js";import"./echarts-bf9d612c.js";import"./icons-a8498fb6.js";import"./date-20546ee0.js";const ve=_=>(X("data-v-729ea4de"),_=_(),Y(),_),ye=ve(()=>V("span",{style:{"padding-right":"20px"}},"库存回收站",-1)),Ce={key:0,class:"selected-count"},be={class:"category-header c-flex"},ke={name:"CardTrash"},Se=j({...ke,setup(_){const L=E(),T=ie(),P="id",h=r([]),i=r({defaultPageSize:20,total:0,defaultCurrent:1}),m=H({cate_id:"",goods_id:""}),g=r(!1),d=async()=>{g.value=!0;const e={...m,page:i.value.defaultCurrent,limit:i.value.defaultPageSize};try{const{data:a}=await Z(e);h.value=a.list,i.value={...i.value,total:a.total}}catch(a){console.log(a)}finally{g.value=!1}},C=r([]),I=async()=>{const{data:e}=await oe();C.value=e.list},b=r([]),R=async()=>{const{data:e}=await se();b.value=e},z=(e,a)=>{i.value.defaultCurrent=e.current,i.value.defaultPageSize=e.pageSize,d()},s=r([]),v=e=>{s.value=e},k=async e=>{e&&v(e.id);const a=y({header:"确认删除当前所选内容？",body:"删除后，所选信息将被清空，且无法恢复",confirmBtn:"确认",onConfirm:async()=>{a.hide();const l={ids:s.value};try{await ee(l),f.success("删除成功"),s.value=[],d()}catch(u){console.log(u)}}})},$=e=>{e>0&&v(e);const a=y({header:"提醒",body:"确定要恢复吗？",confirmBtn:"确认",onConfirm:({e:l})=>{a.hide();const u={ids:s.value};ae(u).then(p=>{p.code===1?(f.success("恢复成功"),d(),s.value=[]):f.error(`恢复失败：${p.msg}`)}).catch(p=>{f.error("恢复失败")})},onClose:({e:l,trigger:u})=>{a.hide()}})},N=()=>{const e=y({header:"确认清空回收站？",body:"清空后，回收站将被清空，且无法恢复",confirmBtn:"确认",onConfirm:async()=>{e.hide();try{await te(),f.success("清空成功"),d()}catch(a){console.log(a)}}})},A=Q(()=>({offsetTop:T.isUseTabsRouter?48:0,container:`.${ne}-layout`}));q(()=>{d(),I(),R()});const S=r(null),G=async e=>{S.value.init(e)};return(e,a)=>{const l=ue,u=pe,p=me,x=fe,D=_e,M=he,U=ge;return w(),F(U,{title:"库存回收站",class:"basic-container",bordered:!1},{title:t(()=>[ye,o(l,{variant:"base",disabled:!s.value.length,onClick:$},{default:t(()=>[c(" 批量恢复 ")]),_:1},8,["disabled"]),o(l,{variant:"base",theme:"danger",disabled:!s.value.length,onClick:a[0]||(a[0]=n=>k(""))},{default:t(()=>[c(" 批量删除 ")]),_:1},8,["disabled"]),o(l,{theme:"danger",disabled:!h.value.length,onClick:N},{default:t(()=>[c("清空回收站")]),_:1},8,["disabled"]),s.value.length?(w(),J("p",Ce,"已选"+O(s.value.length)+"项",1)):W("",!0)]),actions:t(()=>[o(l,{variant:"text",theme:"default",onClick:a[1]||(a[1]=n=>B(L).push("/merchant/goods/card"))},{icon:t(()=>[o(u,{name:"rollback"})]),default:t(()=>[c(" 返回 ")]),_:1})]),default:t(()=>[V("div",be,[o(x,null,{default:t(()=>[o(p,{modelValue:m.cate_id,"onUpdate:modelValue":a[2]||(a[2]=n=>m.cate_id=n),placeholder:"全部分类",type:"search",clearable:"",options:C.value},null,8,["modelValue","options"]),o(p,{modelValue:m.goods_id,"onUpdate:modelValue":a[3]||(a[3]=n=>m.goods_id=n),placeholder:"全部商品",type:"search",clearable:"",options:b.value,keys:{value:"id",label:"name"}},null,8,["modelValue","options"]),o(l,{theme:"default",variant:"outline",onClick:d},{default:t(()=>[c("查询")]),_:1})]),_:1})]),o(M,{data:h.value,columns:B(ce),"row-key":P,hover:!!h.value.length,pagination:i.value,"selected-row-keys":s.value,loading:g.value,"header-affixed-top":A.value,"table-layout":"auto","max-height":"auto",onPageChange:z,onSelectChange:v},{operation:t(({row:n})=>[o(x,null,{default:t(()=>[o(D,{size:"small",variant:"outline",theme:"primary",onClick:K=>G(n)},{default:t(()=>[c("查看")]),_:2},1032,["onClick"]),o(D,{size:"small",variant:"outline",theme:"danger",onClick:K=>k(n)},{default:t(()=>[c("删除")]),_:2},1032,["onClick"])]),_:2},1024)]),empty:t(()=>[o(le,{title:"",tip:"库存回收站为空",type:"list"})]),_:1},8,["data","columns","hover","pagination","selected-row-keys","loading","header-affixed-top"]),o(de,{ref_key:"cardDetailRef",ref:S},null,512)]),_:1})}}});const Ke=re(Se,[["__scopeId","data-v-729ea4de"]]);export{Ke as default};
