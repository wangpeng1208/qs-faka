import{e as D,a8 as R,r as _,o as $,d as G,P as i,a3 as z,a4 as o,a7 as h,f as d,I as m,H as f,Q as u,ab as r,a9 as C,ac as N,ad as V}from"./vue-bf422dc1.js";import{g as M,b as w}from"./coupon-a6db8847.js";import{R as A}from"./index-fb16f061.js";import{p as L}from"./global-0d825ba6.js";import{u as j,c as E,_ as H}from"./index-8db2df2c.js";import{l as K}from"./constant-b61c1b97.js";import{_ as Q}from"./ExportCoupon.vue_vue_type_script_setup_true_lang-e2206567.js";import{m as U,M as x,B as q,j as F,b as J}from"./ui-ba7aaa7e.js";import"./no-list-e2f85d5e.js";import"./libs-51817cd7.js";import"./plugins-ca970193.js";import"./others-9f318174.js";import"./echarts-bf9d612c.js";import"./icons-a8498fb6.js";import"./date-20546ee0.js";import"./category-c9a07555.js";const O=p=>(N("data-v-9c4d7f36"),p=p(),V(),p),W={class:"category-header c-flex"},X={class:"l"},Y={key:0,class:"selected-count"},Z=O(()=>h("div",{class:"r c-flex"},null,-1)),ee=["onClick"],te={key:0},ae={key:1},oe={key:0},se={key:1},ne={name:"GoodsCoponIndex"},le=D({...ne,setup(p){const b=R(),k=j(),g=_([]),s=_({defaultPageSize:20,total:0,defaultCurrent:1}),v=_(!1),y=async()=>{const a={page:s.value.defaultCurrent,limit:s.value.defaultPageSize};v.value=!0;try{const{data:t}=await M(a);g.value=t.list,s.value={...s.value,total:t.total}}catch(t){console.log(t)}finally{v.value=!1}};$(()=>{y()});const n=_([]),S=a=>{n.value=a},P=(a,t)=>{s.value.defaultCurrent=a.current,s.value.defaultPageSize=a.pageSize,y()},B=G(()=>({offsetTop:k.isUseTabsRouter?48:0,container:`.${L}-layout`})),I=async()=>{const a=U({header:"是否确认删除？",body:"未使用的优惠券会被删除至回收站，已使用或者已过期的优惠券会被直接删除！",confirmBtn:"确认",onConfirm:({e:t})=>{a.hide();const l={ids:n.value};w(l).then(c=>{c.code===1?(x.success(c.msg),y(),n.value=[]):x.error(`删除失败：${c.msg}`)}).catch(c=>{x.error("删除失败")})},onClose:({e:t,trigger:l})=>{a.hide()}})};return(a,t)=>{const l=q,c=F,T=J;return i(),z(T,{title:"优惠券列表",class:"basic-container",bordered:!1},{default:o(()=>[h("div",W,[h("div",X,[d(l,{onClick:t[0]||(t[0]=e=>m(b).push({name:"merchantGoodsCouponAdd"}))},{default:o(()=>[f(" 添加 ")]),_:1}),d(l,{theme:"danger",onClick:t[1]||(t[1]=e=>m(b).push({name:"merchantGoodsCouponTrash"}))},{default:o(()=>[f(" 回收站 ")]),_:1}),d(l,{variant:"base",theme:"default",disabled:!n.value.length,onClick:I},{default:o(()=>[f(" 批量删除 ")]),_:1},8,["disabled"]),n.value.length?(i(),u("p",Y,"已选"+r(n.value.length)+"项",1)):C("",!0)]),Z]),d(c,{data:g.value,columns:m(K),"row-key":"id","vertical-align":"top",hover:!!g.value.length,pagination:s.value,"selected-row-keys":n.value,loading:v.value,"header-affixed-top":B.value,"max-height":"auto","table-layout":"auto",onPageChange:P,onSelectChange:S},{code:o(({row:e})=>[h("span",{title:"点击复制",onClick:ce=>m(E)(e.code)},r(e.code),9,ee)]),amount:o(({row:e})=>[e.type===1?(i(),u("span",te,r(e.amount),1)):C("",!0),e.type===100?(i(),u("span",ae,r(e.amount)+"%",1)):C("",!0)]),min_banlance:o(({row:e})=>[e.min_banlance?(i(),u("span",oe,r(e.min_banlance),1)):(i(),u("span",se,"-"))]),expire_day:o(({row:e})=>[f(r(e.expire_day),1)]),empty:o(()=>[d(A,{title:"",tip:"优惠券为空",type:"list"})]),_:1},8,["data","columns","hover","pagination","selected-row-keys","loading","header-affixed-top"]),d(Q,{ref:"exportRef"},null,512)]),_:1})}}});const Se=H(le,[["__scopeId","data-v-9c4d7f36"]]);export{Se as default};
