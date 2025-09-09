import{g as y,h as k,j as p,G as _,m as N,n as i,o as T,p as w,w as I}from"./index-1ae915eb.js";import{d as b,b as P,M as l}from"./vue-d500b9b9.js";/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var F={content:{type:[String,Function]},default:{type:[String,Function]},disabled:{type:Boolean,default:void 0},download:{type:[String,Boolean]},hover:{type:String,default:"underline",validator:function(e){return e?["color","underline"].includes(e):!0}},href:{type:String,default:""},prefixIcon:{type:Function},size:{type:String,default:"medium",validator:function(e){return e?["small","medium","large"].includes(e):!0}},suffixIcon:{type:Function},target:{type:String,default:""},theme:{type:String,default:"default",validator:function(e){return e?["default","primary","danger","warning","success"].includes(e):!0}},underline:Boolean,onClick:Function};/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var A=b({name:"TLink",props:F,emits:["click"],setup:function(e,d){var f=d.emit,v=y(),u=w(),n=k("link"),o=p(),m=o.STATUS,g=o.SIZE,C=_("classPrefix"),S=C.classPrefix,a=N(),h=P(function(){return["".concat(n.value),"".concat(n.value,"--theme-").concat(e.theme),i(i(i(i({},g.value[e.size],e.size!=="medium"),m.value.disabled,a.value),"".concat(S.value,"-is-underline"),e.underline),"".concat(n.value,"--hover-").concat(e.hover),!a.value)]}),x=function(t){a.value||f("click",t)};return function(){var s=v("default","content"),t=u("prefixIcon"),c=u("suffixIcon");return l("a",{class:T(h.value),href:a.value||!e.href?void 0:e.href,target:e.target?e.target:void 0,download:e.download?e.download:void 0,onClick:x},[t?l("span",{class:"".concat(n.value,"__prefix-icon")},[t]):null,s,c?l("span",{class:"".concat(n.value,"__suffix-icon")},[c]):null])}}});/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var z=I(A);export{z as L};
