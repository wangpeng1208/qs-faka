import{e as S,l as b,r as n,d,P as w,a3 as C,a4 as r,a7 as o,ab as p,A as K,f,B as z,I as D,ae as P}from"./vue-bf422dc1.js";import{_ as T,l as k}from"./search.vue_vue_type_script_setup_true_lang-e34ed2c7.js";import{p as B}from"./global-0d825ba6.js";import{u as j}from"./index-8db2df2c.js";import{j as $,b as A}from"./ui-ba7aaa7e.js";import"./icons-a8498fb6.js";import"./libs-51817cd7.js";import"./plugins-ca970193.js";import"./others-9f318174.js";import"./echarts-bf9d612c.js";const F=[{colKey:"id",title:"ID"},{colKey:"username",title:"商户账号"},{colKey:"hander",title:"操作人",width:"100px"},{colKey:"business_type",title:"类型",width:"120px"},{colKey:"money",title:"资金变动",width:"100px"},{colKey:"balance",title:"剩余金额",width:"100px"},{colKey:"reason",title:"说明"},{colKey:"create_at",title:"变动时间",width:"160px"}],I={class:"category-header c-flex"},N={class:"l"},Q=S({__name:"index",setup(R){const c=b({}),m=e=>{Object.assign(c,e),l()},a=n(!1),h=d(()=>a.value?"收起搜索":"展开搜索"),t=n({defaultPageSize:20,total:0,defaultCurrent:1}),s=n([]),l=async()=>{const{data:e}=await k({page:t.value.defaultCurrent,limit:t.value.defaultPageSize,...c});s.value=e.list,t.value={...t.value,total:e.total}};l();const v=e=>{t.value.defaultCurrent=e.current,t.value.defaultPageSize=e.pageSize,l()},_=j(),y=d(()=>({offsetTop:_.isUseTabsRouter?48:0,container:`.${B}-layout`}));return(e,u)=>{const g=$,x=A;return w(),C(x,{title:"资金日志",class:"basic-container",bordered:!1},{actions:r(()=>[o("a",{href:"javascript:void(0)",onClick:u[0]||(u[0]=i=>a.value=!a.value)},p(h.value),1)]),default:r(()=>[o("div",I,[o("div",N,[K(f(T,{ref:"searchFormRef",onSuccess:m},null,512),[[z,a.value]])])]),f(g,{data:s.value,columns:D(F),"row-key":"id",hover:s.value.length>0,pagination:t.value,"header-affixed-top":y.value,"table-layout":"auto","max-height":"100%",onPageChange:v},{money:r(({row:i})=>[o("span",{style:P({color:i.money>0?"#52c41a":"#f5222d"})},p(i.money),5)]),_:1},8,["data","columns","hover","pagination","header-affixed-top"])]),_:1})}}});export{Q as default};