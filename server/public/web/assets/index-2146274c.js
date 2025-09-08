import{bA as A,aX as m,n as i,V as b,ak as y,H as O,I as d,h as w,p as C,w as S}from"./index-6b6fbd51.js";import{r as M,d as P,t as T,I as $,A as E,b as j,M as h,F as R,i as I}from"./vue-d500b9b9.js";/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var G={align:{type:String,default:"top",validator:function(e){return e?["start","end","center","stretch","baseline","top","middle","bottom"].includes(e):!0}},gutter:{type:[Number,Object,Array],default:0},justify:{type:String,default:"start",validator:function(e){return e?["start","end","center","space-around","space-between"].includes(e):!0}},tag:{type:String,default:"div"}};/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var N=function(e){var n="xs";return e<768?n="xs":e>=768&&e<992?n="sm":e>=992&&e<1200?n="md":e>=1200&&e<1400?n="lg":e>=1400&&e<1880?n="xl":n="xxl",n};function _(){var t=M(N(m?0:window.innerWidth)),e=function(){t.value=N(m?0:window.innerWidth)};return A("resize",e),t}/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */function x(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var o=Object.getOwnPropertySymbols(t);e&&(o=o.filter(function(c){return Object.getOwnPropertyDescriptor(t,c).enumerable})),n.push.apply(n,o)}return n}function g(t){for(var e=1;e<arguments.length;e++){var n=arguments[e]!=null?arguments[e]:{};e%2?x(Object(n),!0).forEach(function(o){i(t,o,n[o])}):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):x(Object(n)).forEach(function(o){Object.defineProperty(t,o,Object.getOwnPropertyDescriptor(n,o))})}return t}function k(t,e){var n=e.justify,o=e.align;return[t,i(i({},"".concat(t,"--").concat(n),n),"".concat(t,"--align-").concat(o),o)]}function D(t,e){var n={},o=function(a){return Object.assign(n,{marginLeft:"".concat(a/-2,"px"),marginRight:"".concat(a/-2,"px")})},c=function(a){return Object.assign(n,{rowGap:"".concat(a,"px")})},s={isNumber:function(a){b(a)&&o(a)},isArray:function(a){O(a)&&a.length&&(s.isNumber(a[0]),b(a[1])&&c(a[1]),d(a[0])&&!y(a[0][e])&&o(a[0][e]),d(a[1])&&!y(a[1][e])&&c(a[1][e]))},isObject:function(a){d(a)&&a[e]&&(O(a)&&a.length?(o(a[e][0]),c(a[e][1])):o(a[e]))}};return Object.keys(s).forEach(function(r){s[r](t)}),n}function X(t){return b(t)?"".concat(t," ").concat(t," 0"):/^\d+(\.\d+)?(px|r?em|%)$/.test(t)?"0 0 ".concat(t):t}function J(t,e){var n={},o=function(r){return Object.assign(n,{paddingLeft:"".concat(r/2,"px"),paddingRight:"".concat(r/2,"px")})},c={isNumber:function(r){b(r)&&o(r)},isArray:function(r){O(r)&&r.length&&(b(r[0])&&o(r[0]),d(r[0])&&r[0][e]&&o(r[0][e]))},isObject:function(r){d(r)&&!O(r)&&r[e]&&o(r[e])}};return Object.keys(c).forEach(function(s){c[s](t)}),n}function L(t,e){var n=e.span,o=e.order,c=e.offset,s=e.push,r=e.pull,a=["xs","sm","md","lg","xl","xxl"],u=a.reduce(function(p,f){var v=e[f],l={};return b(v)?l.span=v:d(v)&&(l=v||{}),g(g({},p),{},i(i(i(i(i({},"".concat(t,"-").concat(f,"-").concat(l.span),!y(l.span)),"".concat(t,"-").concat(f,"-order-").concat(l.order),parseInt(l.order,10)>=0),"".concat(t,"-").concat(f,"-offset-").concat(l.offset),parseInt(l.offset,10)>=0),"".concat(t,"-").concat(f,"-push-").concat(l.push),parseInt(l.push,10)>=0),"".concat(t,"-").concat(f,"-pull-").concat(l.pull),parseInt(l.pull,10)>=0))},{});return g(i(i(i(i(i(i({},"".concat(t),!0),"".concat(t,"-").concat(n),!y(n)),"".concat(t,"-order-").concat(o),o),"".concat(t,"-offset-").concat(c),c),"".concat(t,"-push-").concat(s),s),"".concat(t,"-pull-").concat(r),r),u)}/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */function V(t){return typeof t=="function"||Object.prototype.toString.call(t)==="[object Object]"&&!R(t)}var F=P({name:"TRow",props:G,setup:function(e){var n=T(e),o=n.gutter,c=C();$("rowContext",E({gutter:o}));var s=_(),r=w("row"),a=j(function(){return k(r.value,e)}),u=j(function(){return D(e.gutter,s.value)});return function(){var p,f=e.tag;return h(f,{class:a.value,style:u.value},V(p=c("default"))?p:{default:function(){return[p]}})}}});/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var W={flex:{type:[String,Number]},lg:{type:[Number,Object]},md:{type:[Number,Object]},offset:{type:Number,default:0},order:{type:Number,default:0},pull:{type:Number,default:0},push:{type:Number,default:0},sm:{type:[Number,Object]},span:{type:Number},tag:{type:String,default:"div"},xl:{type:[Number,Object]},xs:{type:[Number,Object]},xxl:{type:[Number,Object]}};/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */function H(t){return typeof t=="function"||Object.prototype.toString.call(t)==="[object Object]"&&!R(t)}var K=P({name:"TCol",inject:["rowContext"],props:W,setup:function(e){var n=w("col"),o=C(),c=I("rowContext",Object.create(null)),s=_(),r=j(function(){return L(n.value,e)}),a=j(function(){var u={},p=e.flex;if(p&&(u.flex=X(p)),c){var f=c.gutter;Object.assign(u,J(f,s.value))}return u});return function(){var u,p=e.tag;return h(p,{class:r.value,style:a.value},H(u=o("default"))?u:{default:function(){return[u]}})}}});/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var B=S(F),Q=S(K);export{Q as C,B as R};
