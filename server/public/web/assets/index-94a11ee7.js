import{d as T,a as S}from"./category-7f0098f4.js";import{t as $}from"./table-85dc8ff4.js";import{c as z,_ as D}from"./edit.vue_vue_type_script_setup_true_lang-61f4af05.js";import{M as L,B as M,T as N,L as V,S as A,a as F,b as H}from"./ui-ba7aaa7e.js";import{e as I,r as j,M as q,P as t,a3 as o,a4 as e,a7 as h,A as d,H as n,f as m,I as a}from"./vue-bf422dc1.js";import"./index-8db2df2c.js";import"./libs-51817cd7.js";import"./plugins-ca970193.js";import"./others-9f318174.js";import"./echarts-bf9d612c.js";import"./icons-a8498fb6.js";import"./global-0d825ba6.js";import"./date-20546ee0.js";const E={class:"category-header c-flex"},G={class:"l"},ne=I({__name:"index",setup(J){const{pagination:v,fetchData:r,dataLoading:C,headerAffixedTop:k,rehandlePageChange:y,lists:_}=$({fetchFun:S});r();const p=j(),f=(i=null)=>{p.value.init(i)},b=async i=>{(await T({id:i})).code===1&&(L.success("删除成功"),r())};return(i,c)=>{const x=M,u=N,g=V,B=A,w=F,P=H,l=q("perms");return t(),o(P,{title:"文章分类管理",class:"basic-container",bordered:!1},{default:e(()=>[h("div",E,[h("div",G,[d((t(),o(x,{theme:"primary",onClick:c[0]||(c[0]=s=>f())},{default:e(()=>[n("添加")]),_:1})),[[l,["adminapi/article/articleCategory/add"]]])])]),m(w,{ref:"tableRef","row-key":"id",data:a(_),columns:a(z),hover:a(_).length>0,"header-affixed-top":a(k),"max-height":"auto","table-layout":"auto",pagination:a(v),"lazy-load":"",loading:a(C),onPageChange:a(y)},{status:e(({row:s})=>[s.status===1?(t(),o(u,{key:0,variant:"light",theme:"success"},{default:e(()=>[n("启用")]),_:1})):(t(),o(u,{key:1,variant:"light",theme:"danger"},{default:e(()=>[n("禁用")]),_:1}))]),operate:e(({row:s})=>[m(B,null,{default:e(()=>[d((t(),o(g,{theme:"primary",size:"small",onClick:R=>f(s)},{default:e(()=>[n("编辑")]),_:2},1032,["onClick"])),[[l,["adminapi/article/articleCategory/edit"]]]),d((t(),o(g,{theme:"danger",size:"small",onClick:R=>b(s.id)},{default:e(()=>[n("删除")]),_:2},1032,["onClick"])),[[l,["adminapi/article/articleCategory/del"]]])]),_:2},1024)]),_:1},8,["data","columns","hover","header-affixed-top","pagination","loading","onPageChange"]),m(D,{ref_key:"editRef",ref:p,onSuccess:a(r)},null,8,["onSuccess"])]),_:1})}}});export{ne as default};
