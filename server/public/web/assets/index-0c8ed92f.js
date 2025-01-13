import{s as se}from"./plugins-ca970193.js";import{g as re,o as ee,q as ft,e as O,r as V,d as T,I as w,w as Ue,P as _,Q as R,f as l,a4 as i,a7 as x,a5 as M,ae as pe,R as ht,a8 as W,a2 as fe,F as H,aa as G,a9 as E,A as ae,B as oe,a3 as A,al as vt,ag as Q,D as gt,ab as k,H as B,aj as le,n as yt,h as bt,ai as Ze,ac as wt,ad as $t,G as xt}from"./vue-bf422dc1.js";import{p as P}from"./global-0d825ba6.js";import{D as St,E as Ve,F as Ge,u as q,_ as U,G as Ct,H as Rt,I as ze,J as At,K as Tt,L as Lt,M as Ft,N as Ke,O as Pt,P as Mt,Q as It,R as X,S as kt,T as Ot,U as We,V as Et,W as Bt,X as Xe,Y as Dt,Z as Ht,$ as qt,a0 as Ye,a1 as J,b as ie,a2 as Nt,a3 as j,a as Se,p as Ut,i as Zt,a4 as Qe,a5 as Vt,a6 as Gt,a7 as zt,a8 as Kt,a9 as me,aa as Wt}from"./index-b0aabda4.js";import{N as Xt,L as Yt,G as Qt,a3 as Je,a4 as Jt,a5 as je,l as Y,a6 as he,a7 as ve,a8 as ge,E as jt,a9 as en,aa as tn,m as nn,M as an,s as et,B as te,p as on,Z as tt,a2 as nt,u as sn,ab as rn,ac as at,t as ln,ad as un,ae as cn,af as dn,I as _n,ag as pn,r as mn,ah as fn,y as hn,R as vn,ai as gn,W as yn,F as bn,e as wn,q as $n,aj as xn,ak as Sn}from"./ui-ba7aaa7e.js";import{_ as Cn}from"./no-list-e2f85d5e.js";import{f as Rn}from"./date-20546ee0.js";import{n as An}from"./workbench-a7de3ac8.js";import{T as Tn}from"./index-2f4ebef9.js";import"./libs-51817cd7.js";import"./others-9f318174.js";import"./echarts-bf9d612c.js";import"./icons-a8498fb6.js";var Ln=St,Fn=Ve,Pn="[object Boolean]";function Mn(e){return e===!0||e===!1||Fn(e)&&Ln(e)==Pn}var In=Mn;const kn=re(In);function On(e){return e===void 0}var En=On;const Bn=re(En);function Dn(e,t,n=150){const a=Ge(e,n),r=()=>{t&&t.immediate&&e(),window.addEventListener("resize",a)},s=()=>{window.removeEventListener("resize",a)};return ee(()=>{r()}),ft(()=>{s()}),[r,s]}const Hn=["src"],qn=O({__name:"FrameContent",props:{frameSrc:String},setup(e){const t=V(!0),n=V(window.innerHeight),a=V(),r=T(()=>[`${P}-iframe-page`]),s=q(),o=T(()=>({height:`${w(n)}px`})),d=getComputedStyle(document.documentElement),v=d.getPropertyValue("--td-comp-size-xxxl"),c=d.getPropertyValue("--td-comp-paddingTB-xxl");function f($){let u=$.clientHeight;const m=window.getComputedStyle($);return u+=parseInt(m.marginTop,10),u+=parseInt(m.marginBottom,10),u+=parseInt(m.borderTopWidth,10),u+=parseInt(m.borderBottomWidth,10),u}function h(){const $=w(a);if(!$)return;let u=0;const{showFooter:m,isUseTabsRouter:C,showBreadcrumb:b}=s,p=parseFloat(v),y=document.querySelector(".t-tabs__nav"),L=C?f(y):0,F=document.querySelector(".t-breadcrumb"),D=b?f(F):0,Z=parseFloat(c)*2,S=document.querySelector(".t-layout__footer"),I=m?f(S):0,z=p+L+D+Z+I+2;n.value=window.innerHeight-z,u=document.documentElement.clientHeight-z,$.style.height=`${u}px`}function g(){t.value=!1,h()}return Dn(h,{immediate:!0}),Ue([()=>s.showFooter,()=>s.isUseTabsRouter,()=>s.showBreadcrumb],Ge(h,250)),($,u)=>{const m=Xt;return _(),R("div",{class:M(r.value),style:pe(o.value)},[l(m,{loading:t.value,size:"large",style:pe(o.value)},{default:i(()=>[x("iframe",{ref_key:"frameRef",ref:a,src:e.frameSrc,class:M(`${r.value}__main`),onLoad:g},null,42,Hn)]),_:1},8,["loading","style"])],6)}}});const Nn=U(qn,[["__scopeId","data-v-3c00f034"]]);function Un(e,t){for(var n=-1,a=e==null?0:e.length;++n<a;)if(t(e[n],n,e))return!0;return!1}var Zn=Un,Vn=Ct,Gn=Zn,zn=Rt,Kn=1,Wn=2;function Xn(e,t,n,a,r,s){var o=n&Kn,d=e.length,v=t.length;if(d!=v&&!(o&&v>d))return!1;var c=s.get(e),f=s.get(t);if(c&&f)return c==t&&f==e;var h=-1,g=!0,$=n&Wn?new Vn:void 0;for(s.set(e,t),s.set(t,e);++h<d;){var u=e[h],m=t[h];if(a)var C=o?a(m,u,h,t,e,s):a(u,m,h,e,t,s);if(C!==void 0){if(C)continue;g=!1;break}if($){if(!Gn(t,function(b,p){if(!zn($,p)&&(u===b||r(u,b,n,a,s)))return $.push(p)})){g=!1;break}}else if(!(u===m||r(u,m,n,a,s))){g=!1;break}}return s.delete(e),s.delete(t),g}var ot=Xn;function Yn(e){var t=-1,n=Array(e.size);return e.forEach(function(a,r){n[++t]=[r,a]}),n}var Qn=Yn,Ce=ze,Re=At,Jn=Tt,jn=ot,ea=Qn,ta=Lt,na=1,aa=2,oa="[object Boolean]",sa="[object Date]",ra="[object Error]",la="[object Map]",ia="[object Number]",ua="[object RegExp]",ca="[object Set]",da="[object String]",_a="[object Symbol]",pa="[object ArrayBuffer]",ma="[object DataView]",Ae=Ce?Ce.prototype:void 0,de=Ae?Ae.valueOf:void 0;function fa(e,t,n,a,r,s,o){switch(n){case ma:if(e.byteLength!=t.byteLength||e.byteOffset!=t.byteOffset)return!1;e=e.buffer,t=t.buffer;case pa:return!(e.byteLength!=t.byteLength||!s(new Re(e),new Re(t)));case oa:case sa:case ia:return Jn(+e,+t);case ra:return e.name==t.name&&e.message==t.message;case ua:case da:return e==t+"";case la:var d=ea;case ca:var v=a&na;if(d||(d=ta),e.size!=t.size&&!v)return!1;var c=o.get(e);if(c)return c==t;a|=aa,o.set(e,t);var f=jn(d(e),d(t),a,r,s,o);return o.delete(e),f;case _a:if(de)return de.call(e)==de.call(t)}return!1}var ha=fa,Te=Ft,va=1,ga=Object.prototype,ya=ga.hasOwnProperty;function ba(e,t,n,a,r,s){var o=n&va,d=Te(e),v=d.length,c=Te(t),f=c.length;if(v!=f&&!o)return!1;for(var h=v;h--;){var g=d[h];if(!(o?g in t:ya.call(t,g)))return!1}var $=s.get(e),u=s.get(t);if($&&u)return $==t&&u==e;var m=!0;s.set(e,t),s.set(t,e);for(var C=o;++h<v;){g=d[h];var b=e[g],p=t[g];if(a)var y=o?a(p,b,g,t,e,s):a(b,p,g,e,t,s);if(!(y===void 0?b===p||r(b,p,n,a,s):y)){m=!1;break}C||(C=g=="constructor")}if(m&&!C){var L=e.constructor,F=t.constructor;L!=F&&"constructor"in e&&"constructor"in t&&!(typeof L=="function"&&L instanceof L&&typeof F=="function"&&F instanceof F)&&(m=!1)}return s.delete(e),s.delete(t),m}var wa=ba,_e=Ke,$a=ot,xa=ha,Sa=wa,Le=Pt,Fe=X,Pe=Mt,Ca=It,Ra=1,Me="[object Arguments]",Ie="[object Array]",ne="[object Object]",Aa=Object.prototype,ke=Aa.hasOwnProperty;function Ta(e,t,n,a,r,s){var o=Fe(e),d=Fe(t),v=o?Ie:Le(e),c=d?Ie:Le(t);v=v==Me?ne:v,c=c==Me?ne:c;var f=v==ne,h=c==ne,g=v==c;if(g&&Pe(e)){if(!Pe(t))return!1;o=!0,f=!1}if(g&&!f)return s||(s=new _e),o||Ca(e)?$a(e,t,n,a,r,s):xa(e,t,v,n,a,r,s);if(!(n&Ra)){var $=f&&ke.call(e,"__wrapped__"),u=h&&ke.call(t,"__wrapped__");if($||u){var m=$?e.value():e,C=u?t.value():t;return s||(s=new _e),r(m,C,n,a,s)}}return g?(s||(s=new _e),Sa(e,t,n,a,r,s)):!1}var La=Ta,Fa=La,Oe=Ve;function st(e,t,n,a,r){return e===t?!0:e==null||t==null||!Oe(e)&&!Oe(t)?e!==e&&t!==t:Fa(e,t,n,a,st,r)}var rt=st,Pa=Ke,Ma=rt,Ia=1,ka=2;function Oa(e,t,n,a){var r=n.length,s=r,o=!a;if(e==null)return!s;for(e=Object(e);r--;){var d=n[r];if(o&&d[2]?d[1]!==e[d[0]]:!(d[0]in e))return!1}for(;++r<s;){d=n[r];var v=d[0],c=e[v],f=d[1];if(o&&d[2]){if(c===void 0&&!(v in e))return!1}else{var h=new Pa;if(a)var g=a(c,f,v,e,t,h);if(!(g===void 0?Ma(f,c,Ia|ka,a,h):g))return!1}}return!0}var Ea=Oa,Ba=kt;function Da(e){return e===e&&!Ba(e)}var lt=Da,Ha=lt,qa=Ot;function Na(e){for(var t=qa(e),n=t.length;n--;){var a=t[n],r=e[a];t[n]=[a,r,Ha(r)]}return t}var Ua=Na;function Za(e,t){return function(n){return n==null?!1:n[e]===t&&(t!==void 0||e in Object(n))}}var it=Za,Va=Ea,Ga=Ua,za=it;function Ka(e){var t=Ga(e);return t.length==1&&t[0][2]?za(t[0][0],t[0][1]):function(n){return n===e||Va(n,e,t)}}var Wa=Ka,Xa=X,Ya=We,Qa=/\.|\[(?:[^[\]]*|(["'])(?:(?!\1)[^\\]|\\.)*?\1)\]/,Ja=/^\w*$/;function ja(e,t){if(Xa(e))return!1;var n=typeof e;return n=="number"||n=="symbol"||n=="boolean"||e==null||Ya(e)?!0:Ja.test(e)||!Qa.test(e)||t!=null&&e in Object(t)}var ye=ja,ut=Et,eo="Expected a function";function be(e,t){if(typeof e!="function"||t!=null&&typeof t!="function")throw new TypeError(eo);var n=function(){var a=arguments,r=t?t.apply(this,a):a[0],s=n.cache;if(s.has(r))return s.get(r);var o=e.apply(this,a);return n.cache=s.set(r,o)||s,o};return n.cache=new(be.Cache||ut),n}be.Cache=ut;var to=be,no=to,ao=500;function oo(e){var t=no(e,function(a){return n.size===ao&&n.clear(),a}),n=t.cache;return t}var so=oo,ro=so,lo=/[^.[\]]+|\[(?:(-?\d+(?:\.\d+)?)|(["'])((?:(?!\2)[^\\]|\\.)*?)\2)\]|(?=(?:\.|\[\])(?:\.|\[\]|$))/g,io=/\\(\\)?/g,uo=ro(function(e){var t=[];return e.charCodeAt(0)===46&&t.push(""),e.replace(lo,function(n,a,r,s){t.push(r?s.replace(io,"$1"):a||n)}),t}),co=uo,_o=X,po=ye,mo=co,fo=Bt;function ho(e,t){return _o(e)?e:po(e,t)?[e]:mo(fo(e))}var ct=ho,vo=We,go=1/0;function yo(e){if(typeof e=="string"||vo(e))return e;var t=e+"";return t=="0"&&1/e==-go?"-0":t}var ue=yo,bo=ct,wo=ue;function $o(e,t){t=bo(t,e);for(var n=0,a=t.length;e!=null&&n<a;)e=e[wo(t[n++])];return n&&n==a?e:void 0}var dt=$o,xo=dt;function So(e,t,n){var a=e==null?void 0:xo(e,t);return a===void 0?n:a}var Co=So;function Ro(e,t){return e!=null&&t in Object(e)}var Ao=Ro,To=ct,Lo=Xe,Fo=X,Po=Dt,Mo=Ht,Io=ue;function ko(e,t,n){t=To(t,e);for(var a=-1,r=t.length,s=!1;++a<r;){var o=Io(t[a]);if(!(s=e!=null&&n(e,o)))break;e=e[o]}return s||++a!=r?s:(r=e==null?0:e.length,!!r&&Mo(r)&&Po(o,r)&&(Fo(e)||Lo(e)))}var Oo=ko,Eo=Ao,Bo=Oo;function Do(e,t){return e!=null&&Bo(e,t,Eo)}var Ho=Do,qo=rt,No=Co,Uo=Ho,Zo=ye,Vo=lt,Go=it,zo=ue,Ko=1,Wo=2;function Xo(e,t){return Zo(e)&&Vo(t)?Go(zo(e),t):function(n){var a=No(n,e);return a===void 0&&a===t?Uo(n,e):qo(t,a,Ko|Wo)}}var Yo=Xo;function Qo(e){return function(t){return t==null?void 0:t[e]}}var Jo=Qo,jo=dt;function es(e){return function(t){return jo(t,e)}}var ts=es,ns=Jo,as=ts,os=ye,ss=ue;function rs(e){return os(e)?ns(ss(e)):as(e)}var ls=rs,is=Wa,us=Yo,cs=qt,ds=X,_s=ls;function ps(e){return typeof e=="function"?e:e==null?cs:typeof e=="object"?ds(e)?us(e[0],e[1]):is(e):_s(e)}var ms=ps,fs=ms,hs=Ye;function vs(e,t){return e&&e.length?hs(e,fs(t)):[]}var gs=vs;const ys=re(gs);function bs(){const e=W(),{currentRoute:t}=e,{isUseTabsRouter:n}=q(),a=J(),r=T(()=>o(ht(e.getRoutes()))||[]),s=T(()=>a.tabRouters.reduce((c,f)=>(f.meta&&Reflect.has(f.meta,"frameSrc")&&c.push(f.name),c),[]));function o(c){let f=[];for(const h of c){const{meta:{frameSrc:g,frameBlank:$}={},children:u}=h;g&&!$&&f.push(h),u&&u.length&&f.push(...o(u))}return f=ys(f,"name"),f}function d(c){return c.name===w(t).name}function v(c){return w(n)?w(s).includes(c):e.currentRoute.value.name===c}return{hasRenderFrame:v,getFramePages:r,showIframe:d,getAllFramePages:o}}const ws=O({name:"FrameLayout",components:{FrameContent:Nn},setup(){const{getFramePages:e,hasRenderFrame:t,showIframe:n}=bs(),a=T(()=>w(e).length>0);return{getFramePages:e,hasRenderFrame:t,showIframe:n,showFrame:a}}}),$s={key:0};function xs(e,t,n,a,r,s){const o=fe("frame-content");return e.showFrame?(_(),R("div",$s,[(_(!0),R(H,null,G(e.getFramePages,d=>(_(),R(H,{key:d.path},[e.hasRenderFrame(d.name)?ae((_(),A(o,{key:0,"frame-src":d.meta.frameSrc},null,8,["frame-src"])),[[oe,e.showIframe(d)]]):E("",!0)],64))),128))])):E("",!0)}const Ss=U(ws,[["render",xs]]),Cs=O({__name:"Content",setup(e){const t=T(()=>{const a=J(),{tabRouters:r}=a;return r.filter(s=>{var v;const o=(v=s.meta)==null?void 0:v.keepAlive,d=Bn(o)||kn(o)&&o;return s.isAlive&&d}).map(s=>s.name)}),n=T(()=>{const a=J(),{refreshing:r}=a;return r});return(a,r)=>{const s=fe("router-view");return _(),R(H,null,[n.value?E("",!0):(_(),A(s,{key:0},{default:i(({Component:o})=>[l(gt,{name:"fade"},{default:i(()=>[(_(),A(vt,{include:t.value},[x("div",null,[(_(),A(Q(o)))])],1032,["include"]))]),_:2},1024)]),_:1})),l(Ss)],64)}}});const Rs=U(Cs,[["__scopeId","data-v-0d7937e1"]]),As=O({__name:"Footer",setup(e){const t=ie(),n=T(()=>t.config.site_info_copyright),a=V("");switch(window.location.pathname.split("/")[1]){case"admin":a.value="admin";break;case"merchant":a.value="merchant";break}return(s,o)=>{const d=Yt;return a.value==="merchant"?(_(),R("div",{key:0,class:M(w(P)+"-footer")},k(n.value),3)):(_(),R("div",{key:1,class:M(w(P)+"-footer")},[B(" Copyright © 2024 骑士发卡 强力驱动 "),l(d,{theme:"primary",hover:"color",style:{"margin-left":"10px"},href:"http://www.qqss.net",target:"_blank"},{default:i(()=>[B("www.qqss.net")]),_:1})],2))}}});const Ts=U(As,[["__scopeId","data-v-2fc86de3"]]),Ee=O({__name:"LayoutContent",setup(e){const t=le(),n=W(),a=q(),r=J(),s=T(()=>r.tabRouters.filter(p=>p.isAlive||p.isHome)),o=V(""),{locale:d}=Nt(),v=p=>{const{tabRouters:y}=r,L=y.find(F=>F.path===p);n.push({path:p,query:L.query})},c=p=>{const{tabRouters:y}=r,L=y[p.index+1]||y[p.index-1];r.subtractCurrentTabRouter({path:p.value,routeIdx:p.index}),p.value===t.path&&n.push({path:L.path,query:L.query})},f=p=>typeof p=="string"?p:p[d.value],h=(p,y)=>{r.toggleTabRouterAlive(y),yt(()=>{r.toggleTabRouterAlive(y),n.replace({path:p.path,query:p.query})}),o.value=null},g=(p,y)=>{r.subtractTabRouterAhead({path:p,routeIdx:y}),m("ahead",y)},$=(p,y)=>{r.subtractTabRouterBehind({path:p,routeIdx:y}),m("behind",y)},u=(p,y)=>{r.subtractTabRouterOther({path:p,routeIdx:y}),m("other",y)},m=(p,y)=>{const L=n.currentRoute.value.path,{tabRouters:F}=r,D=F.findIndex(S=>S.path===L);if(p==="other"&&D!==y||p==="ahead"&&D<y||p==="behind"&&D===-1){const S=p==="behind"?F.length-1:1,I=F[S];n.push({path:I.path,query:I.query})}o.value=null},C=(p,y,L)=>{y.trigger==="document"&&(o.value=null),p&&(o.value=L)},b=p=>{const{tabRouters:y}=r;[y[p.currentIndex],y[p.targetIndex]]=[y[p.targetIndex],y[p.currentIndex]]};return(p,y)=>{const L=Y,F=he,D=ve,Z=ge,S=jt,I=Qt,z=Je,ce=Jt,xe=je;return _(),A(xe,{class:M(`${w(P)}-layout`)},{default:i(()=>[w(a).isUseTabsRouter?(_(),A(I,{key:0,"drag-sort":"",theme:"card",class:M(`${w(P)}-layout-tabs-nav`),value:p.$route.path,style:{position:"sticky",top:0,width:"100%"},onChange:v,onRemove:c,onDragSort:b},{default:i(()=>[(_(!0),R(H,null,G(s.value,(N,K)=>(_(),A(S,{key:`${N.path}_${K}`,value:N.path,removable:!N.isHome,draggable:!N.isHome},{label:i(()=>[l(Z,{trigger:"context-menu","min-column-width":128,"popup-props":{overlayClassName:"route-tabs-dropdown",onVisibleChange:(pt,mt)=>C(pt,mt,N.path),visible:o.value===N.path}},{dropdown:i(()=>[l(D,null,{default:i(()=>[l(F,{onClick:()=>h(N,K)},{default:i(()=>[l(L,{name:"refresh"}),B(" "+k(p.$t("layout.tagTabs.refresh")),1)]),_:2},1032,["onClick"]),K>1?(_(),A(F,{key:0,onClick:()=>g(N.path,K)},{default:i(()=>[l(L,{name:"arrow-left"}),B(" "+k(p.$t("layout.tagTabs.closeLeft")),1)]),_:2},1032,["onClick"])):E("",!0),K<s.value.length-1?(_(),A(F,{key:1,onClick:()=>$(N.path,K)},{default:i(()=>[l(L,{name:"arrow-right"}),B(" "+k(p.$t("layout.tagTabs.closeRight")),1)]),_:2},1032,["onClick"])):E("",!0),s.value.length>2?(_(),A(F,{key:2,onClick:()=>u(N.path,K)},{default:i(()=>[l(L,{name:"close-circle"}),B(" "+k(p.$t("layout.tagTabs.closeOther")),1)]),_:2},1032,["onClick"])):E("",!0)]),_:2},1024)]),default:i(()=>[N.isHome?(_(),A(L,{key:1,name:"home"})):(_(),R(H,{key:0},[B(k(f(N.title)),1)],64))]),_:2},1032,["popup-props"])]),_:2},1032,["value","removable","draggable"]))),128))]),_:1},8,["class","value"])):E("",!0),l(z,{class:M(`${w(P)}-content-layout`)},{default:i(()=>[l(Rs)]),_:1},8,["class"]),w(a).showFooter?(_(),A(ce,{key:1,class:M(`${w(P)}-footer-layout`)},{default:i(()=>[l(Ts)]),_:1},8,["class"])):E("",!0)]),_:1},8,["class"])}}}),we=O({__name:"MenuContent",props:{navData:{type:Array,default:()=>[]}},setup(e){const t=e,n=T(()=>j()),a=T(()=>{const{navData:c}=t;return s(c)}),r=c=>typeof c.icon=="string"?bt("t-icon",{name:c.icon}):c.icon,s=(c,f)=>!c||c.length===0?[]:(c.sort((h,g)=>{var $,u;return((($=h.meta)==null?void 0:$.orderNo)||0)-(((u=g.meta)==null?void 0:u.orderNo)||0)}),c.map(h=>{var $,u;const g=f&&!h.path.includes(f)?`${f}/${h.path}`:h.path;return{path:g,title:($=h.meta)==null?void 0:$.title,icon:(u=h.meta)==null?void 0:u.icon,children:s(h.children,g),meta:h.meta,redirect:h.redirect}}).filter(h=>h.meta&&h.meta.hidden!==!0)),o=c=>{const{frameSrc:f,frameBlank:h}=c.meta;return f&&h?f.match(/(http|https):\/\/([\w.]+\/?)\S*/):null},d=c=>{var g;const f=n.value.split("/").length,h=c.path.split("/").length;return f>h&&n.value.startsWith(c.path)||n.value===c.path?n.value:(g=c.meta)!=null&&g.single?c.redirect:c.path},v=c=>{window.open(c)};return(c,f)=>{const h=en,g=fe("menu-content",!0),$=tn;return _(),R("div",null,[(_(!0),R(H,null,G(a.value,u=>{var m;return _(),R(H,{key:u.path},[!u.children||!u.children.length||(m=u.meta)!=null&&m.single?(_(),R(H,{key:0},[o(u)?(_(),A(h,{key:0,name:u.path,value:d(u),onClick:C=>v(o(u)[0])},{icon:i(()=>[(_(),A(Q(r(u)),{class:"t-icon"}))]),default:i(()=>[B(" "+k(u.title),1)]),_:2},1032,["name","value","onClick"])):(_(),A(h,{key:1,name:u.path,value:d(u),to:u.path},{icon:i(()=>[(_(),A(Q(r(u)),{class:"t-icon"}))]),default:i(()=>[B(" "+k(u.title),1)]),_:2},1032,["name","value","to"]))],64)):(_(),A($,{key:1,name:u.path,value:u.path,title:u.title},{icon:i(()=>[(_(),A(Q(r(u)),{class:"t-icon"}))]),default:i(()=>[u.children?(_(),A(g,{key:0,"nav-data":u.children},null,8,["nav-data"])):E("",!0)]),_:2},1032,["name","value","title"]))],64)}),128))])}}}),Ls=["src"],Fs={class:"operations-container"},Ps={class:"header-user-account"},Ms={name:"LHeader"},Is=O({...Ms,props:{theme:{type:String,default:"light"},layout:{type:String,default:"top"},showLogo:{type:Boolean,default:!0},menu:{type:Array,default:()=>[]},isFixed:{type:Boolean,default:!1},isCompact:{type:Boolean,default:!1},maxLevel:{type:Number,default:3}},setup(e){const t=ie(),n=T(()=>t.config.site_logo),a=Se(),r=T(()=>a.userInfo),s=e,o=Se();(async()=>{await o.getUserInfo()})();const v=W(),c=q(),f=()=>{c.updateConfig({showSettingPanel:!0})},h=T(()=>j()),g=T(()=>[`${P}-header-layout`]),$=T(()=>{const{isFixed:b,layout:p,isCompact:y}=s;return[{[`${P}-header-menu`]:!b,[`${P}-header-menu-fixed`]:b,[`${P}-header-menu-fixed-side`]:p==="side"&&b,[`${P}-header-menu-fixed-side-compact`]:p==="side"&&b&&y}]}),u=T(()=>s.theme),m=b=>{v.push(b)},C=()=>{const b=nn.confirm({header:"提醒",body:"是否确认退出登录？",confirmBtn:{content:"提交",theme:"primary",loading:!1},closeOnOverlayClick:!1,onConfirm:async()=>{a.logout(),b.hide(),an.success("退出成功"),m("/admin/login")}})};return(b,p)=>{const y=et,L=Y,F=te,D=he,Z=ve,S=ge,I=on,z=tt,ce=nt;return _(),R("div",{class:M(g.value)},[l(ce,{class:M($.value),theme:u.value,"expand-type":"popup",value:h.value},Ze({logo:i(()=>[e.showLogo?(_(),R("span",{key:0,class:"header-logo-container",onClick:p[0]||(p[0]=xe=>m("/admin/base"))},[x("img",{src:n.value,alt:"",style:{width:"184px",height:"26px"}},null,8,Ls)])):E("",!0)]),operations:i(()=>[x("div",Fs,[l(S,{"min-column-width":120,trigger:"hover"},{dropdown:i(()=>[l(Z,null,{default:i(()=>[l(D,{class:"operations-dropdown-container-item",onClick:C},{default:i(()=>[B(" 退出登录 ")]),_:1})]),_:1})]),default:i(()=>[l(F,{class:"header-user-btn",theme:"default",variant:"text"},{icon:i(()=>[l(y,{image:r.value.avatar,shape:"circle",style:{width:"30px",height:"30px","margin-right":"15px"}},null,8,["image"])]),suffix:i(()=>[l(L,{name:"chevron-down"})]),default:i(()=>[x("div",Ps,k(r.value.nickname),1)]),_:1})]),_:1}),l(I,{layout:"vertical"}),l(z,{placement:"bottom",content:"系统设置"},{default:i(()=>[l(F,{theme:"default",shape:"square",variant:"text",onClick:f},{default:i(()=>[l(L,{name:"setting",size:"large"})]),_:1})]),_:1})])]),_:2},[e.layout!=="side"?{name:"default",fn:i(()=>[l(we,{class:"header-menu","nav-data":e.menu},null,8,["nav-data"])]),key:"0"}:void 0]),1032,["class","theme","value"])],2)}}});const ks=U(Is,[["__scopeId","data-v-9e6620fe"]]),$e=e=>(wt("data-v-0b8b2514"),e=e(),$t(),e),Os={class:"header-msg"},Es=$e(()=>x("div",{class:"header-msg-top"},[x("p",null,"通知中心")],-1)),Bs={class:"msg-content"},Ds={class:"msg-type"},Hs={class:"msg-time"},qs={key:1,class:"empty-list"},Ns=$e(()=>x("img",{src:Cn,alt:"空"},null,-1)),Us=$e(()=>x("p",null,"暂无通知",-1)),Zs=[Ns,Us],Vs={key:2,class:"header-msg-bottom"},Gs={name:"Notice"},zs=O({...Gs,setup(e){const t=W(),n=Ut(),{unReadMsgCount:a,msgDataList:r}=se(n),s=()=>{n.getMsgData()},o=v=>{n.setMsgRead(v)},d=()=>{t.push("/merchant/user/message")};return ee(()=>{s()}),(v,c)=>{const f=te,h=ln,g=sn,$=Y,u=rn,m=at;return _(),A(m,{"expand-animation":"",placement:"bottom-right",trigger:"hover"},{content:i(()=>[x("div",Os,[Es,w(a)>0?(_(),A(g,{key:0,class:"narrow-scrollbar",split:!1},{default:i(()=>[(_(!0),R(H,null,G(w(r),(C,b)=>(_(),A(h,{key:b},{action:i(()=>[l(f,{size:"small",variant:"outline",onClick:p=>o(C.id)},{default:i(()=>[B(" 设为已读 ")]),_:2},1032,["onClick"])]),default:i(()=>[x("div",null,[x("p",Bs,k(C.content),1),x("p",Ds,k(C.title),1)]),x("p",Hs,k(w(Rn)(C.create_at)),1)]),_:2},1024))),128))]),_:1})):(_(),R("div",qs,Zs)),w(a)>0?(_(),R("div",Vs,[l(f,{class:"header-msg-bottom-link",variant:"text",theme:"default",block:"",onClick:d},{default:i(()=>[B("查看全部")]),_:1})])):E("",!0)])]),default:i(()=>[l(u,{count:w(a),offset:[4,4],size:"small"},{default:i(()=>[l(f,{theme:"default",shape:"square",variant:"text"},{default:i(()=>[l($,{name:"notification",size:"large"})]),_:1})]),_:1},8,["count"])]),_:1})}}});const Ks=U(zs,[["__scopeId","data-v-0b8b2514"]]),Ws=O({__name:"Breadcrumb",setup(e){const t=T(()=>{const n=le(),a=n.path.split("/");return a.shift(),a.reduce((s,o,d)=>{var v,c,f,h;return(c=(v=n.matched[d])==null?void 0:v.meta)!=null&&c.hiddenBreadcrumb||Object.values(n.params).includes(o)||s.push({path:o,to:s[d-1]?`/${s[d-1].path}/${o}`:`/${o}`,title:((h=(f=n.matched[d])==null?void 0:f.meta)==null?void 0:h.title)??o}),s},[])});return(n,a)=>{const r=un,s=cn;return _(),A(s,{"max-item-width":"150",class:"tdesign-breadcrumb"},{default:i(()=>[(_(!0),R(H,null,G(t.value,o=>(_(),A(r,{key:o.to,to:o.to},{default:i(()=>[B(k(o.title),1)]),_:2},1032,["to"]))),128))]),_:1})}}});const Xs=U(Ws,[["__scopeId","data-v-b09aa6cf"]]),Ys={key:0,class:"header-menu-search"},Qs={class:"textBox",style:{flex:"10"}},Js=["onClick"],js={style:{color:"#bbb","padding-right":"10px"}},er={key:1,class:"header-menu-search-left"},tr=O({__name:"Search",props:{layout:String},setup(e){const t=q(),n=W(),a=V([]);(async()=>{const{data:v}=await An();a.value=v})();const s=V(!1),o=V(""),d=v=>{v||(o.value=""),s.value=v};return(v,c)=>{const f=pn,h=dn,g=Y,$=te,u=_n;return e.layout==="side"?(_(),R("div",Ys,[w(t).showBreadcrumb?(_(),A(Xs,{key:0})):E("",!0),x("div",{class:M(["announcement",["header-search",{"hover-active":s.value}]])},[x("div",Qs,[l(h,{direction:"vertical",animation:"fade",height:22,autoplay:"",interval:5e3,navigation:{showSlideBtn:"never"}},{default:i(()=>[(_(!0),R(H,null,G(a.value,(m,C)=>(_(),A(f,{key:C},{default:i(()=>[x("div",{class:"text",onClick:b=>w(n).push(`/merchant/user/news/detail/${m.id}`)},[x("span",js,k(m.cate_name),1),B(" "+k(m.title),1)],8,Js)]),_:2},1024))),128))]),_:1})])],2)])):(_(),R("div",er,[l($,{class:M({"search-icon-hide":s.value}),theme:"default",shape:"square",variant:"text",onClick:c[0]||(c[0]=m=>d(!0))},{default:i(()=>[l(g,{name:"search"})]),_:1},8,["class"]),l(u,{modelValue:o.value,"onUpdate:modelValue":c[1]||(c[1]=m=>o.value=m),class:M(["header-search",{"width-zero":!s.value}]),placeholder:"输入要搜索内容",autofocus:s.value,onBlur:c[2]||(c[2]=m=>d(!1))},{"prefix-icon":i(()=>[l(g,{name:"search",size:"16"})]),_:1},8,["modelValue","class","autofocus"])]))}}});const nr=U(tr,[["__scopeId","data-v-5e6dbe4f"]]),ar=["src"],or={key:1,class:"header-operate-left"},sr={class:"operations-container"},rr={class:"header-user-account",style:{"padding-left":"5px"}},lr={name:"LHeader"},ir=O({...lr,props:{theme:{type:String,default:"light"},layout:{type:String,default:"top"},showLogo:{type:Boolean,default:!0},menu:{type:Array,default:()=>[]},isFixed:{type:Boolean,default:!1},isCompact:{type:Boolean,default:!1},maxLevel:{type:Number,default:3}},setup(e){const t=W(),n=Zt();(()=>{n.getUserInfo()})();const r=ie(),s=T(()=>r.config.site_logo),o=T(()=>n.userInfo),d=e,v=q(),c=()=>{v.updateConfig({showSettingPanel:!0})},f=T(()=>j()),h=T(()=>[`${P}-header-layout`]),g=T(()=>{const{isFixed:C,layout:b,isCompact:p}=d;return[{[`${P}-header-menu`]:!C,[`${P}-header-menu-fixed`]:C,[`${P}-header-menu-fixed-side`]:b==="side"&&C,[`${P}-header-menu-fixed-side-compact`]:b==="side"&&C&&p}]}),$=T(()=>d.theme),u=C=>{t.push({name:C})},m=()=>{t.push({path:"/merchant/login",query:{redirect:encodeURIComponent(t.currentRoute.value.fullPath)}})};return(C,b)=>{const p=et,y=Y,L=te,F=he,D=ve,Z=ge,S=tt,I=nt;return _(),R("div",{class:M(h.value)},[l(I,{class:M(g.value),theme:$.value,"expand-type":"popup",value:f.value},Ze({logo:i(()=>[e.showLogo?(_(),R("span",{key:0,class:"header-logo-container",onClick:b[0]||(b[0]=z=>u("merchantWorkbench"))},[x("img",{src:s.value,alt:"",style:{width:"184px",height:"26px"}},null,8,ar)])):(_(),R("div",or,[l(nr,{layout:e.layout},null,8,["layout"])]))]),operations:i(()=>[x("div",sr,[l(Z,{"min-column-width":120,trigger:"hover"},{dropdown:i(()=>[l(D,null,{default:i(()=>[l(F,{class:"operations-dropdown-container-item",onClick:b[1]||(b[1]=z=>u("merchantUserPassword"))},{default:i(()=>[l(y,{name:"user-circle"}),B("修改密码 ")]),_:1}),l(F,{class:"operations-dropdown-container-item",onClick:m},{default:i(()=>[l(y,{name:"poweroff"}),B("退出登录 ")]),_:1})]),_:1})]),default:i(()=>[l(L,{class:"header-user-btn",theme:"default",variant:"text"},{icon:i(()=>[l(p,{image:o.value.avatar,shape:"circle",style:{width:"30px",height:"30px"}},null,8,["image"])]),suffix:i(()=>[l(y,{name:"chevron-down"})]),default:i(()=>[x("div",rr,k(o.value.username),1)]),_:1})]),_:1}),l(Ks),l(S,{placement:"bottom",content:"样式设置"},{default:i(()=>[l(L,{theme:"default",shape:"square",variant:"text",onClick:c},{default:i(()=>[l(y,{name:"setting",size:"large"})]),_:1})]),_:1})])]),_:2},[e.layout!=="side"?{name:"default",fn:i(()=>[l(we,{class:"header-menu","nav-data":e.menu},null,8,["nav-data"])]),key:"0"}:void 0]),1032,["class","theme","value"])],2)}}});const ur=U(ir,[["__scopeId","data-v-8142181b"]]),Be=O({__name:"LayoutHeader",setup(e){const t=Qe(),n=q(),{asyncRoutes:a,app:r}=se(t),s=T(()=>n.layout==="mix"?n.splitMenu?a.value.map(o=>({...o,children:[]})):[]:a.value);return(o,d)=>(_(),R(H,null,[w(n).showHeader&&w(r)==="merchant"?(_(),A(ur,{key:0,"show-logo":w(n).showHeaderLogo,theme:w(n).displayMode,layout:w(n).layout,"is-fixed":w(n).isHeaderFixed,menu:s.value,"is-compact":w(n).isSidebarCompact},null,8,["show-logo","theme","layout","is-fixed","menu","is-compact"])):E("",!0),w(n).showHeader&&w(r)==="admin"?(_(),A(ks,{key:1,"show-logo":w(n).showHeaderLogo,layout:w(n).layout,"is-fixed":w(n).isHeaderFixed,menu:s.value,"is-compact":w(n).isSidebarCompact},null,8,["show-logo","layout","is-fixed","menu","is-compact"])):E("",!0)],64))}});var De=ze,cr=Xe,dr=X,He=De?De.isConcatSpreadable:void 0;function _r(e){return dr(e)||cr(e)||!!(He&&e&&e[He])}var pr=_r,mr=Vt,fr=pr;function _t(e,t,n,a,r){var s=-1,o=e.length;for(n||(n=fr),r||(r=[]);++s<o;){var d=e[s];t>0&&n(d)?t>1?_t(d,t-1,n,a,r):mr(r,d):a||(r[r.length]=d)}return r}var hr=_t,vr=hr,gr=Gt,yr=Ye,br=zt,wr=gr(function(e){return yr(vr(e,1,br,!0))}),$r=wr;const xr=re($r),Sr={class:"version-container",style:{float:"right"}},Cr=992-1,Rr=O({__name:"SideNav",props:{menu:{type:Array,default:()=>[]},showLogo:{type:Boolean,default:!0},isFixed:{type:Boolean,default:!0},layout:{type:String,default:""},headerHeight:{type:String,default:"64px"},theme:{type:String,default:"light"},isCompact:{type:Boolean,default:!1}},setup(e){const t=()=>{$.updateConfig({isSidebarCompact:!$.isSidebarCompact})},n=ie(),a=n.getSiteMerchantLogo,r=n.getSiteMerchantLogoSm,s=e,o=T(()=>q().isSidebarCompact),d=T(()=>q().expandMutex),v=T(()=>j()),c=T(()=>{const b=j(),p=b.substring(0,b.lastIndexOf("/")),y=Kt();return xr(y,p===""?[]:[p])}),f=T(()=>{const{isCompact:b}=s;return[`${P}-sidebar-layout`,{[`${P}-sidebar-compact`]:b}]}),h=T(()=>{const{showLogo:b,isFixed:p,layout:y}=s;return[`${P}-side-nav`,{[`${P}-side-nav-no-logo`]:!b,[`${P}-side-nav-no-fixed`]:!p,[`${P}-side-nav-mix-fixed`]:y==="mix"&&p}]}),g=W(),$=q(),u=()=>{const b=window.innerWidth<=Cr;$.updateConfig({isSidebarCompact:b})};ee(()=>{u(),window.onresize=()=>{u()}});const m=()=>{g.push("/")},C=()=>o.value?r:a;return(b,p)=>{const y=mn,L=Y,F=te,D=fn;return _(),R("div",{class:M(f.value)},[l(D,{class:M(h.value),theme:e.theme,value:v.value,collapsed:o.value,"default-expanded":c.value,"expand-mutex":d.value,width:"200px"},{logo:i(()=>[e.showLogo?(_(),R("span",{key:0,class:M(`${w(P)}-side-nav-logo-wrapper`),onClick:m},[l(y,{src:C(),class:M(`${w(P)}-side-nav-logo-${o.value?"t":"tdesign"}-logo`)},null,8,["src","class"])],2)):E("",!0)]),operations:i(()=>[x("span",Sr,[l(F,{theme:"default",shape:"square",variant:"text",onClick:t},{default:i(()=>[l(L,{class:"collapsed-icon",name:"view-list"})]),_:1})])]),default:i(()=>[l(we,{"nav-data":e.menu},null,8,["nav-data"])]),_:1},8,["class","theme","value","collapsed","default-expanded","expand-mutex"]),x("div",{class:M(`${w(P)}-side-nav-placeholder${o.value?"-hidden":""}`)},null,2)],2)}}});const Ar=U(Rr,[["__scopeId","data-v-21f277f0"]]),qe=O({__name:"LayoutSideNav",setup(e){const t=le(),n=Qe(),a=q(),{asyncRoutes:r}=se(n),s=T(()=>{const{layout:o,splitMenu:d}=a;let v=r.value;return o==="mix"&&d&&v.forEach(c=>{t.path.indexOf(c.path)===0&&(v=c.children.map(f=>({...f,path:`${c.path}/${f.path}`})))}),v});return(o,d)=>w(a).showSidebar?(_(),A(Ar,{key:0,"show-logo":w(a).showSidebarLogo,layout:w(a).layout,"is-fixed":w(a).isSidebarFixed,menu:s.value,theme:w(a).displayMode,"is-compact":w(a).isSidebarCompact},null,8,["show-logo","layout","is-fixed","menu","theme","is-compact"])):E("",!0)}}),Tr={xmlns:"http://www.w3.org/2000/svg",width:"88",height:"48",fill:"none"},Lr=x("path",{fill:"var(--td-component-border)",d:"M0 0h88v48H0V0Z"},null,-1),Fr=x("path",{fill:"var(--td-text-color-primary)",d:"M42.863 14.052v2.708h1.625v-2.708h-1.625Z"},null,-1),Pr=x("path",{fill:"var(--td-text-color-primary)","fill-rule":"evenodd",d:"M38.349 23.982a5.326 5.326 0 1 1 10.653 0 5.326 5.326 0 0 1-10.653 0Zm5.326-3.701a3.701 3.701 0 1 0 0 7.403 3.701 3.701 0 0 0 0-7.403ZM52.208 26.781h-2.621l-2.06 6.699 1.552.478.511-1.661h2.614l.511 1.66 1.554-.477-2.061-6.699Zm-.503 3.89-.697-2.265h-.221l-.697 2.266h1.615Z","clip-rule":"evenodd"},null,-1),Mr=x("path",{fill:"var(--td-text-color-primary)",d:"m48.208 18.3 1.915-1.914 1.149 1.15-1.915 1.914-1.15-1.15ZM53.606 23.17h-2.709v1.625h2.709V23.17ZM44.488 31.204v2.709h-1.625v-2.708h1.625ZM37.228 31.579l1.915-1.915-1.15-1.15-1.914 1.916 1.149 1.149ZM36.453 24.795h-2.708V23.17h2.708v1.625ZM36.079 17.535l1.915 1.915 1.149-1.15-1.915-1.914-1.15 1.15Z"},null,-1),Ir=[Lr,Fr,Pr,Mr];function kr(e,t){return _(),R("svg",Tr,[...Ir])}const Or={render:kr},Er={xmlns:"http://www.w3.org/2000/svg",width:"88",height:"48",fill:"none"},Br=x("path",{fill:"#13161B",d:"M0 0h88v48H0V0Z"},null,-1),Dr=x("path",{fill:"#949EAA","fill-rule":"evenodd",d:"M52.533 26.87a9 9 0 0 1-10.065-11.74A9 9 0 0 0 44 33a9.004 9.004 0 0 0 8.532-6.13Z","clip-rule":"evenodd"},null,-1),Hr=[Br,Dr];function qr(e,t){return _(),R("svg",Er,[...Hr])}const Nr={render:qr},Ur={xmlns:"http://www.w3.org/2000/svg",width:"88",height:"48",fill:"none"},Zr=x("path",{fill:"var(--td-component-border)",d:"M0 0h88v48H0z"},null,-1),Vr=x("path",{fill:"var(--td-text-color-primary)","fill-rule":"evenodd",d:"M44 20.583a3.417 3.417 0 1 0 0 6.833 3.417 3.417 0 0 0 0-6.833ZM39.083 24a4.917 4.917 0 1 1 9.834 0 4.917 4.917 0 0 1-9.834 0ZM43.25 17.333v-2.5h1.5v2.5h-1.5ZM48.184 18.755l1.767-1.767 1.06 1.06-1.767 1.768-1.06-1.06ZM50.667 23.25h2.5v1.5h-2.5v-1.5ZM49.244 28.183l1.768 1.768-1.06 1.06-1.768-1.767 1.06-1.06ZM44.75 30.666v2.5h-1.5v-2.5h1.5ZM39.816 29.244l-1.767 1.768-1.061-1.061 1.767-1.768 1.061 1.061ZM37.333 24.75h-2.5v-1.5h2.5v1.5ZM38.755 19.816l-1.767-1.768 1.06-1.06 1.768 1.767-1.06 1.06Z","clip-rule":"evenodd"},null,-1),Gr=[Zr,Vr];function zr(e,t){return _(),R("svg",Ur,[...Gr])}const Kr={render:zr},Wr="conic-gradient(from 90deg at 50% 50%, #FF0000 -19.41deg, #FF0000 18.76deg, #FF8A00 59.32deg, #FFE600 99.87deg, #14FF00 141.65deg, #00A3FF 177.72deg, #0500FF 220.23deg, #AD00FF 260.13deg, #FF00C7 300.69deg, #FF0000 340.59deg, #FF0000 378.76deg)",Xr=O({__name:"index",props:{value:{type:String}},setup(e){const t=e,n=T(()=>{const{value:a}=t;return{background:me.indexOf(a)>-1?a:Wr}});return(a,r)=>(_(),R("div",{style:pe(n.value),class:"color-container"},null,4))}});const Ne=U(Xr,[["__scopeId","data-v-6cb9ea24"]]),Yr={class:"setting-container"},Qr=x("div",{class:"setting-group-title"},"主题模式",-1),Jr={style:{textAlign:"center",marginTop:"8px"}},jr=x("div",{class:"setting-group-title"},"主题色",-1),el={class:"setting-layout-drawer"},tl=x("div",{class:"setting-group-title"},"导航布局",-1),nl=x("div",{class:"setting-group-title"},"元素开关",-1),al=O({__name:"setting",setup(e){const t=q(),n=["side","top","mix"],a=[{type:"light",text:"明亮"},{type:"dark",text:"暗黑"},{type:"auto",text:"跟随系统"}],r=()=>{const u=Wt;for(const m in u)Object.prototype.hasOwnProperty.call(u,m)&&(u[m]=t[m]);return u},s=T(()=>me.indexOf(o.value.brandTheme)===-1?o.value.brandTheme:""),o=V({...r()}),d=V(!1),v=T({get(){return t.showSettingPanel},set(u){t.updateConfig({showSettingPanel:u})}}),c=u=>{o.value.brandTheme=u};ee(()=>{document.querySelector(".dynamic-color-btn").addEventListener("click",()=>{d.value=!0})});const f=(u,m)=>{!u&&m.trigger==="document"&&(d.value=u)},h=u=>u==="light"?Kr:u==="dark"?Nr:Or,g=()=>{t.updateConfig({showSettingPanel:!1})},$=u=>`https://tdesign.gtimg.com/tdesign-pro/setting/${u}.png`;return xt(()=>{o.value.brandTheme&&t.updateConfig(o.value)}),(u,m)=>{const C=hn,b=vn,p=gn,y=at,L=yn,F=bn,D=wn,Z=$n;return _(),A(Z,{visible:v.value,"onUpdate:visible":m[8]||(m[8]=S=>v.value=S),size:"408px",footer:!1,header:"页面配置","close-btn":!0,class:"setting-drawer-container",onCloseBtnClick:g},{default:i(()=>[x("div",Yr,[l(D,{ref:"form",data:o.value,"label-align":"left"},{default:i(()=>[Qr,l(b,{modelValue:o.value.mode,"onUpdate:modelValue":m[0]||(m[0]=S=>o.value.mode=S)},{default:i(()=>[(_(),R(H,null,G(a,(S,I)=>x("div",{key:I,class:"setting-layout-drawer"},[x("div",null,[(_(),A(C,{key:I,value:S.type},{default:i(()=>[(_(),A(Q(h(S.type))))]),_:2},1032,["value"])),x("p",Jr,k(S.text),1)])])),64))]),_:1},8,["modelValue"]),jr,l(b,{modelValue:o.value.brandTheme,"onUpdate:modelValue":m[1]||(m[1]=S=>o.value.brandTheme=S)},{default:i(()=>[(_(!0),R(H,null,G(w(me),(S,I)=>(_(),R("div",{key:I,class:"setting-layout-drawer"},[(_(),A(C,{key:I,value:S,class:"setting-layout-color-group"},{default:i(()=>[l(Ne,{value:S},null,8,["value"])]),_:2},1032,["value"]))]))),128)),x("div",el,[l(y,{"destroy-on-close":"","expand-animation":"",placement:"bottom-right",trigger:"click",visible:d.value,"overlay-style":{padding:0},onVisibleChange:f},{content:i(()=>[l(p,{"on-change":c,"color-modes":["monochrome"],format:"HEX","swatch-colors":[]})]),default:i(()=>[l(C,{value:s.value,class:"setting-layout-color-group dynamic-color-btn"},{default:i(()=>[l(Ne,{value:s.value},null,8,["value"])]),_:1},8,["value"])]),_:1},8,["visible"])])]),_:1},8,["modelValue"]),tl,l(b,{modelValue:o.value.layout,"onUpdate:modelValue":m[2]||(m[2]=S=>o.value.layout=S)},{default:i(()=>[(_(),R(H,null,G(n,(S,I)=>x("div",{key:I,class:"setting-layout-drawer"},[(_(),A(C,{key:I,value:S},{default:i(()=>[l(Tn,{src:$(S)},null,8,["src"])]),_:2},1032,["value"]))])),64))]),_:1},8,["modelValue"]),ae(l(F,{label:"分割菜单（混合模式下有效）",name:"splitMenu"},{default:i(()=>[l(L,{modelValue:o.value.splitMenu,"onUpdate:modelValue":m[3]||(m[3]=S=>o.value.splitMenu=S)},null,8,["modelValue"])]),_:1},512),[[oe,o.value.layout==="mix"]]),ae(l(F,{label:"固定 Sidebar",name:"isSidebarFixed"},{default:i(()=>[l(L,{modelValue:o.value.isSidebarFixed,"onUpdate:modelValue":m[4]||(m[4]=S=>o.value.isSidebarFixed=S)},null,8,["modelValue"])]),_:1},512),[[oe,o.value.layout==="mix"]]),nl,ae(l(F,{label:"显示 Header",name:"showHeader"},{default:i(()=>[l(L,{modelValue:o.value.showHeader,"onUpdate:modelValue":m[5]||(m[5]=S=>o.value.showHeader=S)},null,8,["modelValue"])]),_:1},512),[[oe,o.value.layout==="side"]]),l(F,{label:"只展开一个一级菜单",name:"expandMutex"},{default:i(()=>[l(L,{modelValue:o.value.expandMutex,"onUpdate:modelValue":m[6]||(m[6]=S=>o.value.expandMutex=S)},null,8,["modelValue"])]),_:1}),l(F,{label:"显示 Footer",name:"showFooter"},{default:i(()=>[l(L,{modelValue:o.value.showFooter,"onUpdate:modelValue":m[7]||(m[7]=S=>o.value.showFooter=S)},null,8,["modelValue"])]),_:1})]),_:1},8,["data"])])]),_:1},8,["visible"])}}});const vl=O({__name:"index",setup(e){const t=le(),n=q(),a=J(),r=se(n),s=T(()=>[{"t-layout--with-sider":n.showSidebar}]),o=()=>{const{path:d,query:v,meta:{title:c},name:f}=t;a.appendTabRouterList({path:d,query:v,title:c,name:f,isAlive:!0,meta:t.meta})};return ee(()=>{o()}),Ue(()=>t.path,()=>{o(),document.querySelector(`.${P}-layout`).scrollTo({top:0,behavior:"smooth"})}),(d,v)=>{const c=xn,f=Sn,h=Je,g=je;return _(),R("div",null,[w(r).layout.value==="side"?(_(),A(g,{key:"side",class:M(s.value)},{default:i(()=>[l(c,null,{default:i(()=>[l(qe)]),_:1}),l(g,null,{default:i(()=>[l(f,null,{default:i(()=>[l(Be)]),_:1}),l(h,null,{default:i(()=>[l(Ee)]),_:1})]),_:1})]),_:1},8,["class"])):(_(),A(g,{key:"no-side"},{default:i(()=>[l(f,null,{default:i(()=>[l(Be)]),_:1}),l(g,{class:M(s.value)},{default:i(()=>[l(qe),l(Ee)]),_:1},8,["class"])]),_:1})),l(al)])}}});export{vl as default};