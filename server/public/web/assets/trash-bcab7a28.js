import{e as E,a8 as H,r as c,l as Q,d as Y,P as u,Q as z,a7 as m,f as o,a4 as a,I as h,H as n,ab as v,a9 as p,a3 as y}from"./vue-bf422dc1.js";import{l as q}from"./category-7ca503b8.js";import{t as F,r as J}from"./good-8f08fe48.js";import{R as O}from"./index-efe651b4.js";import{p as W}from"./global-0d825ba6.js";import{u as X}from"./index-c2dd6a24.js";import{f as K}from"./date-20546ee0.js";import{T as Z,Y as ee}from"./icons-a8498fb6.js";import{m as te,M as P,d as ae,I as le,B as oe,S as ne,T as se,L as ie,j as re}from"./ui-ba7aaa7e.js";import"./no-list-e2f85d5e.js";import"./libs-51817cd7.js";import"./plugins-ca970193.js";import"./others-9f318174.js";import"./echarts-bf9d612c.js";const ce={class:"basic-container"},ue={class:"category-header c-flex"},de={class:"l"},me={class:"r c-flex"},pe={key:0,class:"selected-count"},fe={name:"Goods"},Be=E({...fe,setup(_e){const B=H(),R=[{colKey:"id",type:"multiple"},{colKey:"name",title:"商品名称",ellipsis:!0,cell:"name"},{colKey:"cate_name",title:"商品分类"},{colKey:"price",title:"价格"},{colKey:"create_at",title:"创建时间"},{colKey:"delete_at",title:"删除时间"},{colKey:"operation",title:"操作",cell:"operation",fixed:"right"}],$=X(),C=c([]),s=c({defaultPageSize:20,total:0,defaultCurrent:1}),k=c(!1),f=async()=>{k.value=!0;const l={...i,page:s.value.defaultCurrent,limit:s.value.defaultPageSize};try{const{data:e}=await F(l);C.value=e.list,s.value={...s.value,total:e.total}}catch(e){console.log(e)}finally{k.value=!1}},i=Q({cate_id:"",name:"",type:""}),S=c([]),w=async()=>{const{data:l}=await q();S.value=l.list},D=c([{label:"普通商品",value:1},{label:"代理商品",value:2}]);f(),w();const r=c([]),I="id",L=l=>{r.value=l},N=(l,e)=>{s.value.defaultCurrent=l.current,s.value.defaultPageSize=l.pageSize,f()},U=(l,e)=>{},V=(l=0)=>{l&&(r.value=[l]);const e=te({header:"提醒",body:"确定要恢复所选数据吗？",confirmBtn:"确认",onConfirm:async({e:_})=>{e.hide();const d=await J({ids:r.value});d.code===1?(f(),P.success("恢复成功")):P.error(`恢复失败：${d.msg}`)},onClose:({e:_,trigger:d})=>{e.hide()}})},A=l=>{const{id:e}=l;B.push(`/merchant/goods/edit?id=${e}`)},G=Y(()=>({offsetTop:$.isUseTabsRouter?48:0,container:`.${W}-layout`}));return(l,e)=>{const _=ae,d=le,x=oe,b=ne,g=se,T=ie,M=re;return u(),z("div",ce,[m("div",ue,[m("div",de,[o(b,null,{default:a(()=>[o(_,{modelValue:i.cate_id,"onUpdate:modelValue":e[0]||(e[0]=t=>i.cate_id=t),placeholder:"全部分类",type:"search",clearable:"",options:S.value},null,8,["modelValue","options"]),o(_,{modelValue:i.type,"onUpdate:modelValue":e[1]||(e[1]=t=>i.type=t),placeholder:"全部类型",type:"search",clearable:"",options:D.value},null,8,["modelValue","options"]),o(d,{modelValue:i.name,"onUpdate:modelValue":e[2]||(e[2]=t=>i.name=t),placeholder:"请输入商品名",clearable:""},{"suffix-icon":a(()=>[o(h(Z))]),_:1},8,["modelValue"]),o(x,{theme:"default",variant:"outline",onClick:f},{default:a(()=>[n("查询")]),_:1})]),_:1})]),m("div",me,[o(x,{variant:"base",disabled:!r.value.length,onClick:e[3]||(e[3]=t=>V())},{icon:a(()=>[o(h(ee))]),default:a(()=>[n(" 批量恢复 ")]),_:1},8,["disabled"]),r.value.length?(u(),z("p",pe,"已选"+v(r.value.length)+"项",1)):p("",!0)])]),o(M,{data:C.value,columns:R,"row-key":I,"vertical-align":"top",hover:C.value.length>0,"table-layout":"auto",pagination:s.value,loading:k.value,"header-affixed-top":G.value,"max-height":"100%",onPageChange:N,onChange:U,onSelectChange:L},{name:a(({row:t})=>[n(v(t.name)+" ",1),o(b,{size:"small",align:"center",class:"tag-demo light"},{default:a(()=>[t.wholesale_discount==1?(u(),y(g,{key:0,title:"支持批发优惠",theme:"success",variant:"light",size:"small"},{default:a(()=>[n("惠")]),_:1})):p("",!0),t.coupon_type==1?(u(),y(g,{key:1,title:"支持优惠券",theme:"primary",variant:"light",size:"small"},{default:a(()=>[n("券")]),_:1})):p("",!0),t.take_card_type!=0?(u(),y(g,{key:2,title:"提卡必填或选填取卡密码",theme:"warning",variant:"light",size:"small"},{default:a(()=>[n("取")]),_:1})):p("",!0),t.visit_type==1?(u(),y(g,{key:3,title:"商品购买页面需要访问密码",theme:"danger",variant:"light",size:"small"},{default:a(()=>[n("密")]),_:1})):p("",!0)]),_:2},1024)]),create_at:a(({row:t})=>[m("span",null,v(h(K)(t.create_at)),1)]),delete_at:a(({row:t})=>[m("span",null,v(h(K)(t.delete_at)),1)]),operation:a(({row:t})=>[o(b,null,{default:a(()=>[o(T,{theme:"primary",hover:"color",onClick:j=>V(t.id)},{default:a(()=>[n("恢复")]),_:2},1032,["onClick"]),o(T,{theme:"primary",hover:"color",onClick:j=>A(t)},{default:a(()=>[n("修改")]),_:2},1032,["onClick"])]),_:2},1024)]),empty:a(()=>[o(O,{title:"",tip:"商品回收站为空",type:"list"})]),_:1},8,["data","hover","pagination","loading","header-affixed-top"])])}}});export{Be as default};
