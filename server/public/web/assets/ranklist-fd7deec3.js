import{b as _}from"./charts-16b961dd.js";import{R as K}from"./index-9229ca78.js";import{p as M}from"./global-0d825ba6.js";import{u as N,d as z}from"./index-b0aabda4.js";import{f as D}from"./date-20546ee0.js";import{T as R}from"./icons-a8498fb6.js";import{M as U,I as A,B as L,S as F,T as H,a as O,b as $}from"./ui-ba7aaa7e.js";import{e as j,l as q,r,o as E,d as G,P as d,a3 as f,a4 as a,a7 as v,f as n,I as p,H as m,a9 as J,ab as Q}from"./vue-bf422dc1.js";import"./no-list-e2f85d5e.js";import"./libs-51817cd7.js";import"./plugins-ca970193.js";import"./others-9f318174.js";import"./echarts-bf9d612c.js";const W=[{title:"买家",align:"left",width:"33%",colKey:"contact"},{title:"	购买次数",width:"33%",colKey:"times"},{title:"付款总额",colKey:"money",width:"33%"}],X={class:"category-header c-flex"},Y={name:"ChartChartlist"},pe=j({...Y,setup(Z){const y=N(),l=q({}),C="id",o=r({defaultPageSize:10,total:0,defaultCurrent:1}),i=r([]),w=r([]),c=r(!1),u=async()=>{if(c.value=!0,l.action==="export"){const t={...l},e=await _(t);e.code===1?z(e.data.url):U.error(e.msg),c.value=!1}else{const t={page:o.value.defaultCurrent,limit:o.value.defaultPageSize,...l};try{const{data:e}=await _(t);i.value=e.list,w.value=e.charts,o.value={...o.value,total:e.total}}catch(e){console.log(e)}finally{c.value=!1}}};E(()=>{u()});const g=r([]),S=t=>{g.value=t},b=(t,e)=>{o.value.defaultCurrent=t.current,o.value.defaultPageSize=t.pageSize,u()},x=(t,e)=>{},k=G(()=>({offsetTop:y.isUseTabsRouter?48:0,container:`.${M}-layout`}));return(t,e)=>{const T=A,P=L,V=F,h=H,B=O,I=$;return d(),f(I,{title:"累计消费",class:"basic-container",bordered:!1},{default:a(()=>[v("div",X,[n(V,null,{default:a(()=>[n(T,{modelValue:l.keywords,"onUpdate:modelValue":e[0]||(e[0]=s=>l.keywords=s),placeholder:"请输入联系方式",clearable:""},{"suffix-icon":a(()=>[n(p(R))]),_:1},8,["modelValue"]),n(P,{theme:"default",variant:"outline",onClick:u},{default:a(()=>[m("查询")]),_:1})]),_:1})]),n(B,{data:i.value,columns:p(W),"row-key":C,"vertical-align":"top",hover:i.value.length>0,pagination:o.value,"selected-row-keys":g.value,loading:c.value,"table-layout":"auto","max-height":"auto","header-affixed-top":k.value,onPageChange:b,onChange:x,onSelectChange:S},{status:a(({row:s})=>[s.status===0?(d(),f(h,{key:0,variant:"light",theme:"danger"},{default:a(()=>[m("未付款")]),_:1})):s.status===1?(d(),f(h,{key:1,variant:"light",theme:"success"},{default:a(()=>[m("已付款")]),_:1})):J("",!0)]),create_at:a(({row:s})=>[v("span",null,Q(p(D)(s.create_at)),1)]),empty:a(()=>[n(K,{title:"",tip:"相关数据为空",type:"list"})]),_:1},8,["data","columns","hover","pagination","selected-row-keys","loading","header-affixed-top"])]),_:1})}}});export{pe as default};