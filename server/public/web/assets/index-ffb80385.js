import{b as h}from"./base-847c52cc.js";import{r as y,_ as b}from"./index-c2dd6a24.js";import{r as w,S as x,W as v,a as k,b as V}from"./ui-ba7aaa7e.js";import{e as g,r as B,P as s,a3 as K,a4 as e,f as a,I as S,a7 as n,ab as i,Q as _}from"./vue-bf422dc1.js";import"./libs-51817cd7.js";import"./plugins-ca970193.js";import"./others-9f318174.js";import"./echarts-bf9d612c.js";import"./icons-a8498fb6.js";function C(){return y.post({url:"/merchantapi/user/payment/list"})}const D={key:0},I={key:1},U={name:"Payment"},N=g({...U,setup(P){const r=[{width:200,colKey:"title",title:"通道名称",ellipsis:!0,cell:"title"},{width:120,colKey:"type_text",title:"场景"},{width:120,colKey:"rate",title:"平台收取"},{width:120,colKey:"status",title:"当前状态"},{width:120,colKey:"is_custom",title:"通道"}],o=B();return(async()=>{const{data:l}=await C();o.value=l})(),(l,z)=>{const p=w,c=x,d=v,m=k,u=V;return s(),K(u,{title:"付款方式",bordered:!1,class:"basic-container"},{default:e(()=>[a(m,{columns:r,"row-key":"id",data:o.value,class:"basic-table"},{title:e(({row:t})=>[a(c,{size:"small"},{default:e(()=>[a(p,{src:S(h)+t.ico,fit:"cover",style:{width:"21px",height:"21px"}},null,8,["src"]),n("span",null,i(t.show_name),1)]),_:2},1024)]),rate:e(({row:t})=>[a(c,null,{default:e(()=>[n("span",null,i(t.rate*100)+"%",1)]),_:2},1024)]),status:e(({row:t})=>[a(d,{modelValue:t.status,"onUpdate:modelValue":f=>t.status=f,"custom-value":[1,0],disabled:""},null,8,["modelValue","onUpdate:modelValue"])]),is_custom:e(({row:t})=>[t.is_custom==0?(s(),_("span",D,"平台")):(s(),_("span",I,"自定义"))]),_:1},8,["data"])]),_:1})}}});const J=b(N,[["__scopeId","data-v-5f77be18"]]);export{J as default};
