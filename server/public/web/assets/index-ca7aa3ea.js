import{b as i}from"./base-847c52cc.js";import{o as p}from"./icons-a8498fb6.js";import{r as _,al as l}from"./ui-ba7aaa7e.js";import{e as u,d as g,P as f,Q as d,f as t,a4 as h,m as C,a9 as I,h as k}from"./vue-bf422dc1.js";const v={key:0},S={name:"WpImageComponent"},V=u({...S,props:{src:{type:String},errorSize:{type:String,default:"16"}},setup(o){const e=o,r=g(()=>e.src?e.src.startsWith("http")?e.src:i+e.src:""),s=()=>k(p,{size:e.errorSize});return(a,w)=>{const n=_,c=l;return r.value?(f(),d("div",v,[t(c,{images:[r.value]},{trigger:h(({open:m})=>[t(n,C(a.$attrs,{src:r.value,error:s,onClick:m}),null,16,["src","onClick"])]),_:1},8,["images"])])):I("",!0)}}});export{V as default};