/**
 * tdesign v1.16.1
 * (c) 2025 tdesign
 * @license MIT
 */function l(r,o){if(r==null)return{};var e={};for(var t in r)if({}.hasOwnProperty.call(r,t)){if(o.indexOf(t)!==-1)continue;e[t]=r[t]}return e}function u(r,o){if(r==null)return{};var e,t,i=l(r,o);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(r);for(t=0;t<n.length;t++)e=n[t],o.indexOf(e)===-1&&{}.propertyIsEnumerable.call(r,e)&&(i[e]=r[e])}return i}export{u as _};
