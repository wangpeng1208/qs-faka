import{R as p}from"./index-fb16f061.js";import{B as u}from"./ui-ba7aaa7e.js";import{e as i,t as c,P as l,a3 as f,a4 as s,f as m,H as _,I as d}from"./vue-bf422dc1.js";const B={name:"Result404"},T=i({...B,props:{tip:{}},setup(r){const a=r,{tip:e}=c(a);return(t=>{document.title=t})(`${e.value.error}`),(t,o)=>{const n=u;return l(),f(p,{tip:d(e).error,type:"404"},{default:s(()=>[m(n,{onClick:o[0]||(o[0]=()=>t.$router.push("/"))},{default:s(()=>[_("返回首页")]),_:1})]),_:1},8,["tip"])}}});export{T as _};