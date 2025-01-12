import{i as E,r as H,c as J,g as W,a as j,b as q,s as A}from"./link-448f477d.js";import{c as L,_ as G}from"./index-c2dd6a24.js";import{V as S,W as K}from"./icons-a8498fb6.js";import{m as R,M as m,N as X,Q as Y,S as Z,F as ee,L as ae,T as te,J as le,e as se,b as ne}from"./ui-ba7aaa7e.js";import{e as oe,r,l as ie,P as g,a3 as $,a4 as e,f as a,Q as D,F as P,aa as z,H as i,ab as k,I as u}from"./vue-bf422dc1.js";import"./libs-51817cd7.js";import"./plugins-ca970193.js";import"./others-9f318174.js";import"./echarts-bf9d612c.js";const ce={name:"UserLink"},re=oe({...ce,setup(_e){const _=r(!1),l=ie({link:"",short_link:"",src:"",user_status:0,link_status:null}),F=[{label:"开启",value:1},{label:"暂停",value:0}],h=async()=>{_.value=!0;const{data:t}=await E();l.short_link=t.shortLink,l.link=t.link,l.src=t.link_src,l.user_status=t.user_status,l.link_status=[t.link_status],_.value=!1};h();const b=async t=>{let s="";t===0?s="确定要重置短链接吗？重置链接后，之前的短链接将不能访问！":t===1&&(s="确定要重置总链接吗？重置链接后，之前的总链接将及短链接不能访问！");const o=R({header:"温馨提示",body:s,theme:"warning",confirmBtn:"确认",closeOnOverlayClick:!1,onConfirm:()=>{o.hide(),_.value=!0,H({status:t}).then(c=>{c.code===1?(m.success(c.msg),h()):m.error(c.msg),_.value=!1})},onClose:()=>{o.hide()}})},B=async t=>{if(l.link_status===t)return;const s=await J({status:t});s.code===1&&(m.success(s.msg),h())},y=r(!0),T=r([]),M=r([]);(async()=>{const t=await W(),s=await j();T.value=t.data,M.value=s.data,y.value=!1})();const C=r(null),I=r(null),x=async()=>{const t=await q();C.value=t.data.pc_template,I.value=t.data.mobile_template};x();const N=async(t,s)=>{const o=await A({field:t,value:s});o.code===1?(m.success(o.msg),x()):m.error(o.msg)};return(t,s)=>{const o=X,c=Y,d=Z,p=ee,w=ae,f=te,V=le,O=se,Q=ne;return g(),$(Q,{title:"店铺链接",class:"basic-container",bordered:!1},{default:e(()=>[a(o,{attach:".basic-container",size:"small",loading:_.value},null,8,["loading"]),a(O,{"label-align":"left","label-width":160},{default:e(()=>[a(p,{label:"链接状态",tips:"店铺总链接状态，选择暂停将仅当前店铺“总链接”不可用"},{default:e(()=>[a(d,null,{default:e(()=>[(g(),D(P,null,z(F,(n,v)=>a(c,{key:v,checked:n.value==l.link_status,onChange:U=>B(n.value)},{default:e(()=>[i(k(n.label),1)]),_:2},1032,["checked","onChange"])),64))]),_:1})]),_:1}),a(p,{label:"绿标短链",tips:"绿标短链接打开就是店铺长链接，强烈建议使用绿标短链接作为访问链接;如果在朋友圈等地方打广告请发【绿标短链】这个链接，这样可以让您的朋友直接进入您的店铺"},{default:e(()=>[a(d,null,{default:e(()=>[a(w,{theme:"primary",href:l==null?void 0:l.short_link,target:"_blank"},{default:e(()=>[i(k(l==null?void 0:l.short_link),1)]),_:1},8,["href"]),a(f,{theme:"primary",variant:"light",size:"small",class:"tag",onClick:s[0]||(s[0]=n=>u(L)(l==null?void 0:l.short_link))},{icon:e(()=>[a(u(S))]),default:e(()=>[i(" 复制 ")]),_:1}),a(f,{theme:"primary",size:"small",class:"tag",onClick:s[1]||(s[1]=n=>b(0))},{icon:e(()=>[]),default:e(()=>[i(" 重置短链接 ")]),_:1})]),_:1})]),_:1}),a(p,{label:"店铺总链",tips:"重置总链接后，原短链长连接都会失效；严禁使用此链接发广告"},{default:e(()=>[a(d,null,{default:e(()=>[a(w,{theme:"primary",href:l.link,target:"_blank"},{default:e(()=>[i(k(l.link),1)]),_:1},8,["href"]),a(f,{theme:"primary",variant:"light",size:"small",class:"tag",onClick:s[2]||(s[2]=n=>u(L)(l.link))},{icon:e(()=>[a(u(S))]),default:e(()=>[i("复制 ")]),_:1}),a(f,{theme:"primary",size:"small",class:"tag",onClick:s[3]||(s[3]=n=>b(1))},{icon:e(()=>[a(u(K))]),default:e(()=>[i("重置总链接 ")]),_:1})]),_:1})]),_:1}),a(p,{label:"电脑主题",tips:"店铺总链接PC页面风格"},{default:e(()=>[a(V,{loading:y.value,animation:"flashed","row-col":[{type:"rect",width:"600px",height:"30px"}]},{default:e(()=>[a(d,null,{default:e(()=>[(g(!0),D(P,null,z(T.value,(n,v)=>(g(),$(c,{key:v,checked:n.value==C.value,onChange:U=>N("pc_template",n.value)},{default:e(()=>[i(k(n.label),1)]),_:2},1032,["checked","onChange"]))),128))]),_:1})]),_:1},8,["loading"])]),_:1})]),_:1})]),_:1})}}});const ye=G(re,[["__scopeId","data-v-b5d3e26d"]]);export{ye as default};
