import{m as F,W as D,t as N,b1 as b,w as q}from"./index-ebc513dd.js";import{B as A}from"./index-3b3d7414.js";import{d as O,b as j,M as t,F as x}from"./vue-51c2f431.js";/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var T={actions:{type:Array},author:{type:[String,Function]},avatar:{type:[String,Object,Function]},content:{type:[String,Function]},datetime:{type:[String,Function]},quote:{type:[String,Function]},reply:{type:[String,Function]}};/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */function w(n){return typeof n=="function"||Object.prototype.toString.call(n)==="[object Object]"&&!x(n)}var M=O({name:"TComment",props:T,setup:function(){var a=F("comment"),e=N(),v=b();return function(){var s=e("reply"),o=e("author"),c=e("datetime"),u=e("quote"),i=e("actions"),m=e("content"),r=e("avatar"),p=j(function(){return o||c}),d=s?t("div",{class:"".concat(a.value,"__reply")},[s]):null,_=u?t("div",{class:"".concat(a.value,"__quote")},[u]):null,f=r?t("div",{class:"".concat(a.value,"__avatar")},[D(r)?t("img",{src:r,alt:"",class:"".concat(a.value,"__avatar-image")},null):r]):null,y=p.value&&t("div",{class:"".concat(a.value,"__author")},[o&&t("span",{class:"".concat(a.value,"__name")},[o]),c&&t("span",{class:"".concat(a.value,"__time")},[c])]),g=function(){if(!i||!i.length)return null;var S=v(i);return t("div",{class:"".concat(a.value,"__actions")},[S.map(function(l,C){return t(A,{key:"action-".concat(C),size:"small",variant:"text"},w(l)?l:{default:function(){return[l]}})})])},h=t("div",{class:"".concat(a.value,"__content")},[y,t("div",{class:"".concat(a.value,"__detail")},[m]),_,g()]);return t("div",{class:a.value},[t("div",{class:"".concat(a.value,"__inner")},[f,h]),d])}}});/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var X=q(M);export{X as C};
