import{e as w,a8 as K,r as m,d as $,M as A,P as n,Q as B,f as s,a4 as t,H as l,I as D,a3 as i,A as f,a9 as M,F as N}from"./vue-bf422dc1.js";import{l as V,d as F}from"./collection-1a561a8a.js";import{p as I}from"./global-0d825ba6.js";import{u as L}from"./index-c2dd6a24.js";import{_ as E}from"./edit.vue_vue_type_script_setup_true_lang-c0e99565.js";import{M as H,A as Q,T as U,L as j,S as q,a as G,b as J}from"./ui-ba7aaa7e.js";import"./libs-51817cd7.js";import"./plugins-ca970193.js";import"./others-9f318174.js";import"./echarts-bf9d612c.js";import"./icons-a8498fb6.js";const O=[{colKey:"id",title:"通道ID"},{colKey:"title",title:"名称"},{colKey:"code",title:"接口代码"},{colKey:"show_name",title:"显示名称"},{colKey:"status",title:"状态"},{colKey:"operate",title:"操作",fixed:"right"}],ce=w({__name:"index",setup(W){const g=K(),v=(e=0)=>{g.push(`/admin/channel/settlement/account?id=${e}`)},a=m({defaultPageSize:20,total:0,defaultCurrent:1}),r=m([]),c=async()=>{const{data:e}=await V({page:a.value.defaultCurrent,limit:a.value.defaultPageSize,type:2});r.value=e.list,a.value={defaultPageSize:e.limit,total:e.total,defaultCurrent:e.page}};c();const y=e=>{a.value.defaultCurrent=e.current,a.value.defaultPageSize=e.pageSize,c()},k=L(),C=$(()=>({offsetTop:k.isUseTabsRouter?48:0,container:`.${I}-layout`})),p=m(),x=(e=0)=>{p.value.init(e)},S=async e=>{(await F({id:e})).code===1&&(H.success("删除成功"),c())};return(e,b)=>{const z=Q,_=U,u=j,R=q,P=G,T=J,d=A("perms");return n(),B(N,null,[s(T,{title:"结算通道管理",class:"basic-container",bordered:!1},{default:t(()=>[s(z,null,{default:t(()=>[l("用于结算给商户打款|自动轮询通道下的账号")]),_:1}),s(P,{ref:"tableRef","row-key":"id",data:r.value,columns:D(O),hover:r.value.length>0,"header-affixed-top":C.value,"max-height":"auto","table-layout":"auto",pagination:a.value,"lazy-load":"",onPageChange:y},{status:t(({row:o})=>[o.status===1?(n(),i(_,{key:0,theme:"success"},{default:t(()=>[l("启用")]),_:1})):(n(),i(_,{key:1,theme:"danger"},{default:t(()=>[l("禁用")]),_:1}))]),operate:t(({row:o})=>[s(R,null,{default:t(()=>[f((n(),i(u,{theme:"primary",size:"small",onClick:h=>x(o.id)},{default:t(()=>[l("编辑")]),_:2},1032,["onClick"])),[[d,["adminapi/channel/collection/edit"]]]),f((n(),i(u,{theme:"primary",size:"small",onClick:h=>v(o.id)},{default:t(()=>[l("账号管理")]),_:2},1032,["onClick"])),[[d,["adminapi/channel/collectionAccount/list"]]]),o.id!=1?f((n(),i(u,{key:0,theme:"danger",size:"small",onClick:h=>S(o.id)},{default:t(()=>[l("删除")]),_:2},1032,["onClick"])),[[d,["adminapi/channel/collection/del"]]]):M("",!0)]),_:2},1024)]),_:1},8,["data","columns","hover","header-affixed-top","pagination"])]),_:1}),s(E,{ref_key:"editRef",ref:p,onSuccess:c},null,512)],64)}}});export{ce as default};