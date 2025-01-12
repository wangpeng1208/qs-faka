import{e as I,r as m,l as N,d as R,a8 as U,o as z,P as i,a3 as u,a4 as t,a7 as v,f as s,I as p,H as n,ab as h,a9 as q}from"./vue-bf422dc1.js";import{l as g}from"./complaint-a7ef9524.js";import{R as w}from"./index-fb16f061.js";import{p as D}from"./global-0d825ba6.js";import{u as A}from"./index-8db2df2c.js";import{d as M,B as Q,S as $,T as E,L as H,a as O,b as Y}from"./ui-ba7aaa7e.js";import"./no-list-e2f85d5e.js";import"./libs-51817cd7.js";import"./plugins-ca970193.js";import"./others-9f318174.js";import"./echarts-bf9d612c.js";import"./icons-a8498fb6.js";const j=[{colKey:"trade_no",title:"投诉订单",ellipsis:!0},{colKey:"goods_name",title:"商品",ellipsis:!0},{colKey:"type",title:"投诉类型",ellipsis:!0},{colKey:"desc",title:"投诉说明",ellipsis:!0},{colKey:"qq",title:"QQ",ellipsis:!0},{colKey:"mobile",title:"手机",ellipsis:!0},{colKey:"status",title:"投诉处理状态",ellipsis:!0},{width:200,colKey:"create_at",title:"投诉时间"},{width:120,colKey:"action",title:"操作"}],F=[{label:"已处理",value:1},{label:"未处理",value:2},{label:"已撤销",value:-1}],G=[{label:"无效卡密",value:"无效卡密"},{label:"虚假商品",value:"虚假商品"},{label:"非法商品",value:"非法商品"},{label:"侵权商品",value:"侵权商品"},{label:"不能购买",value:"不能购买"},{label:"恐怖色情",value:"恐怖色情"},{label:"其他投诉",value:"其他投诉"}],J={class:"category-header c-flex"},W={class:"r c-flex"},X={name:"ComplaintIndex"},me=I({...X,setup(Z){const b=A(),f=m([]),l=m({defaultPageSize:20,total:0,defaultCurrent:1}),r=N({status:"",type:""}),_=m(!1),d=async()=>{_.value=!0;const o={page:l.value.defaultCurrent,limit:l.value.defaultPageSize,...r};try{const{data:a}=await g(o);f.value=a.list,a.list.length===0?l.value=null:l.value={...l.value,total:a.total}}catch(a){console.log(a)}finally{_.value=!1}},C="id",S=(o,a)=>{l.value.defaultCurrent=o.current,l.value.defaultPageSize=o.pageSize,d()},k=R(()=>({offsetTop:b.isUseTabsRouter?48:0,container:`.${D}-layout`})),x=U(),T=o=>{x.push({name:"merchantComplaintDetail",query:{id:o}})};return z(()=>{d()}),(o,a)=>{const y=M,K=Q,V=$,c=E,P=H,B=O,L=Y;return i(),u(L,{title:"投诉管理",class:"basic-container",bordered:!1},{default:t(()=>[v("div",J,[v("div",W,[s(V,null,{default:t(()=>[s(y,{modelValue:r.status,"onUpdate:modelValue":a[0]||(a[0]=e=>r.status=e),placeholder:"全部状态",type:"search",clearable:"",options:p(F)},null,8,["modelValue","options"]),s(y,{modelValue:r.type,"onUpdate:modelValue":a[1]||(a[1]=e=>r.type=e),placeholder:"全部类型",type:"search",clearable:"",options:p(G)},null,8,["modelValue","options"]),s(K,{theme:"default",variant:"outline",onClick:d},{default:t(()=>[n("查询")]),_:1})]),_:1})])]),s(B,{data:f.value,columns:p(j),"row-key":C,"vertical-align":"top",hover:p(g).length>0,pagination:l.value,"header-affixed-top":k.value,"max-height":"auto",onPageChange:S},{money:t(({row:e})=>[e.money<0?(i(),u(c,{key:0,theme:"danger"},{default:t(()=>[n(h(e.money),1)]),_:2},1024)):(i(),u(c,{key:1,theme:"success"},{default:t(()=>[n(h(e.money),1)]),_:2},1024))]),status:t(({row:e})=>[e.status===0?(i(),u(c,{key:0,variant:"light",theme:"danger"},{default:t(()=>[n("未处理")]),_:1})):e.status===1?(i(),u(c,{key:1,variant:"light",theme:"success"},{default:t(()=>[n("已处理")]),_:1})):e.status===-1?(i(),u(c,{key:2,variant:"light",theme:"success"},{default:t(()=>[n("已撤销")]),_:1})):q("",!0)]),empty:t(()=>[s(w,{title:"",tip:"暂无投诉",type:"list"})]),action:t(({row:e})=>[s(P,{theme:"primary",onClick:ee=>T(e.id)},{default:t(()=>[n("详情")]),_:2},1032,["onClick"])]),_:1},8,["data","columns","hover","pagination","header-affixed-top"])]),_:1})}}});export{me as default};
