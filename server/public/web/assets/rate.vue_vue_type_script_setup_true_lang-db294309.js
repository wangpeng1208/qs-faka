import{s as P,h as V,r as N}from"./user-2cd65a42.js";import{p as z}from"./global-0d825ba6.js";import{u as A}from"./index-8db2df2c.js";import{h as O,d as U,M as B,R as I,p as L,A as M,j as $,f as j}from"./ui-ba7aaa7e.js";import{e as q,l as G,r as n,d as H,P as p,a3 as Q,a4 as _,f as o,Q as h,H as g,a9 as w}from"./vue-bf422dc1.js";const F={key:0},J={key:1},ae=q({__name:"rate",setup(W,{expose:b}){const R=async()=>{await P({user_id:t.user_id,type:t.rate_type})},T=[{label:"使用角色分组",value:0},{label:"单独定义",value:1}],f=[{label:"用户费率",value:1},{label:"通道费率",value:0}],D=[{colKey:"id",title:"ID"},{colKey:"title",title:"通道名称"},{colKey:"show_name",title:"显示名称"},{colKey:"is_custom",title:"通道类型",cell:(e,{row:a})=>a.is_custom?"用户通道":"官方通道"},{colKey:"rate",title:"费率",edit:{component:O,props:{autofocus:!0,placeholder:"请输入费率",tips:"单位：千分率",suffix:"‰",theme:"normal",min:0},validateTrigger:"change",abortEditOnEvent:["onEnter"],onEdited:e=>{t.rate=e.newRowData.rate,t.channel_id=e.newRowData.id,t.status=e.newRowData.status,m()},rules:[{required:!0,message:"不能为空"}],defaultEditable:!1}},{colKey:"status",title:"模式",cell:(e,{row:a})=>{var l;return(l=f.find(d=>d.value===a.status))==null?void 0:l.label},edit:{component:U,props:{options:f},onEdited:e=>{t.rate=e.newRowData.rate,t.channel_id=e.newRowData.id,t.status=e.newRowData.status,m()}}}],t=G({rate_type:1,channel_id:0,rate:0,status:0,user_id:0}),m=async()=>{(await V({...t})).code===1&&(B.success("操作成功"),u())},r=n(!1),v=n(),S=e=>{t.user_id=e.id,v.value=`${e.username} 用户费率设置`,u(),r.value=!0},s=n({defaultPageSize:20,total:0,defaultCurrent:1}),i=n([]),u=async()=>{const{data:e}=await N({id:t.user_id});i.value=e.list,t.rate_type=e.user.rate_type,s.value.total=e.total},x=e=>{s.value.defaultCurrent=e.current,s.value.defaultPageSize=e.pageSize,u()},C=A(),k=H(()=>({offsetTop:C.isUseTabsRouter?48:0,container:`.${z}-layout`}));return b({init:S}),(e,a)=>{const l=I,d=L,y=M,E=$,K=j;return p(),Q(K,{visible:r.value,"onUpdate:visible":a[1]||(a[1]=c=>r.value=c),"close-on-overlay-click":!1,"destroy-on-close":!0,footer:!1,header:v.value,width:"900px"},{default:_(()=>[o(l,{modelValue:t.rate_type,"onUpdate:modelValue":a[0]||(a[0]=c=>t.rate_type=c),name:"rate_type",options:T,onChange:R},null,8,["modelValue"]),o(d),t.rate_type===0?(p(),h("div",F,[o(y,null,{default:_(()=>[g("自行到“分配角色”里设置")]),_:1})])):w("",!0),t.rate_type===1?(p(),h("div",J,[o(y,null,{default:_(()=>[g(" 模式：用户费率 为设置该用户在该通道的费率；通道费率 则遵循对应通道的费率 ")]),_:1}),o(E,{ref:"tableRef","row-key":"id",data:i.value,columns:D,hover:i.value.length>0,"header-affixed-top":k.value,pagination:s.value,"lazy-load":"","table-layout":"auto","max-height":"100%",onPageChange:x},null,8,["data","hover","header-affixed-top","pagination"])])):w("",!0)]),_:1},8,["visible","header"])}}});export{ae as _};
