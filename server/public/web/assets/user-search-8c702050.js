import{j as z}from"./user-8ed5a501.js";import{p as P}from"./global-0d825ba6.js";import{u as w}from"./index-b0aabda4.js";import{T as U,L as D,j as K,f as j}from"./ui-ba7aaa7e.js";import{e as B,r as l,d as I,P as i,a3 as r,a4 as a,f as m,H as c}from"./vue-bf422dc1.js";import"./libs-51817cd7.js";import"./plugins-ca970193.js";import"./others-9f318174.js";import"./echarts-bf9d612c.js";import"./icons-a8498fb6.js";const L={name:"UserSearch"},Q=B({...L,emits:["success"],setup(N,{expose:v,emit:_}){const g=_,h=e=>{g("success",e),s.value=!1},y=[{colKey:"id",title:"ID"},{colKey:"username",title:"账号"},{colKey:"operate",title:"选择"}],t=l({defaultPageSize:20,total:0,defaultCurrent:1}),n=l([]),u=l(0),f=async()=>{const{data:e}=await z({page:t.value.defaultCurrent,limit:t.value.defaultPageSize,noUser:u.value});n.value=e.list,t.value={...t.value,total:e.total}},k=e=>{t.value.defaultCurrent=e.current,t.value.defaultPageSize=e.pageSize,f()},x=w(),b=I(()=>({offsetTop:x.isUseTabsRouter?48:0,container:`.${P}-layout`})),s=l(!1);return v({init:e=>{u.value=e,f(),s.value=!0}}),(e,p)=>{const d=U,C=D,S=K,T=j;return i(),r(T,{visible:s.value,"onUpdate:visible":p[0]||(p[0]=o=>s.value=o),"close-on-overlay-click":!1,"destroy-on-close":!0,header:"选择上级用户","close-on-esc-keydown":!1,footer:!1},{default:a(()=>[m(S,{data:n.value,columns:y,"row-key":"id",hover:n.value.length>0,pagination:t.value,"header-affixed-top":b.value,"table-layout":"auto","max-height":"100%",onPageChange:k},{status:a(({row:o})=>[o.status===1?(i(),r(d,{key:0,theme:"success"},{default:a(()=>[c("启用")]),_:1})):(i(),r(d,{key:1,theme:"danger"},{default:a(()=>[c("禁用")]),_:1}))]),operate:a(({row:o})=>[m(C,{theme:"primary",size:"small",onClick:$=>h(o.id)},{default:a(()=>[c("选择")]),_:2},1032,["onClick"])]),_:1},8,["data","hover","pagination","header-affixed-top"])]),_:1},8,["visible"])}}});export{Q as default};