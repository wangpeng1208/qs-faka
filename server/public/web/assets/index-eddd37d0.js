import{e as T,a8 as w,r as f,d as A,M as K,P as o,Q as $,f as r,a4 as t,a7 as y,A as p,a3 as l,H as i,I as D,F as M}from"./vue-bf422dc1.js";import{l as N,d as V}from"./collectionAccount-e5ff91b2.js";import{p as F}from"./global-0d825ba6.js";import{u as L}from"./index-b0aabda4.js";import{_ as q}from"./edit.vue_vue_type_script_setup_true_lang-e7896d45.js";import{M as E,B as H,T as I,L as Q,S as U,a as j,b as G}from"./ui-ba7aaa7e.js";import"./libs-51817cd7.js";import"./plugins-ca970193.js";import"./others-9f318174.js";import"./echarts-bf9d612c.js";import"./icons-a8498fb6.js";const J=[{colKey:"id",title:"账号编号"},{colKey:"name",title:"账号备注"},{colKey:"code",title:"接口代码"},{colKey:"status",title:"状态"},{colKey:"operate",title:"操作",fixed:"right"}],O={class:"category-header c-flex"},W={class:"l"},ue=T({__name:"index",setup(X){const u=+w().currentRoute.value.query.id,a=f({defaultPageSize:20,total:0,defaultCurrent:1}),d=f([]),c=async()=>{const{data:e}=await N({page:a.value.defaultCurrent,limit:a.value.defaultPageSize,type:2,id:u});d.value=e.list,a.value={defaultPageSize:e.limit,total:e.total,defaultCurrent:e.page}};c();const k=e=>{a.value.defaultCurrent=e.current,a.value.defaultPageSize=e.pageSize,c()},C=L(),x=A(()=>({offsetTop:C.isUseTabsRouter?48:0,container:`.${F}-layout`})),_=f(),g=(e=0,s=0)=>{_.value.init(e,s)},b=async e=>{(await V({id:e})).code===1&&(E.success("删除成功"),c())};return(e,s)=>{const S=H,h=I,v=Q,z=U,R=j,B=G,m=K("perms");return o(),$(M,null,[r(B,{title:"结算账号管理",class:"basic-container",bordered:!1},{default:t(()=>[y("div",O,[y("div",W,[p((o(),l(S,{theme:"primary",onClick:s[0]||(s[0]=n=>g(u))},{default:t(()=>[i("添加")]),_:1})),[[m,["adminapi/channel/collectionAccount/add"]]])])]),r(R,{ref:"tableRef","row-key":"id",data:d.value,columns:D(J),hover:d.value.length>0,"header-affixed-top":x.value,"max-height":"auto","table-layout":"auto",pagination:a.value,"lazy-load":"",onPageChange:k},{status:t(({row:n})=>[n.status===1?(o(),l(h,{key:0,theme:"success"},{default:t(()=>[i("启用")]),_:1})):(o(),l(h,{key:1,theme:"danger"},{default:t(()=>[i("禁用")]),_:1}))]),operate:t(({row:n})=>[r(z,null,{default:t(()=>[p((o(),l(v,{theme:"primary",size:"small",onClick:P=>g(u,n.id)},{default:t(()=>[i("编辑")]),_:2},1032,["onClick"])),[[m,["adminapi/channel/collectionAccount/edit"]]]),p((o(),l(v,{theme:"danger",size:"small",onClick:P=>b(n.id)},{default:t(()=>[i("删除")]),_:2},1032,["onClick"])),[[m,["adminapi/channel/collectionAccount/del"]]])]),_:2},1024)]),_:1},8,["data","columns","hover","header-affixed-top","pagination"])]),_:1}),r(q,{ref_key:"editRef",ref:_,onSuccess:c},null,512)],64)}}});export{ue as default};