import{P as a,Q as p,a7 as n,e as Z,a8 as M,r as g,a3 as c,a4 as o,f as r,F as P,aa as N,ab as u,I as v,a5 as T,H as h,ac as $,ad as b}from"./vue-bf422dc1.js";import{g as B,r as D}from"./news-1bed96c9.js";import{f as U}from"./date-20546ee0.js";import{T as E,l as F,Z as R,t as q,a0 as H,u as Q,b as j}from"./ui-ba7aaa7e.js";import{_ as A}from"./index-c2dd6a24.js";import"./libs-51817cd7.js";import"./icons-a8498fb6.js";import"./plugins-ca970193.js";import"./others-9f318174.js";import"./echarts-bf9d612c.js";const G={xmlns:"http://www.w3.org/2000/svg",width:"64",height:"64",fill:"none"},J=n("path",{fill:"currentcolor","fill-opacity":".26","fill-rule":"evenodd",d:"m32 10.69 26.248 15.155v22.31L32 63.308 5.75 48.155v-22.31L32 10.69ZM9.75 30.464v15.381L32 58.69l22.248-12.845V30.464L32 43.309 9.75 30.464ZM52.248 27 40.66 33.69l-8.66-5-8.66 5L11.75 27 32 15.31 52.248 27ZM27.34 36 32 38.69 36.66 36 32 33.31 27.34 36ZM30 8V0h4v8h-4ZM44.268 10.751l4-6.928 3.464 2-4 6.928-3.464-2ZM16.268 12.751l-4-6.928 3.464-2 4 6.928-3.464 2Z","clip-rule":"evenodd"},null,-1),K=[J];function O(l,m){return a(),p("svg",G,[...K])}const W={render:O},X=l=>($("data-v-aa068511"),l=l(),b(),l),Y={class:"secondary-notification"},tt=["onClick"],et={class:"msg-date"},at={class:"msg-action"},st=["onClick"],ot={key:1,class:"secondary-msg-list__empty-list"},nt=X(()=>n("p",null,"暂无内容",-1)),lt={name:"DetailSecondary"},it=Z({...lt,setup(l){const m=M(),d=g([]),e=g({defaultPageSize:20,total:0,defaultCurrent:1}),_=async()=>{const{data:s}=await B({page:e.value.defaultCurrent,limit:e.value.defaultPageSize});d.value=s.data,e.value.total=s.total};_();const y=s=>{m.push({name:"merchantUserNews_detail/:id",params:{id:s.id}})},C=async s=>{(await D({id:s.id})).code===1&&_()};return(s,i)=>{const w=E,f=F,S=R,k=q,z=H,x=Q,L=j;return a(),c(L,{title:"公告列表",class:"basic-container",bordered:!1},{default:o(()=>[n("div",Y,[d.value.length>0?(a(),c(x,{key:0,class:"secondary-msg-list",split:!0},{footer:o(()=>[r(z,{modelValue:e.value.defaultCurrent,"onUpdate:modelValue":i[0]||(i[0]=t=>e.value.defaultCurrent=t),pageSize:e.value.defaultPageSize,"onUpdate:pageSize":i[1]||(i[1]=t=>e.value.defaultPageSize=t),total:e.value.total,"show-page-size":!1,onCurrentChange:_},null,8,["modelValue","pageSize","total"])]),default:o(()=>[(a(!0),p(P,null,N(d.value,(t,I)=>(a(),c(k,{key:I},{action:o(()=>[n("span",et,u(v(U)(t.create_at)),1),n("div",at,[r(S,{class:"set-read-icon","overlay-style":{margin:"6px"},content:t.is_read?"设为已读":"设为未读"},{default:o(()=>[n("span",{class:"msg-action-icon",onClick:V=>C(t)},[t.is_read?(a(),c(f,{key:0,name:"queue",size:"16px"})):(a(),c(f,{key:1,name:"chat"}))],8,st)]),_:2},1032,["content"])])]),default:o(()=>[n("p",{class:T(["content",{unread:!t.is_read,read:t.is_read}]),onClick:V=>y(t)},[r(w,{size:"medium",variant:"light"},{default:o(()=>[h(u(t.cate_name),1)]),_:2},1024),h(" "+u(t.title),1)],10,tt)]),_:2},1024))),128))]),_:1})):(a(),p("div",ot,[r(v(W)),nt]))])]),_:1})}}});const ht=A(it,[["__scopeId","data-v-aa068511"]]);export{ht as default};