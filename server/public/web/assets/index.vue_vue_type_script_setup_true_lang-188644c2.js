import{b as i,m as c,a as $}from"./config-6561e667.js";import{M as S,U as w}from"./ui-ba7aaa7e.js";import{e as V,t as B,r as o,G as P,P as R,a3 as I,m as M,I as O}from"./vue-bf422dc1.js";const W={name:"WpUpload"},C=V({...W,props:{theme:String,initial:Object,name:String,app:String,accept:String},emits:["update"],setup(p,{emit:d}){const e=p,{accept:f,app:s,theme:v}=B(e),l=o(f.value),t=o();P(()=>{let a;if(e.initial[e.name]&&e.initial[e.name].startsWith("http")?a=e.initial[e.name]:a=i+e.initial[e.name],e.initial&&e.name&&e.initial[e.name])switch(e.theme){case"image":l.value="image/*",t.value=[{url:a}];break;case"file":l.value="file/*",t.value=[{name:e.initial[e.name],url:a}];break;case"custom":t.value=[{name:e.initial[e.name],url:a}];break;case"file-input":t.value=[{name:e.initial[e.name],url:a}];break;case"file-flow":t.value=[{name:e.initial[e.name],url:a}];break;case"image-flow":t.value=[{url:a}];break;default:l.value="image/*",t.value=[{url:a}]}else t.value=[]});const r=d,g=a=>a.code===0?(S.error(a.msg),null):(e.initial&&e.name&&r("update",{name:e.name,url:a.data.url}),a.data),h=()=>{r("update",{name:e.name,url:""})},n=o();(()=>{switch(s.value){case"admin":n.value=`${i}${$}`;break;case"merchant":n.value=`${i}${c}`;break;default:n.value=`${i}${c}`}})();const U=localStorage.getItem(s.value),{accessToken:b}=JSON.parse(U),m=o({});return s.value!==void 0&&(m.value={Authorization:`Bearer ${b}`}),(a,u)=>{const k=w;return R(),I(k,M(a.$attrs,{modelValue:t.value,"onUpdate:modelValue":u[0]||(u[0]=_=>t.value=_),action:n.value,headers:m.value,theme:O(v),accept:l.value,"format-response":g,clearable:"",onRemove:h}),null,16,["modelValue","action","headers","theme","accept"])}}});export{C as _};
