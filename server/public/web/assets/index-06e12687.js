import{W as H,D as z,m as B,G as R,n as G,q as I,t as J,C as V,E as X,w as L}from"./index-ebc513dd.js";import{j as x,d as D,i as Z,b as E,M as a,G as h,N as P,r as q,I as K}from"./vue-51c2f431.js";import{i as F}from"./isNil-c75b1b34.js";/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var W={bordered:Boolean,colon:Boolean,column:{type:Number,default:2},contentStyle:{type:Object},itemLayout:{type:String,default:"horizontal",validator:function(r){return r?["horizontal","vertical"].includes(r):!0}},items:{type:Array},labelStyle:{type:Object},layout:{type:String,default:"horizontal",validator:function(r){return r?["horizontal","vertical"].includes(r):!0}},size:{type:String,default:"medium",validator:function(r){return r?["small","medium","large"].includes(r):!0}},tableLayout:{type:String,default:"fixed",validator:function(r){return r?["fixed","auto"].includes(r):!0}},title:{type:[String,Function]}};/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var M=Symbol("TDescriptions");/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var C=function(t){return t.props="props",t.slots="slots",t}(C||{});function O(t){var r=arguments.length>1&&arguments[1]!==void 0?arguments[1]:{};return H(t)?t:z(t)?t(x,r):z(t==null?void 0:t.render)?t.render(x,r):t}function A(t,r,o){var d,y=(d=t.props)===null||d===void 0?void 0:d[r];if(y)return y;var v=t.children,p=(v==null?void 0:v[r])||(v==null?void 0:v[o]);return p?p==null?void 0:p():null}function _(t,r){return t===C.props}/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var k=D({name:"TDescriptionsRow",props:{row:Array,itemType:String},setup:function(r){var o=Z(M),d=B("descriptions"),y=R("descriptions"),v=y.globalConfig,p=E(function(){return o.layout==="horizontal"}),f=E(function(){return o.itemLayout==="horizontal"}),b=function(n){var m=["".concat(d.value,"__label")],i=null,s=null;_(r.itemType)?(i=n.label,s=n.span):(i=A(n,"label"),s=n.props.span);var e=p.value?f.value?1:s:1;return a("td",P({colspan:e,class:m},{style:o.labelStyle}),[i,o.colon&&v.value.colonText])},g=function(n){var m=["".concat(d.value,"__content")],i=null,s=null;_(r.itemType)?(i=n.content,s=n.span):(i=A(n,"content","default"),s=n.props.span);var e=p.value?s>1&&f.value?s*2-1:s:1;return a("td",P({colspan:e,class:m},{style:o.contentStyle}),[i])},T=function(){return a("tr",null,[r.row.map(function(n){return a(h,null,[b(n),g(n)])})])},N=function(){return a(h,null,[a("tr",null,[r.row.map(function(n){return b(n)})]),a("tr",null,[r.row.map(function(n){return g(n)})])])},u=function(){return a(h,null,[r.row.map(function(n){return a("tr",null,[b(n),g(n)])})])},S=function(){return a(h,null,[r.row.map(function(n){return a(h,null,[a("tr",null,[b(n)]),a("tr",null,[g(n)])])})])};return function(){return a(h,null,[p.value?f.value?T():N():f.value?u():S()])}}});/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var Q=D({name:"TDescriptions",props:W,setup:function(r){var o=B("descriptions"),d=G(),y=d.SIZE,v=X(),p=J(),f=q(C.props),b=function(){var u=r.column,S=r.layout,c=[];if(V(r.items))c=r.items.map(function(e){return{label:O(e.label),content:O(e.content),span:e.span||1}}),f.value=C.props;else{var n=v("TDescriptionsItem");n.length!==0&&(c=n,f.value=C.slots)}if(S==="vertical")return[c];var m=[],i=u,s=[];return c.forEach(function(e,j){var l=1;if(_(f.value))l=F(e.span)?l:e.span,l=l>u?u:l;else{var w;e.props=e.props||{},l=F((w=e.props)===null||w===void 0?void 0:w.span)?l:e.props.span,l=l>u?u:l,e.props.span=l}i>=l?(m.push(e),i-=l):(s.push(m),m=[e],i=u-l),j===c.length-1&&(_(f.value)?e.span+=i:e.props.span+=i,s.push(m))}),s};K(M,r);var g=function(){var u=["".concat(o.value,"__body"),y.value[r.size],I({},"".concat(o.value,"__body--fixed"),r.tableLayout==="fixed"),I({},"".concat(o.value,"__body--border"),r.bordered)];return a("table",{class:u},[a("tbody",null,[b().map(function(S){return a(k,{"item-type":f.value,row:S},null)})])])},T=function(){var u=p("title");return u?a("div",{class:"".concat(o.value,"__header")},[u]):""};return function(){return a("div",{class:o.value},[T(),g()])}}});/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var U={content:{type:[String,Function]},default:{type:[String,Function]},label:{type:[String,Function]},span:{type:Number,default:1}};/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var Y=D({name:"TDescriptionsItem",props:U});/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var tr=L(Q),er=L(Y);export{er as D,tr as a};
