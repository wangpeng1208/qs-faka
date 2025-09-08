import{aZ as z,h as w,H as x,V as p,Y as m,C,n as c,p as N,a_ as F,a$ as T,w as _}from"./index-5ae314bf.js";import{d as k,b as g,M as u,G as A}from"./vue-d500b9b9.js";/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var D={align:{type:String,validator:function(e){return e?["start","end","center","baseline"].includes(e):!0}},breakLine:Boolean,direction:{type:String,default:"horizontal",validator:function(e){return e?["vertical","horizontal"].includes(e):!0}},separator:{type:[String,Function]},size:{type:[String,Number,Array],default:"medium"}};/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */function y(t,e){var a=Object.keys(t);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);e&&(r=r.filter(function(d){return Object.getOwnPropertyDescriptor(t,d).enumerable})),a.push.apply(a,r)}return a}function b(t){for(var e=1;e<arguments.length;e++){var a=arguments[e]!=null?arguments[e]:{};e%2?y(Object(a),!0).forEach(function(r){c(t,r,a[r])}):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(a)):y(Object(a)).forEach(function(r){Object.defineProperty(t,r,Object.getOwnPropertyDescriptor(a,r))})}return t}var O={small:"8px",medium:"16px",large:"24px"},E=z(),M=k({name:"TSpace",props:b(b({},D),{},{forceFlexGapPolyfill:Boolean}),setup:function(e){var a=w("space"),r=N(),d=F(),S=T(),v=g(function(){return e.forceFlexGapPolyfill||E}),h=g(function(){var n="";x(e.size)?n=e.size.map(function(l){return p(l)?"".concat(l,"px"):m(l)&&["small","medium","large"].includes(l)?O[l]:l}).join(" "):m(e.size)?n=["small","medium","large"].includes(e.size)?O[e.size]:e.size:p(e.size)&&(n="".concat(e.size,"px"));var i={};if(v.value){var f=n.split(" "),o=C(f,2),s=o[0],j=o[1];i["--td-space-column-gap"]=s,i["--td-space-row-gap"]=j||s}else i.gap=n;return i});function P(){var n=S(d()),i=r("separator");return n.map(function(f,o){var s=o+1!==n.length&&i;return u(A,null,[u("div",{class:"".concat(a.value,"-item")},[f]),s&&u("div",{class:"".concat(a.value,"-item-separator")},[i])])})}return function(){var n=["".concat(a.value),c(c(c(c({},"".concat(a.value,"-align-").concat(e.align),e.align),"".concat(a.value,"-").concat(e.direction),e.direction),"".concat(a.value,"--break-line"),e.breakLine),"".concat(a.value,"--polyfill"),v.value)];return u("div",{class:n,style:h.value},[P()])}}});/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var J=_(M);export{J as S};
