import{r as n}from"./index-c2dd6a24.js";function r(o){return n.post({url:"/shop",params:o})}function e(o){return n.post({url:"/shop/index/getGoodsListJson",params:o})}function s(o){return n.post({url:"/home/pay/order",params:o})}function u(o){return`${window.location.origin}/home/pay/pay?trade_no=${o.trade_no}`}function a(o){return n.post({url:"/shop/index/getCouponInfo",params:o})}export{a,e as b,s as c,u as d,r as g};