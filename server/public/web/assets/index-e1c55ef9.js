import{u as g,o as m,_ as v}from"./index-8db2df2c.js";import{p as h}from"./global-0d825ba6.js";import{A as x,a as y,b as C}from"./ui-ba7aaa7e.js";import{e as b,r as n,d as P,P as S,a3 as I,a4 as i,f as r,H as K,I as L}from"./vue-bf422dc1.js";import"./libs-51817cd7.js";import"./plugins-ca970193.js";import"./others-9f318174.js";import"./echarts-bf9d612c.js";import"./icons-a8498fb6.js";const T=[{colKey:"id",title:"登录编号"},{colKey:"user_id",title:"用户ID",ellipsis:!0,cell:"user_id"},{colKey:"username",title:"账号"},{colKey:"ip",title:"	登录IP"},{colKey:"create_at",title:"	登录时间",fixed:"right"}],z={name:"UserLogLogin"},k=b({...z,setup(w){const u=g(),o=n([]),e=n({defaultPageSize:20,total:0,defaultCurrent:1}),l=n(!1),s=async()=>{l.value=!0;const a={page:e.value.defaultCurrent,limit:e.value.defaultPageSize};try{const{data:t}=await m(a);o.value=t.list,t.list.length===0||(e.value={...e.value,total:t.total})}catch(t){console.log(t)}finally{l.value=!1}};s();const c=(a,t)=>{e.value.defaultCurrent=a.current,e.value.defaultPageSize=a.pageSize,s()},d=P(()=>({offsetTop:u.isUseTabsRouter?48:0,container:`.${h}-layout`}));return(a,t)=>{const _=x,f=y,p=C;return S(),I(p,{title:"登陆日志",bordered:!1},{default:i(()=>[r(_,null,{default:i(()=>[K("只保留显示最近30天的登录日志")]),_:1}),r(f,{data:o.value,columns:L(T),"row-key":"id","vertical-align":"top",hover:o.value.length>0,pagination:e.value,"table-layout":"auto","header-affixed-top":d.value,"max-height":"100%",loading:l.value,onPageChange:c},null,8,["data","columns","hover","pagination","header-affixed-top","loading"])]),_:1})}}});const R=v(k,[["__scopeId","data-v-078a1993"]]);export{R as default};