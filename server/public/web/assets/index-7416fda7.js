import{m as s,l as v,q as r,w as f}from"./index-ebc513dd.js";import{d as h,M as i}from"./vue-51c2f431.js";/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var p={align:{type:String,default:"center",validator:function(t){return t?["left","right","center"].includes(t):!0}},content:{type:[String,Function]},dashed:Boolean,default:{type:[String,Function]},layout:{type:String,default:"horizontal",validator:function(t){return t?["horizontal","vertical"].includes(t):!0}},theme:{type:String,validator:function(t){return t?["horizontal","vertical"].includes(t):!0}}};/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var g=h({name:"TDivider",props:p,setup:function(t){var e=s("divider"),o=v();return function(){var u=t.layout,c=t.dashed,l=t.align,n=o("default","content"),d=["".concat(e.value),["".concat(e.value,"--").concat(u)],r(r(r({},"".concat(e.value,"--dashed"),!!c),"".concat(e.value,"--with-text"),!!n),"".concat(e.value,"--with-text-").concat(l),!!n)];return i("div",{class:d},[n&&i("span",{class:"".concat(e.value,"__inner-text")},[n])])}}});/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var x=f(g);export{x as D};
