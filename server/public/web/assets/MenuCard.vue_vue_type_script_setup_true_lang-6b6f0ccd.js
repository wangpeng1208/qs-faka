import{e as A,r as s,a8 as I,P as r,a3 as f,a4 as e,f as a,H as l,ab as m,Q as L,F as U,aa as $,ai as F,I as p}from"./vue-bf422dc1.js";import{e as N,h as P}from"./index-8db2df2c.js";import{_ as T}from"./AddMenu.vue_vue_type_script_setup_true_lang-e9ce6c37.js";import{_ as V,A as D}from"./icons-a8498fb6.js";import{L as E,l as H,B as Q,S as j,b as q}from"./ui-ba7aaa7e.js";const X=A({__name:"MenuCard",setup(z){const u=s([]),c=async()=>{const n=await N();n.code&&(u.value=n.data)};c();const v=()=>{c(),t.value=!1},k=I(),h=n=>{t.value||k.push({name:n})},i=s(),C=()=>{i.value.init()},t=s(!1),_=s("操作"),g=()=>{_.value=t.value?"操作":"完成",t.value=!t.value},y=async n=>{(await P({menu_id:n})).code&&c()};return(n,M)=>{const S=E,x=H,d=Q,w=j,B=q;return r(),f(B,{title:"用户快捷菜单","hover-shadow":""},{actions:e(()=>[a(S,{hover:"color",onClick:g},{default:e(()=>[l(m(_.value),1)]),_:1})]),default:e(()=>[a(w,{align:"center","break-line":""},{default:e(()=>[(r(!0),L(U,null,$(u.value,(o,R)=>(r(),f(d,{key:R,onClick:b=>h(o.name)},F({default:e(()=>[l(" "+m(o.title)+" ",1)]),_:2},[o.icon?{name:"icon",fn:e(()=>[a(x,{name:o.icon},null,8,["name"])]),key:"0"}:void 0,t.value?{name:"suffix",fn:e(()=>[a(p(V),{onClick:b=>y(o.id)},null,8,["onClick"])]),key:"1"}:void 0]),1032,["onClick"]))),128)),a(d,{variant:"dashed",onClick:C},{icon:e(()=>[a(p(D))]),default:e(()=>[l(" 添加 ")]),_:1})]),_:1}),a(T,{ref_key:"addMenuRef",ref:i,onRefresh:v},null,512)]),_:1})}}});export{X as _};