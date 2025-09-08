import{h as E,g as J,j as V,n as g,p as w,bz as W,w as z}from"./index-5ae314bf.js";import{I as $}from"./index-cf0f07c9.js";import{d as x,i as X,r as h,b as y,o as k,n as A,J as Z,w as B,M as O,N as K,I as R,F as U}from"./vue-d500b9b9.js";/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var q={alt:{type:String,default:""},content:{type:[String,Function]},default:{type:[String,Function]},hideOnLoadFailed:Boolean,icon:{type:Function},image:{type:String,default:""},imageProps:{type:Object},shape:{type:String,default:"circle",validator:function(a){return a?["circle","round"].includes(a):!0}},size:{type:String,default:""},onError:Function};/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */function _(t,a){var e=Object.keys(t);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);a&&(r=r.filter(function(m){return Object.getOwnPropertyDescriptor(t,m).enumerable})),e.push.apply(e,r)}return e}function C(t){for(var a=1;a<arguments.length;a++){var e=arguments[a]!=null?arguments[a]:{};a%2?_(Object(e),!0).forEach(function(r){g(t,r,e[r])}):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(e)):_(Object(e)).forEach(function(r){Object.defineProperty(t,r,Object.getOwnPropertyDescriptor(e,r))})}return t}var I=x({name:"TAvatar",props:q,setup:function(a){var e=E("avatar"),r=J(),m=w(),b=V(),S=b.SIZE,c=X("avatarGroup",void 0),n=h(null),i=h(null),v=h(!0),p=h(4),j=h(""),s=y(function(){return a.size||(c==null?void 0:c.size)}),P=y(function(){return s.value&&!S.value[s.value]}),F=y(function(){return P.value?{width:s.value,height:s.value,"font-size":"".concat(Number.parseInt(s.value,10)/2,"px")}:{}}),T=y(function(){return P.value?{height:s.value,width:s.value}:{}}),M=y(function(){return{transform:j.value}}),G=function(l){var u,f=l.e,d=a.hideOnLoadFailed;v.value=!d,(u=a.onError)===null||u===void 0||u.call(a,{e:f})},N=function(){var l=n.value,u=i.value,f=l==null?void 0:l.offsetWidth,d=u==null?void 0:u.offsetWidth;p.value*2<f&&(j.value=d>f-p.value*2?"scale(".concat((f-p.value*2)/d,")"):"scale(1)")};return k(function(){A(function(){N()})}),Z(function(){A(function(){N()})}),B(function(){return a.image},function(o){o&&(v.value=!0)}),function(){var o=r("default","content"),l=m("icon"),u=l&&!o,f=a.shape,d=a.image,L=a.alt,D=["".concat(e.value),S.value[s.value],g(g(g({},"".concat(e.value,"--circle"),f==="circle"),"".concat(e.value,"--round"),f==="round"),"".concat(e.value,"__icon"),!!u)];return o=O("span",{ref:i,style:C({},M.value)},[o]),l&&(o=[l,u?"":o]),d&&v.value&&(o=O($,K({style:C({},T.value),src:d,alt:L,onError:G},a.imageProps),null)),O("div",{ref:n,class:D,style:C({},F.value)},[o])}}});/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var H={cascading:{type:String,default:"right-up",validator:function(a){return a?["left-up","right-up"].includes(a):!0}},collapseAvatar:{type:[String,Function]},max:{type:Number},popupProps:{type:Object},size:{type:String,default:""}};/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */function Q(t){return typeof t=="function"||Object.prototype.toString.call(t)==="[object Object]"&&!U(t)}var Y=x({name:"TAvatarGroup",props:H,setup:function(a){R("avatarGroup",a);var e=w(),r=E("avatar"),m=E("avatar-group"),b=function(n){if((n==null?void 0:n.length)>a.max){var i=S(n),v=n.slice(0,a.max);return v.push(O(I,{class:"".concat(r.value,"__collapse"),size:a.size},Q(i)?i:{default:function(){return[i]}})),v}return n},S=function(n){return e("collapseAvatar")||"+".concat(n.length-a.max)};return function(){var c=e("default"),n=a.cascading,i=a.max,v=["".concat(m.value),g(g({},"".concat(r.value,"--offset-right"),n==="right-up"),"".concat(r.value,"--offset-left"),n==="left-up")],p=i&&i>=0?[b(W(c))]:[c];return O("div",{class:v},[p])}}});/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var ra=z(I);z(Y);export{ra as A};
