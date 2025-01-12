import{a as U}from"./charts-9fa92d83.js";import{l as A}from"./category-7ca503b8.js";import{g as G}from"./good-8f08fe48.js";import{R as O}from"./index-efe651b4.js";import{p as F}from"./global-0d825ba6.js";import{u as H,n as v,_ as $}from"./index-c2dd6a24.js";import{f as j}from"./date-20546ee0.js";import{T as q,S as E,d as J,B as Q,a as W,b as X}from"./ui-ba7aaa7e.js";import{e as Y,l as S,r,o as Z,d as tt,P as u,a3 as d,a4 as t,a7 as p,f as s,H as l,ab as f,I as _,a9 as b}from"./vue-bf422dc1.js";import"./no-list-e2f85d5e.js";import"./libs-51817cd7.js";import"./plugins-ca970193.js";import"./others-9f318174.js";import"./echarts-bf9d612c.js";import"./icons-a8498fb6.js";const et=[{title:"订单号",align:"left",colKey:"trade_no"},{title:"商品名称",colKey:"goods_name"},{title:"支付方式",colKey:"paytype"},{title:"总价",colKey:"total_product_price"},{title:"购买者信息",colKey:"contact"},{title:"状态",colKey:"status"},{title:"取卡状态",colKey:"task_status"},{title:"创建时间",ellipsis:!0,colKey:"create_at"}],at={class:"category-header c-flex"},ot={class:"l c-flex"},st={class:"r c-flex"},lt={name:"FinanceMoney"},nt=Y({...lt,setup(ct){const K=H(),m=S({cate_id:"",goods_id:""}),T="id",n=r({defaultPageSize:10,total:0,defaultCurrent:1}),g=r([]),i=S({total_price:0,total_cost_price:0,total_profit:0}),h=r(!1),y=async()=>{h.value=!0;const e={page:n.value.defaultCurrent,limit:n.value.defaultPageSize,...m};try{const{data:a}=await U(e);g.value=a.list,i.total_cost_price=a.charts.total_cost_price,i.total_price=a.charts.total_price,i.total_profit=a.charts.total_profit,n.value={...n.value,total:a.total}}catch(a){console.log(a)}finally{h.value=!1}},V=r([]),w=async()=>{const{data:e}=await A();V.value=e.list},C=r([]),z=async()=>{const{data:e}=await G();C.value=e};Z(()=>{y(),w(),z()});const k=r([]),P=e=>{k.value=e},B=(e,a)=>{n.value.defaultCurrent=e.current,n.value.defaultPageSize=e.pageSize,y()},L=(e,a)=>{},M=tt(()=>({offsetTop:K.isUseTabsRouter?48:0,container:`.${F}-layout`}));return(e,a)=>{const c=q,x=E,N=J,R=Q,D=W,I=X;return u(),d(I,{title:"收益统计",class:"basic-container",bordered:!1},{default:t(()=>[p("div",at,[p("div",ot,[s(x,null,{default:t(()=>[s(c,{variant:"light",theme:"success",size:"large"},{default:t(()=>[l("总收入"+f(_(v)(i.total_price)),1)]),_:1}),s(c,{variant:"light",theme:"success",size:"large"},{default:t(()=>[l("总成本"+f(_(v)(i.total_cost_price)),1)]),_:1}),s(c,{variant:"light",theme:"success",size:"large"},{default:t(()=>[l("总利润"+f(_(v)(i.total_profit)),1)]),_:1})]),_:1})]),p("div",st,[s(x,null,{default:t(()=>[s(N,{modelValue:m.goods_id,"onUpdate:modelValue":a[0]||(a[0]=o=>m.goods_id=o),placeholder:"全部商品",type:"search",clearable:"",options:C.value,keys:{value:"id",label:"name"}},null,8,["modelValue","options"]),s(R,{theme:"default",variant:"outline",onClick:y},{default:t(()=>[l("查询")]),_:1})]),_:1})])]),s(D,{data:g.value,columns:_(et),"row-key":T,"vertical-align":"top",hover:g.value.length>0,pagination:n.value,"selected-row-keys":k.value,loading:h.value,"table-layout":"auto","max-height":"auto","header-affixed-top":M.value,onPageChange:B,onChange:L,onSelectChange:P},{status:t(({row:o})=>[o.status===0?(u(),d(c,{key:0,variant:"light",theme:"danger"},{default:t(()=>[l("未付款")]),_:1})):o.status===1?(u(),d(c,{key:1,variant:"light",theme:"success"},{default:t(()=>[l("已付款")]),_:1})):b("",!0)]),task_status:t(({row:o})=>[o.task_status!=="已取"?(u(),d(c,{key:0,variant:"light",theme:"danger"},{default:t(()=>[l("未取")]),_:1})):o.task_status==="已取"?(u(),d(c,{key:1,variant:"light",theme:"success"},{default:t(()=>[l("已取")]),_:1})):b("",!0)]),create_at:t(({row:o})=>[p("span",null,f(_(j)(o.create_at)),1)]),empty:t(()=>[s(O,{title:"",tip:"相关数据为空",type:"list"})]),_:1},8,["data","columns","hover","pagination","selected-row-keys","loading","header-affixed-top"])]),_:1})}}});const St=$(nt,[["__scopeId","data-v-35ed4f1f"]]);export{St as default};
