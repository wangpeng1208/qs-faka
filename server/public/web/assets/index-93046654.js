import{e as w,a8 as B,r as m,d as A,M as $,P as o,a3 as s,a4 as t,a7 as y,A as p,H as l,f,I as D}from"./vue-bf422dc1.js";import{l as M,d as N}from"./collectionAccount-80086d0f.js";import{p as V}from"./global-0d825ba6.js";import{u as L}from"./index-8db2df2c.js";import{c as q,_ as H}from"./edit.vue_vue_type_script_setup_true_lang-6aff6cfa.js";import{M as I,B as U,T as j,L as E,S as F,a as G,b as J}from"./ui-ba7aaa7e.js";import"./libs-51817cd7.js";import"./plugins-ca970193.js";import"./others-9f318174.js";import"./echarts-bf9d612c.js";import"./icons-a8498fb6.js";import"./index.vue_vue_type_script_setup_true_lang-b9ebc9cb.js";import"./config-3b189d83.js";const K={class:"category-header c-flex"},O={class:"l"},ue=w({__name:"index",setup(Q){const r=+B().currentRoute.value.query.id,a=m({defaultPageSize:20,total:0,defaultCurrent:1}),u=m([]),c=async()=>{const{data:e}=await M({page:a.value.defaultCurrent,limit:a.value.defaultPageSize,type:2,id:r});u.value=e.list,a.value={defaultPageSize:e.limit,total:e.total,defaultCurrent:e.page}};c();const k=e=>{a.value.defaultCurrent=e.current,a.value.defaultPageSize=e.pageSize,c()},C=L(),x=A(()=>({offsetTop:C.isUseTabsRouter?48:0,container:`.${V}-layout`})),_=m(),v=(e=0,n=0)=>{_.value.init(e,n)},b=async e=>{(await N({id:e})).code===1&&(I.success("删除成功"),c())};return(e,n)=>{const S=U,g=j,h=E,z=F,R=G,P=J,d=$("perms");return o(),s(P,{title:"收款通道账号管理",class:"basic-container",bordered:!1},{default:t(()=>[y("div",K,[y("div",O,[p((o(),s(S,{theme:"primary",onClick:n[0]||(n[0]=i=>v(r))},{default:t(()=>[l("添加")]),_:1})),[[d,["adminapi/channel/collectionAccount/add"]]])])]),f(R,{ref:"tableRef","row-key":"id",data:u.value,columns:D(q),hover:u.value.length>0,"header-affixed-top":x.value,"max-height":"auto","table-layout":"auto",pagination:a.value,"lazy-load":"",onPageChange:k},{status:t(({row:i})=>[i.status===1?(o(),s(g,{key:0,theme:"success"},{default:t(()=>[l("启用")]),_:1})):(o(),s(g,{key:1,theme:"danger"},{default:t(()=>[l("禁用")]),_:1}))]),operate:t(({row:i})=>[f(z,null,{default:t(()=>[p((o(),s(h,{theme:"primary",size:"small",onClick:T=>v(r,i.id)},{default:t(()=>[l("编辑")]),_:2},1032,["onClick"])),[[d,["adminapi/channel/collectionAccount/edit"]]]),p((o(),s(h,{theme:"danger",size:"small",onClick:T=>b(i.id)},{default:t(()=>[l("删除")]),_:2},1032,["onClick"])),[[d,["adminapi/channel/collectionAccount/del"]]])]),_:2},1024)]),_:1},8,["data","columns","hover","header-affixed-top","pagination"]),f(H,{ref_key:"editRef",ref:_,onSuccess:c},null,512)]),_:1})}}});export{ue as default};
