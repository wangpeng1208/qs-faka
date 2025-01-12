import{s as O,a as $,g as j,l as B}from"./sms-6ec4e59c.js";import{t as D}from"./table-fedd62e5.js";import{T as R,M as u,L as z,j as E,R as M,F as N,I as A,e as G,f as H,b as Q}from"./ui-ba7aaa7e.js";import{e as q,l as J,r as c,P as m,a3 as b,a4 as s,f as o,I as n,H as W,Q as X,F as Y,aa as Z}from"./vue-bf422dc1.js";import"./index-c2dd6a24.js";import"./libs-51817cd7.js";import"./plugins-ca970193.js";import"./others-9f318174.js";import"./echarts-bf9d612c.js";import"./icons-a8498fb6.js";import"./global-0d825ba6.js";const ee={name:"SystemSmsList"},pe=q({...ee,setup(ae){const v=[{title:"短信平台",colKey:"label"},{title:"短信标识",colKey:"value"},{title:"状态",colKey:"status",cell:(a,{row:e})=>a(R,{size:"small",variant:"outline",theme:e.status===1?"success":"danger"},()=>e.status===1?"开启":"关闭")},{title:"操作",colKey:"operate",width:100,fixed:"right"}],{pagination:h,fetchData:V,dataLoading:y,headerAffixedTop:C,rehandlePageChange:k,lists:x}=D({fetchFun:B});V();const l=J({}),p=c(),F=async a=>{const e=await $({type:a});if(e.code===1){p.value={...e.data};const r=await j({type:a});Object.assign(l,{...r.data})}else u.error(`${e.msg}`)},f=c(),i=c(!1),w=a=>{Object.keys(l).forEach(e=>{delete l[e]}),i.value=!0,f.value=a,F(a)},T=async()=>{const a=await O({type:f.value,data:{...l}});a.code===1?(u.success(`${a.msg}`),i.value=!1):u.error(`${a.msg}`)};return(a,e)=>{const r=z,L=E,P=M,d=N,_=A,S=G,U=H,I=Q;return m(),b(I,{title:"短信配置",class:"basic-container",bordered:!1},{default:s(()=>[o(L,{size:"small",data:n(x),columns:v,"row-key":"id","vertical-align":"middle",loading:n(y),pagination:n(h),"header-affixed-top":n(C),"table-layout":"fixed","max-height":"100%",onPageChange:n(k)},{operate:s(({row:t})=>[o(r,{theme:"primary",onClick:g=>w(t.value)},{default:s(()=>[W("设置")]),_:2},1032,["onClick"])]),_:1},8,["data","loading","pagination","header-affixed-top","onPageChange"]),o(U,{visible:i.value,"onUpdate:visible":e[2]||(e[2]=t=>i.value=t),header:"编辑短信配置","on-confirm":T},{default:s(()=>[o(S,null,{default:s(()=>[o(d,{label:"状态"},{default:s(()=>[o(P,{modelValue:l.status,"onUpdate:modelValue":e[0]||(e[0]=t=>l.status=t),options:[{label:"开启",value:1},{label:"关闭",value:0}]},null,8,["modelValue"])]),_:1}),(m(!0),X(Y,null,Z(p.value,(t,g)=>(m(),b(d,{key:g,label:t.label},{default:s(()=>[o(_,{modelValue:l[t.value],"onUpdate:modelValue":K=>l[t.value]=K,clearable:"",placeholder:"请输入模板名称"},null,8,["modelValue","onUpdate:modelValue"])]),_:2},1032,["label"]))),128)),o(d,{label:"短信价格"},{default:s(()=>[o(_,{modelValue:l.price,"onUpdate:modelValue":e[1]||(e[1]=t=>l.price=t),clearable:"",placeholder:"短信价格"},null,8,["modelValue"])]),_:1})]),_:1})]),_:1},8,["visible"])]),_:1})}}});export{pe as default};