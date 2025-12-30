import{a$ as z,m as w,C as x,T as m,W as p,K as C,q as c,t as N,b0 as F,b1 as T,w as k}from"./index-ebc513dd.js";import{d as A,b as g,M as u,G as D}from"./vue-51c2f431.js";/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var E={align:{type:String,validator:function(e){return e?["start","end","center","baseline"].includes(e):!0}},breakLine:Boolean,direction:{type:String,default:"horizontal",validator:function(e){return e?["vertical","horizontal"].includes(e):!0}},separator:{type:[String,Function]},size:{type:[String,Number,Array],default:"medium"}};/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */function y(a,e){var t=Object.keys(a);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(a);e&&(r=r.filter(function(d){return Object.getOwnPropertyDescriptor(a,d).enumerable})),t.push.apply(t,r)}return t}function b(a){for(var e=1;e<arguments.length;e++){var t=arguments[e]!=null?arguments[e]:{};e%2?y(Object(t),!0).forEach(function(r){c(a,r,t[r])}):Object.getOwnPropertyDescriptors?Object.defineProperties(a,Object.getOwnPropertyDescriptors(t)):y(Object(t)).forEach(function(r){Object.defineProperty(a,r,Object.getOwnPropertyDescriptor(t,r))})}return a}var O={small:"8px",medium:"16px",large:"24px"},M=z(),_=A({name:"TSpace",props:b(b({},E),{},{forceFlexGapPolyfill:Boolean}),setup:function(e){var t=w("space"),r=N(),d=F(),S=T(),v=g(function(){return e.forceFlexGapPolyfill||M}),P=g(function(){var n="";x(e.size)?n=e.size.map(function(l){return m(l)?"".concat(l,"px"):p(l)&&["small","medium","large"].includes(l)?O[l]:l}).join(" "):p(e.size)?n=["small","medium","large"].includes(e.size)?O[e.size]:e.size:m(e.size)&&(n="".concat(e.size,"px"));var i={};if(v.value){var f=n.split(" "),o=C(f,2),s=o[0],j=o[1];i["--td-space-column-gap"]=s,i["--td-space-row-gap"]=j||s}else i.gap=n;return i});function h(){var n=S(d()),i=r("separator");return n.map(function(f,o){var s=o+1!==n.length&&i;return u(D,null,[u("div",{class:"".concat(t.value,"-item")},[f]),s&&u("div",{class:"".concat(t.value,"-item-separator")},[i])])})}return function(){var n=["".concat(t.value),c(c(c(c({},"".concat(t.value,"-align-").concat(e.align),e.align),"".concat(t.value,"-").concat(e.direction),e.direction),"".concat(t.value,"--break-line"),e.breakLine),"".concat(t.value,"--polyfill"),v.value)];return u("div",{class:n,style:P.value},[h()])}}});/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var J=k(_);export{J as S};
