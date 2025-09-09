import{Y as M,A as z,h as j,G as R,j as G,n as I,p as J,H as V,O as X,w as B}from"./index-1ae915eb.js";import{j as x,d as D,i as Z,b as E,M as a,G as g,N as O,r as K,I as Y}from"./vue-d500b9b9.js";import{i as P}from"./isNil-c75b1b34.js";/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var k={bordered:Boolean,colon:Boolean,column:{type:Number,default:2},contentStyle:{type:Object},itemLayout:{type:String,default:"horizontal",validator:function(r){return r?["horizontal","vertical"].includes(r):!0}},items:{type:Array},labelStyle:{type:Object},layout:{type:String,default:"horizontal",validator:function(r){return r?["horizontal","vertical"].includes(r):!0}},size:{type:String,default:"medium",validator:function(r){return r?["small","medium","large"].includes(r):!0}},tableLayout:{type:String,default:"fixed",validator:function(r){return r?["fixed","auto"].includes(r):!0}},title:{type:[String,Function]}};/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var H=Symbol("TDescriptions");/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var C=function(e){return e.props="props",e.slots="slots",e}(C||{});function A(e){var r=arguments.length>1&&arguments[1]!==void 0?arguments[1]:{};return M(e)?e:z(e)?e(x,r):z(e==null?void 0:e.render)?e.render(x,r):e}function F(e,r,o){var d,y=(d=e.props)===null||d===void 0?void 0:d[r];if(y)return y;var v=e.children,p=(v==null?void 0:v[r])||(v==null?void 0:v[o]);return p?p==null?void 0:p():null}function _(e,r){return e===C.props}/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var q=D({name:"TDescriptionsRow",props:{row:Array,itemType:String},setup:function(r){var o=Z(H),d=j("descriptions"),y=R("descriptions"),v=y.globalConfig,p=E(function(){return o.layout==="horizontal"}),f=E(function(){return o.itemLayout==="horizontal"}),b=function(n){var m=["".concat(d.value,"__label")],i=null,s=null;_(r.itemType)?(i=n.label,s=n.span):(i=F(n,"label"),s=n.props.span);var t=p.value?f.value?1:s:1;return a("td",O({colspan:t,class:m},{style:o.labelStyle}),[i,o.colon&&v.value.colonText])},h=function(n){var m=["".concat(d.value,"__content")],i=null,s=null;_(r.itemType)?(i=n.content,s=n.span):(i=F(n,"content","default"),s=n.props.span);var t=p.value?s>1&&f.value?s*2-1:s:1;return a("td",O({colspan:t,class:m},{style:o.contentStyle}),[i])},T=function(){return a("tr",null,[r.row.map(function(n){return a(g,null,[b(n),h(n)])})])},N=function(){return a(g,null,[a("tr",null,[r.row.map(function(n){return b(n)})]),a("tr",null,[r.row.map(function(n){return h(n)})])])},u=function(){return a(g,null,[r.row.map(function(n){return a("tr",null,[b(n),h(n)])})])},S=function(){return a(g,null,[r.row.map(function(n){return a(g,null,[a("tr",null,[b(n)]),a("tr",null,[h(n)])])})])};return function(){return a(g,null,[p.value?f.value?T():N():f.value?u():S()])}}});/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var Q=D({name:"TDescriptions",props:k,setup:function(r){var o=j("descriptions"),d=G(),y=d.SIZE,v=X(),p=J(),f=K(C.props),b=function(){var u=r.column,S=r.layout,c=[];if(V(r.items))c=r.items.map(function(t){return{label:A(t.label),content:A(t.content),span:t.span||1}}),f.value=C.props;else{var n=v("TDescriptionsItem");n.length!==0&&(c=n,f.value=C.slots)}if(S==="vertical")return[c];var m=[],i=u,s=[];return c.forEach(function(t,L){var l=1;if(_(f.value))l=P(t.span)?l:t.span,l=l>u?u:l;else{var w;t.props=t.props||{},l=P((w=t.props)===null||w===void 0?void 0:w.span)?l:t.props.span,l=l>u?u:l,t.props.span=l}i>=l?(m.push(t),i-=l):(s.push(m),m=[t],i=u-l),L===c.length-1&&(_(f.value)?t.span+=i:t.props.span+=i,s.push(m))}),s};Y(H,r);var h=function(){var u=["".concat(o.value,"__body"),y.value[r.size],I({},"".concat(o.value,"__body--fixed"),r.tableLayout==="fixed"),I({},"".concat(o.value,"__body--border"),r.bordered)];return a("table",{class:u},[a("tbody",null,[b().map(function(S){return a(q,{"item-type":f.value,row:S},null)})])])},T=function(){var u=p("title");return u?a("div",{class:"".concat(o.value,"__header")},[u]):""};return function(){return a("div",{class:o.value},[T(),h()])}}});/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var U={content:{type:[String,Function]},default:{type:[String,Function]},label:{type:[String,Function]},span:{type:Number,default:1}};/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var W=D({name:"TDescriptionsItem",props:U});/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var er=B(Q),tr=B(W);export{tr as D,er as a};
