import{e as U,r as m,l as z,d as q,o as w,a8 as D,P as i,a3 as n,a4 as e,a7 as g,f as s,I as p,H as l,ab as b,a9 as k}from"./vue-bf422dc1.js";import{l as C,a as $}from"./complaint-ae10d288.js";import{R as A}from"./index-efe651b4.js";import{p as M}from"./global-0d825ba6.js";import{u as O}from"./index-c2dd6a24.js";import{d as Q,B as E,S as H,T as Y,L as j,a as F,b as G}from"./ui-ba7aaa7e.js";import"./no-list-e2f85d5e.js";import"./libs-51817cd7.js";import"./plugins-ca970193.js";import"./others-9f318174.js";import"./echarts-bf9d612c.js";import"./icons-a8498fb6.js";const J=[{colKey:"trade_no",title:"投诉订单",ellipsis:!0},{colKey:"user_id",title:"商户ID",ellipsis:!0},{colKey:"username",title:"商户账号",ellipsis:!0},{colKey:"type",title:"投诉类型",ellipsis:!0},{colKey:"desc",title:"投诉说明",ellipsis:!0},{colKey:"qq",title:"QQ",ellipsis:!0},{colKey:"mobile",title:"手机",ellipsis:!0},{colKey:"pwd",title:"密码",ellipsis:!0},{colKey:"status",title:"状态",ellipsis:!0},{colKey:"admin_read",title:"读取状态",ellipsis:!0},{colKey:"create_ip",title:"IP",ellipsis:!0},{width:200,colKey:"create_at",title:"投诉时间"},{width:120,colKey:"action",title:"操作",fixed:"right"}],W=[{label:"已处理",value:1},{label:"未处理",value:2},{label:"已撤销",value:-1}],X=[{label:"无效卡密",value:"无效卡密"},{label:"虚假商品",value:"虚假商品"},{label:"非法商品",value:"非法商品"},{label:"侵权商品",value:"侵权商品"},{label:"不能购买",value:"不能购买"},{label:"恐怖色情",value:"恐怖色情"},{label:"其他投诉",value:"其他投诉"}],Z={class:"category-header c-flex"},ee={class:"r c-flex"},te={name:"ComplaintIndex"},fe=U({...te,setup(ae){const S=O(),_=m([]),u=m({defaultPageSize:20,total:0,defaultCurrent:1}),c=z({status:"",type:""}),f=m(!1),d=async()=>{f.value=!0;const o={page:u.value.defaultCurrent,limit:u.value.defaultPageSize,...c};try{const{data:a}=await C(o);_.value=a.list,a.list.length===0||(u.value={...u.value,total:a.total})}catch(a){console.log(a)}finally{f.value=!1}},K="id",x=(o,a)=>{u.value.defaultCurrent=o.current,u.value.defaultPageSize=o.pageSize,d()},T=q(()=>({offsetTop:S.isUseTabsRouter?48:0,container:`.${M}-layout`}));w(()=>{d()});const V=D(),P=o=>{V.push({name:"adminOrderComplaint/detail",query:{id:o}})},I=o=>{$({id:o}).then(()=>{d()})};return(o,a)=>{const y=Q,B=E,h=H,r=Y,v=j,L=F,R=G;return i(),n(R,{title:"投诉管理",class:"basic-container",bordered:!1},{default:e(()=>[g("div",Z,[g("div",ee,[s(h,null,{default:e(()=>[s(y,{modelValue:c.status,"onUpdate:modelValue":a[0]||(a[0]=t=>c.status=t),placeholder:"全部状态",type:"search",clearable:"",options:p(W)},null,8,["modelValue","options"]),s(y,{modelValue:c.type,"onUpdate:modelValue":a[1]||(a[1]=t=>c.type=t),placeholder:"全部类型",type:"search",clearable:"",options:p(X)},null,8,["modelValue","options"]),s(B,{theme:"default",variant:"outline",onClick:d},{default:e(()=>[l("查询")]),_:1})]),_:1})])]),s(L,{data:_.value,columns:p(J),"row-key":K,"vertical-align":"top",hover:p(C).length>0,pagination:u.value,"header-affixed-top":T.value,"max-height":"auto",onPageChange:x},{money:e(({row:t})=>[t.money<0?(i(),n(r,{key:0,theme:"danger"},{default:e(()=>[l(b(t.money),1)]),_:2},1024)):(i(),n(r,{key:1,theme:"success"},{default:e(()=>[l(b(t.money),1)]),_:2},1024))]),status:e(({row:t})=>[t.status===0?(i(),n(r,{key:0,variant:"light",theme:"danger"},{default:e(()=>[l("未处理")]),_:1})):t.status===1?(i(),n(r,{key:1,variant:"light",theme:"success"},{default:e(()=>[l("已处理")]),_:1})):t.status===-1?(i(),n(r,{key:2,variant:"light",theme:"success"},{default:e(()=>[l("已撤销")]),_:1})):k("",!0)]),admin_read:e(({row:t})=>[t.admin_read===0?(i(),n(r,{key:0,variant:"light",theme:"danger"},{default:e(()=>[l("未读")]),_:1})):t.admin_read===1?(i(),n(r,{key:1,variant:"light",theme:"success"},{default:e(()=>[l("已读")]),_:1})):k("",!0)]),empty:e(()=>[s(A,{title:"",tip:"暂无投诉",type:"list"})]),action:e(({row:t})=>[s(h,null,{default:e(()=>[s(v,{theme:"primary",onClick:N=>P(t.id)},{default:e(()=>[l("详情")]),_:2},1032,["onClick"]),s(v,{theme:"danger",onClick:N=>I(t.id)},{default:e(()=>[l("删除")]),_:2},1032,["onClick"])]),_:2},1024)]),_:1},8,["data","columns","hover","pagination","header-affixed-top"])]),_:1})}}});export{fe as default};
