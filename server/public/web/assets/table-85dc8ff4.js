import{p as c}from"./global-0d825ba6.js";import{u as d}from"./index-8db2df2c.js";import{r as n,d as p}from"./vue-bf422dc1.js";const g=d();function P(u){const{fetchFun:l,params:i={}}=u,t=n(!1),s=n(),a=n({defaultPageSize:20,total:0,defaultCurrent:1}),o=async()=>{t.value=!0;const e={page:a.value.defaultCurrent,limit:a.value.defaultPageSize,...i},{data:r}=await l(e);s.value=r.list,a.value={...a.value,total:r.total},t.value=!1},f=p(()=>({offsetTop:g.isUseTabsRouter?48:0,container:`.${c}-layout`}));return{pagination:a,fetchData:o,dataLoading:t,headerAffixedTop:f,rehandlePageChange:e=>{a.value.defaultCurrent=e.current,a.value.defaultPageSize=e.pageSize,o()},lists:s,searchData:async()=>{a.value.defaultCurrent=1,await o()}}}export{P as t};
