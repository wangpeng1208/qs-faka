import{T as w,E as x}from"./wangeditor-ca6eb2b6.js";import{a as V,m as C,b as N}from"./config-3b189d83.js";import{e as T,O,d as r,s as $,P as k,Q as B,f as n,I as u,ae as E}from"./vue-bf422dc1.js";import{_ as I}from"./index-8db2df2c.js";import"./ui-ba7aaa7e.js";import"./icons-a8498fb6.js";import"./libs-51817cd7.js";import"./plugins-ca970193.js";import"./others-9f318174.js";import"./echarts-bf9d612c.js";const S={class:"border-br"},F=T({__name:"index",props:{modelValue:{default:""},mode:{default:"default"},height:{default:"300px"},width:{default:"100%"},toolbarConfig:{default:()=>({})},userType:{default:""},path:{default:"upload/res/"}},emits:["update:modelValue"],setup(i,{emit:m}){const t=i,p=m,d=O(),c=localStorage.getItem(t.userType),{accessToken:f}=JSON.parse(c),h=t.userType==="admin"?V:C,_=` ${N}${h}`,g={Authorization:`Bearer ${f}`},y=async e=>{const o=new FormData;return o.append("file",e),o.append("path",t.path),(await(await fetch(_,{method:"POST",body:o,headers:g})).json()).data.url},b={MENU_CONF:{uploadImage:{async customUpload(e,o){const a=await y(e);o(a)}}}},s=(e,o="px")=>Object.is(Number(e),NaN)?e:`${e}${o}`,U=r(()=>({height:s(t.height),width:s(t.width)})),l=r({get(){return t.modelValue},set(e){p("update:modelValue",e)}});$(()=>{const e=d.value;e!=null&&e.destroy()});const v=e=>{d.value=e};return(e,o)=>(k(),B("div",S,[n(u(w),{style:{"border-bottom":"1px solid #ccc"},editor:d.value,"default-config":e.toolbarConfig,mode:e.mode},null,8,["editor","default-config","mode"]),n(u(x),{modelValue:l.value,"onUpdate:modelValue":o[0]||(o[0]=a=>l.value=a),class:"overflow-y-auto flex-1",style:E(U.value),"default-config":b,mode:e.mode,onOnCreated:v},null,8,["modelValue","style","mode"])]))}});const G=I(F,[["__scopeId","data-v-ad6ace7d"]]);export{G as default};
