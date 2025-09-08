import{h as N,n as i,p as _,Y as c,V as A,A as S,w as g}from"./index-5ae314bf.js";import{d as h,j as d,M as p}from"./vue-d500b9b9.js";/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var x={append:{type:[String,Function]},prepend:{type:[String,Function]}};/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var I=h({name:"TInputAdornment",props:x,setup:function(u,v){var a=v.slots,t=N("input-adornment"),f=_(),o=function(s,n,e){var r,m=c(e)||A(e);return!a[n]&&c(e)&&!e?null:(a[n]?a[n](null).length===1&&typeof a[n](null)[0].children=="string"?r=p("span",{class:"".concat(t.value,"__text")},[a[n](null)]):r=a[n](null):S(e)?r=e(s):r=m?p("span",{class:"".concat(t.value,"__text")},[e]):e,r&&p("span",{class:"".concat(t.value,"__").concat(n)},[r]))};return function(){var l=o(d,"prepend",u.prepend),s=o(d,"append",u.append),n=f("default")||[null],e=[t.value,i(i({},"".concat(t.value,"--prepend"),l),"".concat(t.value,"--append"),s)];return!l&&!s?n[0]:p("div",{class:e},[l,n[0],s])}}});/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var M=g(I);export{M as I};
