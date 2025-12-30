import{m as N,q as i,t as _,W as c,T as A,D as S,w as g}from"./index-ebc513dd.js";import{d as x,j as d,M as u}from"./vue-51c2f431.js";/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var I={append:{type:[String,Function]},prepend:{type:[String,Function]}};/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var T=x({name:"TInputAdornment",props:I,setup:function(p,v){var a=v.slots,t=N("input-adornment"),f=_(),o=function(s,e,n){var r,m=c(n)||A(n);return!a[e]&&c(n)&&!n?null:(a[e]?a[e](null).length===1&&typeof a[e](null)[0].children=="string"?r=u("span",{class:"".concat(t.value,"__text")},[a[e](null)]):r=a[e](null):S(n)?r=n(s):r=m?u("span",{class:"".concat(t.value,"__text")},[n]):n,r&&u("span",{class:"".concat(t.value,"__").concat(e)},[r]))};return function(){var l=o(d,"prepend",p.prepend),s=o(d,"append",p.append),e=f("default")||[null],n=[t.value,i(i({},"".concat(t.value,"--prepend"),l),"".concat(t.value,"--append"),s)];return!l&&!s?e[0]:u("div",{class:n},[l,e[0],s])}}});/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var M=g(T);export{M as I};
