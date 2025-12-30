import{p as P,m as k,n as x,N as I,K as O,q as t,D as C,W as S,C as D,L,w as R}from"./index-ebc513dd.js";import{d as U,t as Z,b as i,w as j,j as w,M as c}from"./vue-51c2f431.js";/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var q={beforeChange:{type:Function},customValue:{type:Array},disabled:{type:Boolean,default:void 0},label:{type:[Array,Function],default:function(){return[]}},loading:Boolean,size:{type:String,default:"medium",validator:function(e){return e?["small","medium","large"].includes(e):!0}},value:{type:[String,Number,Boolean],default:void 0},modelValue:{type:[String,Number,Boolean],default:void 0},defaultValue:{type:[String,Number,Boolean]},onChange:Function};/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var J=U({name:"TSwitch",props:q,setup:function(e,y){var d=y.slots,o=P(),s=k("switch"),f=x(),u=f.STATUS,m=f.SIZE,g=Z(e),_=g.value,N=g.modelValue,T=I(_,N,e.defaultValue,e.onChange),h=O(T,2),n=h[0],A=h[1],r=i(function(){return e.customValue&&e.customValue.length>0?e.customValue[0]:!0}),E=i(function(){return e.customValue&&e.customValue.length>1?e.customValue[1]:!1});function V(a){var l=n.value===r.value?E.value:r.value;A(l,{e:a})}function M(a){if(!(o.value||e.loading)){if(!e.beforeChange){V(a);return}Promise.resolve(e.beforeChange()).then(function(l){l&&V(a)}).catch(function(l){throw new Error("Switch: some error occurred: ".concat(l))})}}var B=i(function(){return["".concat(s.value),m.value[e.size],t(t(t({},u.value.disabled,o.value),u.value.loading,e.loading),u.value.checked,n.value===r.value||e.modelValue===r.value)]}),z=i(function(){return["".concat(s.value,"__handle"),t(t({},u.value.disabled,o.value),u.value.loading,e.loading)]}),F=i(function(){return["".concat(s.value,"__content"),m.value[e.size],t({},u.value.disabled,o.value)]});j(n,function(a){if(e.customValue&&e.customValue.length&&!e.customValue.includes(a))throw new Error("value is ".concat(a," not in ").concat(JSON.stringify(e.customValue)))},{immediate:!0});var b=i(function(){if(C(e.label))return e.label(w,{value:n.value});if(S(e.label))return e.label;if(D(e.label)&&e.label.length){var a=n.value===r.value?e.label[0]:e.label[1];if(!a)return;if(S(a))return a;if(C(a))return a(w)}return d.label?d.label({value:n.value}):null});return function(){var a,l;return e.loading?l=c(L,{size:"small"},null):b.value&&(a=b.value),c("div",{class:B.value,onClick:M},[c("span",{class:z.value},[l]),c("div",{class:F.value},[a])])}}});/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */var G=R(J);export{G as S};
