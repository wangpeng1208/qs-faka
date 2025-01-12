import{b as Ie}from"./base-847c52cc.js";import{c as ke,a as Re,b as Ce}from"./shop-aaa0fa90.js";import{b as De,_ as Se}from"./index-c2dd6a24.js";import Ne from"./Header-885de9ff.js";import Ue from"./OrderDialog-c3be5cce.js";import{P as l,Q as c,a7 as e,e as xe,d as ee,r,t as Qe,l as f,w as j,f as i,a4 as u,I as J,F as S,aa as N,a9 as g,a3 as U,ab as d,H as F,n as Me,ac as Ve,ad as Ee,a5 as K}from"./vue-bf422dc1.js";import{M as h,p as ze,w as Le,I as Fe,F as Be,a1 as Ze,W as Ge,e as Ye,b as He,h as Te,B as je,S as Je,N as Ke,v as We}from"./ui-ba7aaa7e.js";import"./libs-51817cd7.js";import"./plugins-ca970193.js";import"./others-9f318174.js";import"./echarts-bf9d612c.js";import"./icons-a8498fb6.js";import"./index-b02b5348.js";import"./date-20546ee0.js";const qe="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADQAAAAzCAYAAADYfStTAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyFpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTQyIDc5LjE2MDkyNCwgMjAxNy8wNy8xMy0wMTowNjozOSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpFQTBERUY0RjU0RjMxMUU5QjQ3MEU0Njc2QjREODc5MyIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpFQTBERUY1MDU0RjMxMUU5QjQ3MEU0Njc2QjREODc5MyI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOkVBMERFRjRENTRGMzExRTlCNDcwRTQ2NzZCNEQ4NzkzIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOkVBMERFRjRFNTRGMzExRTlCNDcwRTQ2NzZCNEQ4NzkzIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+YsrVHwAABMNJREFUeNrkmgtv3EQUhe3x7CZtXm2TSCzQhwglhQIS/P9fgUBJStMWKKS0gTZN06YbP7hXfINGlsfxrr3eJox0tFHWHt8z99zHzDouiiLqaAwFi4IVwZLgqmBBMBAYrskFZ4L3greCE8Gx4FQw7sKIuCUhNfSaYB0s65yCppO6a98I/gKvIN4rISWyKfiYz4SVz1ssjHoyE7wQ/MFn3gehDcEdPGKQSle6jZFujreeCA5nRUgf9LlgxN9dEgkR02ccCB42jbGmhK4LtomXDPQxEqBxtSd42QWhjwT3yFjpDL1S560EDz0gvqYmpEH/JZPmPZJIiU9TShxq7K7g97rsEhojyEQ9kxlTw5KSGpwN97BtIkLr3Gh6lFhB6ldjvxPc4n9F6RqDbetNCV0hAQx7Cv7Ck5hm0a/pNm5R48rqyLBtG1vPJaSTrvGQWY+c5yiBrwSfEa/aGlnBFm1UWhFja9haS2gEzhpILWtRi2IvY2oW/QZv+CUhpZW663URVfIchQhZ3GwaJIEzHrJeofMmZN5zv67wfaSTVcyTemWjqEgSBpttFSG98UaDipwiA9X695AaTxAv2lmvCr5FUnUlwdWfY/6uyog3sP0/r0Ss1ifneKbg+00MWcOYbbYCb5inTqIFte0LFiUkWVdMlcjP9HUJ/6+KQ7X9T1WOI3SN9mZcQ0YnvC24Sdfgrl3CwJ+QYlJxr8tMd7g/QXYhrxR0BI9YLBsg4+R/HQ4vDBdu1MRBznd3vQA9K7l9A7Jl+eSQWUWiNz0jQg1pild2keeghoy/aGpDbJlkoyZNu4x0XCPJDGNPaEuc9mMktoVXs5oCP6QJ3aUJNYG4CcW1chhaJLNY87AYl/9KNrrtea1cwbeQyHPaly2v4ofmt9z7G9uEt5CbtDgrhyWLHIoGqdag6SUyS1YhzUVScUK8bLJ6WU28qPz2BU+ZY2HK2qb3rGq3fZ/ilDd07QqF8ErFPbFHbliz3XAL9IpFclnMtDzfODCsatNhiaV9DI0rVslf+SLgFUOs/QgZ25KMG4t2ChcnxMgyMZJWxFPIKwPS9T6E8nNq16SSW7ATZJKyrJ5AalRTU8qnOn97hXLgtyxdbdmndbUlLe+RJFYgFQfIxCzAY2rLtIF/7mKbaLrdaMEKa93Z8QpgKIvtUF/GXDerTWNmWm7ihsjnsdf9+hLTLPYDNcZMIe+JCVmkcrXFvmaAwSq9TzE6pxA/8rYK8YzJxK45Pe1gohgvLVOf9mku4w6zWJNxaomDtsMQK7t46GXPRNw4UUKvO5JDzJ6omBMZff5rg4dOOyKVzKC2NCWjHE7crweHczKkq2HhMHYHiYcd9VLzGgYOhSNxNMdAbjsG2H7kn/qM2Y+YC+qdp+6MwyfwjOZxeIHIDLH5WdW5XEp1zy+Ip4zXkaRVhHQcgD5albZpeuDZG4UIRRxUHH3gadxi48Mqt5XHO/Y54x6642mLt9uLvWtCKGJLsBc4N5i31NSmB9gYNSUU0S3vNLiuzyQQYVPwN9b/3a/gblyq9xT8InZp3iTxhx7v6vl2H+/6/BL9+xJT8wk+0Lex1CvPo57exiobcinelwvFmHujcZmTJHc66gp0RqZUb7qfMTt9o/EfAQYA3ZeeseefkFEAAAAASUVORK5CYII=",te="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAVCAYAAABc6S4mAAABo0lEQVQ4jbXUP0gcURDH8TOgTbAQi3QK1hbCvNPgn0KEQBqxUAK2aZzZiyKKIoJuSGmKIIiIjQqCRZprBCEWSSESAiEQSMCkUJRACkEL/6H3tVgip7e3t56bhR8sPN6HeTNvN5X6Dw9QIcbbPp+qxHFZoNIpK6LQrtQkij8b5bFT1kVBFGSIusTwZo9aMbZvcAU3SGMieKtHvRg/8nFREI+WB+NukEZR9gtwhbRH14NwMdpFOQzDRcFl6C6/8gzdzjgphouCZOgvDzdeOuUyEg9moOXgk6LkSuIKaWM0Nuz7PHIes3HgmxkYfiy8z6fKGWv3wUVBjJmSeNsY1c74EFEl2S2YXg5dm4/EW4Z4IsqXqCrnsgDw/lPo+mpRPK00iLFzd9OLN+DNBu/ji5DLweef8PRVyAmUbDhuNDnjT1jFX3/B5RUsbcDpOez9hc6RoifcLMDF6HTGUbGWPJ+AnYOgLccn0DMVOeTtW7gzesU4K3U7Oobh4zcYeFfymn7Pb4vF+jrvl92gLR6vE4b/5TAlyrhTft+KsSfBX7IwMVqYl4tr5HDZyKPmZr8AAAAASUVORK5CYII=",Pe={xmlns:"http://www.w3.org/2000/svg",width:"28",height:"28",class:"icon",viewBox:"0 0 1024 1024"},Oe=e("path",{fill:"#2F8AF5",d:"M847.872 734.208 784.384 368.64H239.616l-63.488 365.568c-9.216 51.2 30.72 105.472 81.92 105.472h506.88c52.224 0 92.16-54.272 82.944-105.472zM512 648.192c-71.68 0-130.048-58.368-130.048-130.048 0-6.144 4.096-10.24 10.24-10.24s10.24 4.096 10.24 10.24c0 60.416 49.152 109.568 109.568 109.568s109.568-49.152 109.568-109.568c0-6.144 4.096-10.24 10.24-10.24s10.24 4.096 10.24 10.24c0 71.68-58.368 130.048-130.048 130.048z"},null,-1),Xe=e("path",{fill:"#83C1FF",d:"m791.552 358.4-19.456-96.256c-7.168-39.936-46.08-67.584-87.04-67.584H340.992c-40.96 0-74.752 28.672-81.92 68.608l-15.36 95.232h547.84z"},null,-1),$e=[Oe,Xe];function et(b,B){return l(),c("svg",Pe,[...$e])}const tt={render:et},ot="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB0AAAAaCAYAAABLlle3AAADt0lEQVR4XrWWX2hcRRTGf2fu3XSTpqEbK5qmtAhqxaBKDagFpVAJ2LwIWAUriFgVVUFELKAKVfBRX1RAQEC0BMFH0RcLJQj4IraIapWoaZptUrKJxqb7584cQ5hhNnu5u1Twg8MZuLPz2+98c9mVO55RANLb6gBkp8v0FkKUcoUyXJkEMMme5liyp/WhGclG/Rnyf0HFAxKMfIDjKOhxIPFQ+a9Q6QFNkl2tu1DuUQWQR2S7G43gQkkO6rMMeUoXlymJHlMLuI0qS6IvAWkXt1LkVACT3lp/dr1eBJKYVXRpRrM7UZlkAyjgAHhK+t0u7zYfBbwKHG4/z2zaIDyP8E56S/3dAI5FIqm+gQIqhK6OLaT6Sm6/MAhMAW8BR9qzN9ExKcq3KAAvpDc3PvHgxGd5ryoH1AG+1II6QOUJ6dMRP+bE9y+BBwGAH6IJ79RXipUL4EenPJTsbXwElIA+DI8Fd6JgLaw1QFRAEYw+CpQwWsHwBcp+ov70uZtcpppxHgUUdKPLkeS65nvmansjMBFydJnQbAqTtwvXDkG9AagcxuhuhBMoB9mspcCK0ABuyQJOPNCPER6XAXdSLcM4EIXFFTi0Dnz4bsP8EqQiqDKGMI3KQZR2NYGLgEQocYs2zAJKA4VYAsoQKhhgZRV2VuC5CcMv5+GPBRAFAUFlGEenasB84AQowZf+bebVsYxKfCUcqHd4uQ5ZJrz2gGH3Djj9u1IZEFIDagElJ+/yUrDQCVVdNf/gWIou46idhbU6HD1gmNwnzNfg/n3w2THh0LiwuCxF0HPhvgdOGhbhAY45YAwHsYTlVZgYMzx9n3BhBdaaMH6DIMBMVelLhAJVPTDnNIKtmQsg9R0LAyWhWoOXP3Y8+b7j51kYLMObJ5ST3wuVQYo0G6H526ve6ay/PO21DoXfqvDVd/DTLIxcBd/8CJ9PC5WtgHaFajenqi3mcESXvlsL5RS2lmD8+g0Qb08p1kJ/qRuTc72dtmRG869MKAywdydMnVLOzMDwNnDFxJqHds/UXUzP0uJTrHfZ4XpbWTh1hvWxwo4hwVCoS8Bx4K9OpylRDrBAy1VLr8t2Oy3CflVuwso1OPpxkhowtVWMqEhfgqojC58DFoEZ4CzwNfArhOcRHP6YASRACdgCDAD9fp3mfls3Szun5b9AA7gMrPl15sE5pxkgvhzQBEoRmgOSAwZoBLe6jVcjGPU9/D5KbyhEKNaXH20RNIJte75Fo+054gCKnW5QDePNwQozzZ8R13n9Cx1eymjGjLG7AAAAAElFTkSuQmCC",_=b=>(Ve("data-v-4e72045e"),b=b(),Ee(),b),st={style:{width:"100%",background:"url(http://www.kuaifaka.com/static/img/back.f6b9993.png)","background-size":"100%","min-height":"100vh",position:"relative","padding-bottom":"10px"}},at={class:"container"},nt={class:"row category"},lt={class:"title"},it=["src"],ct=_(()=>e("span",{style:{"margin-bottom":"2px","font-size":"16px","font-weight":"700","margin-left":"5px",display:"inline-block","vertical-align":"bottom"}},"商品分类",-1)),dt=["onClick"],rt={class:"card"},ut={class:"card__s_cateremark"},_t=_(()=>e("img",{class:"lite_img",src:qe},null,-1)),pt={key:0},mt={class:"row goods"},gt={class:"title"},ht=_(()=>e("span",{style:{"margin-bottom":"2px","font-size":"16px","font-weight":"700","margin-left":"5px",display:"inline-block","vertical-align":"bottom"}},"选择商品",-1)),vt={class:"card"},yt={class:"row"},At={class:"col-md-12"},ft={class:"card__wrap"},bt={class:"card__detail"},wt={class:"card__detail"},It={class:"card__detail_price"},kt={class:"card__detail"},Rt={class:"card__detail_stock"},Ct=_(()=>e("img",{class:"lite_img",src:te,alt:""},null,-1)),Dt={class:"row"},St=_(()=>e("div",{class:"title"},"商品描述",-1)),Nt=["innerHTML"],Ut={key:0,class:"row"},xt=_(()=>e("h4",{class:"title"},"满减优惠",-1)),Qt={class:"content"},Mt={key:1,class:"row"},Vt=_(()=>e("h4",{class:"title"},"活动赠送",-1)),Et={class:"content"},zt={key:2,class:"row"},Lt=_(()=>e("h4",{class:"title"},"附加赠送",-1)),Ft={class:"content"},Bt={class:"row"},Zt=_(()=>e("div",{class:"title"},"填写购买信息",-1)),Gt={class:"content"},Yt={key:0,class:"row"},Ht=_(()=>e("div",{class:"title"},"选择支付方式",-1)),Tt={class:"ure_info_box content"},jt={class:"pay_type"},Jt={class:"pay_type_box"},Kt=["onClick"],Wt=["src"],qt=_(()=>e("img",{class:"xiadui",src:te,alt:""},null,-1)),Pt={class:"copyright"},Ot=["innerHTML"],Xt={class:"copyright"},$t={class:"create-order"},eo={class:"create-item container"},to=_(()=>e("div",{class:"goods-title"},null,-1)),oo={class:"create-goods-counts"},so={class:"price"},ao={class:"total"},no={key:0,class:"s"},lo={name:"Default"},io=xe({...lo,props:{info:{}},setup(b){const B=De(),oe=ee(()=>B.config.site_shop_copyright),se=ee(()=>B.config.site_info_icp),W=n=>{const o={lt:"<",gt:">",nbsp:" ",amp:"&",quot:'"'};return n.replace(/&(lt|gt|nbsp|amp|quot);/gi,(v,L)=>o[L])},E=r([]),ae=b,{info:A}=Qe(ae),Z=f({shop_name:"",qq:"",shop_id:"",shop_notice_show:0,shop_notice:"",show_contact:0,shop_contact:{mobile:"",qq:"",wechat:""}}),p=f({categorys:[],goods:[],id:null}),ne=()=>{Object.assign(Z,A.value.shop)},le=()=>{Object.assign(p,A.value),p.id=A.value.categorys[0].id},t=f({id:null,content:"",coupon_type:"",visit_type:"",take_card_type:0,limit_quantity:0,price:0,contact_limit:"",sms_payer:0,sms_price:0,name:"",card_order:"",stockStr:"",cards_stock_count:null,wholesale_discount_list:[],event_give:[],addtion_give:[]}),ie=()=>{A.value.goods.length>0&&Object.assign(t,A.value.goods[0])};ne(),le(),ie();const w=f(A.value.userChannels),G=f({channel_id:w.length?w[0].channel_id:0,rate:w.length?w[0].rate:0}),ce=async n=>{if(n===p.id)return;const{data:o}=await Ce({cate_id:n,token:A.value.token});if(o.length===0){h.error("该栏目下没有商品!");return}p.id=n,p.goods=o,Object.assign(t,o[0]),t.content=W(o[0].content),k(),s.goods_id=t.id},de=n=>{if(n===t.id)return;const o=p.goods.find(v=>v.id===n);Object.assign(t,o),t.content=W(o.content),k(),s.goods_id=t.id},x=r("无限制"),Q=r("[必填]推荐填写QQ号或手机号!"),q=()=>{t.contact_limit==="any"?x.value="任意字符串":t.contact_limit==="mobile"?(x.value="只能输入手机号",Q.value="[必填]请填写您的手机号!"):t.contact_limit==="email"?(x.value="只能输入邮箱",Q.value="[必填]请填写您的邮箱!"):t.contact_limit==="qq"?(x.value="只能输入QQ号",Q.value="[必填]请填写您的QQ号!"):x.value="[必填]请输入联系方式"};q(),j(()=>E.value,n=>{n.includes(1)?(Q.value="[必填]请填写您的手机号!",s.is_rev_sms=1):(q(),s.is_rev_sms=0),n.includes(2)?s.isemail=1:s.isemail=0,k()});const M=r(!1);j(()=>M.value,n=>{if(n){s.is_coupon=1;return}s.is_coupon=0});const re=n=>{G.channel_id=n,s.pid=n},ue=n=>{n&&(k(),n>t.cards_stock_count&&h.error("库存不足"))},s=f({goods_id:t.id,contact:"",coupon_code:"",pwdforsearch:"",isemail:0,email:"",is_rev_sms:0,pid:G.channel_id,is_coupon:0,quantity:t.limit_quantity?t.limit_quantity:1});j(()=>s.coupon_code,n=>{n&&k()});const Y=r(!1),P=f({}),O=r(),_e=async()=>{var o;if(s.contact===""){h.error("请填写联系方式!");return}if(s.quantity===0){h.error("请填写购买数量!");return}if(s.quantity>t.cards_stock_count){h.error("库存不足!");return}if(s.quantity<t.limit_quantity){h.error("购买数量不能小于最小购买数量!");return}if(s.isemail===1&&s.email===""){h.error("请填写邮箱!");return}if(s.is_rev_sms===1&&s.contact===""){h.error("请填写手机号!");return}if(s.is_coupon===1&&s.coupon_code===""){h.error("请填写优惠券!");return}if(t.take_card_type===1&&s.pwdforsearch===""){h.error("请填写卡密查询密码!");return}Y.value=!0;const n=await ke(s);n.code===1?(Object.assign(P,n.data),await Me(),(o=O.value)==null||o.init(P)):h.error(n.msg),Y.value=!1},pe=n=>n.toFixed(2),me=(n,o,v)=>(o.sort((R,C)=>R.num-C.num).forEach(R=>{v>=R.num&&(n=R.price)}),n),H=r(0),T=r(0),y=r(),V=r(0),X=r(0),I=r(0),z=r(""),k=async()=>{if(X.value=t.price,V.value=t.price,t.wholesale_discount_list!=null&&(V.value=me(t.price,t.wholesale_discount_list,s.quantity)),T.value=X.value*s.quantity,V.value>0?y.value=V.value*s.quantity:y.value=T.value,M.value===!0&&s.coupon_code!==""){const n={coupon_code:s.coupon_code,goods_id:t.id,cate_id:p.id,quantity:s.quantity,shop_id:Z.shop_id,total_price:V.value*s.quantity},o=await Re(n);o.code===1?(o.data.type===1?I.value=o.data.amount:o.data.type===2&&(I.value=y.value*o.data.amount/100),z.value=`优惠券可用,优惠${o.data.amount}${o.data.type===1?"元":"%"}`,I.value>y.value&&(I.value=y.value,z.value=`优惠券可用,优惠${o.data.amount}${o.data.type===1?"元":"%"}，但大于订单金额，本单享受全额优惠【0元购买】`)):(z.value=o.msg,I.value=0)}t.sms_payer===0&&s.is_rev_sms?H.value=t.sms_price:H.value=0,y.value=pe(Number(y.value)+Number(H.value)-Number(I.value))};return k(),(n,o)=>{const v=ze,L=We,R=Le,C=Fe,D=Be,ge=Ze,he=Ge,ve=Ye,ye=He,Ae=Te,fe=je,be=Je,we=Ke;return l(),c("div",st,[e("div",at,[i(Ne,{"shop-info":Z},null,8,["shop-info"]),i(ye,{class:"section details pb20",bordered:!1},{default:u(()=>[e("div",nt,[e("div",lt,[e("img",{src:J(ot),style:{display:"inline-block","vertical-align":"bottom"}},null,8,it),ct]),(l(!0),c(S,null,N(p.categorys,(a,m)=>(l(),c("div",{key:m,flex:"auto",class:K(["category_box",p.id==a.id?"active":""]),onClick:$=>ce(a.id)},[e("div",rt,[e("div",null,d(a.name),1),e("span",ut,"共"+d(a.goodsCount)+"种商品",1),_t])],10,dt))),128))]),p.goods.length>0?(l(),c("div",pt,[i(v),e("div",mt,[e("div",gt,[i(J(tt),{style:{display:"inline-block","vertical-align":"bottom"}}),ht]),i(R,null,{default:u(()=>[(l(!0),c(S,null,N(p.goods,(a,m)=>(l(),U(L,{key:m,class:K(["goods_box",t.id==a.id?"active":""]),onClick:$=>de(a.id)},{default:u(()=>[e("div",vt,[e("div",yt,[e("div",At,[e("div",ft,[e("div",bt,[e("h4",null,d(a.name),1)]),e("div",wt,[e("span",It,"￥"+d(a.price),1)]),e("div",kt,[e("span",Rt,[e("span",null,d(a.stockStr),1)])])])]),Ct])])]),_:2},1032,["class","onClick"]))),128))]),_:1})]),i(v),e("div",Dt,[St,e("div",{class:"content",innerHTML:t.content},null,8,Nt),t.wholesale_discount_list.length>0?(l(),c("div",Ut,[xt,e("div",Qt,[(l(!0),c(S,null,N(t.wholesale_discount_list,(a,m)=>(l(),c("div",{key:m},"买满"+d(a.num)+"件，单价"+d(a.price)+"元",1))),128))])])):g("",!0),t.event_give!=null&&t.event_give.length>0?(l(),c("div",Mt,[Vt,e("div",Et,[(l(!0),c(S,null,N(t.event_give,(a,m)=>(l(),c("div",{key:m},"买满"+d(a.num)+"件，赠送"+d(a.give_num)+"件",1))),128))])])):g("",!0),t.addtion_give!=null&&t.addtion_give.length>0?(l(),c("div",zt,[Lt,e("div",Ft,[(l(!0),c(S,null,N(t.addtion_give,(a,m)=>(l(),c("div",{key:m},[F(" 买满"+d(a.bug_num)+"件，赠送`",1),e("b",null,d(a.goods_name),1),F("`商品"+d(a.give_num)+"件 ",1)]))),128))])])):g("",!0)]),i(v),e("div",Bt,[Zt,e("div",Gt,[i(ve,{"label-width":"80",layout:"inline"},{default:u(()=>[i(D,{label:"联系方式",tips:"联系方式特别重要,可用来查询订单"},{default:u(()=>[i(C,{modelValue:s.contact,"onUpdate:modelValue":o[0]||(o[0]=a=>s.contact=a),name:"contact",placeholder:Q.value,clearable:""},null,8,["modelValue","placeholder"])]),_:1}),i(D,{label:"提醒服务"},{default:u(()=>[i(ge,{modelValue:E.value,"onUpdate:modelValue":o[1]||(o[1]=a=>E.value=a),multiple:"",options:[{label:"短信提醒",value:1},{label:"邮箱提醒",value:2}]},null,8,["modelValue"])]),_:1}),E.value.includes(2)?(l(),U(D,{key:0,label:"邮箱地址"},{default:u(()=>[i(C,{modelValue:s.email,"onUpdate:modelValue":o[2]||(o[2]=a=>s.email=a),name:"email",placeholder:"填写你常用的邮箱地址",clearable:""},null,8,["modelValue"])]),_:1})):g("",!0),t.coupon_type?(l(),U(D,{key:1,label:"优惠券"},{default:u(()=>[i(he,{modelValue:M.value,"onUpdate:modelValue":o[3]||(o[3]=a=>M.value=a)},null,8,["modelValue"])]),_:1})):g("",!0),M.value&&t.coupon_type?(l(),U(D,{key:2,label:"优惠券",tips:z.value},{default:u(()=>[i(C,{modelValue:s.coupon_code,"onUpdate:modelValue":o[4]||(o[4]=a=>s.coupon_code=a),name:"coupon_code",placeholder:"请填写你的优惠券"},null,8,["modelValue"])]),_:1},8,["tips"])):g("",!0),t.take_card_type!=0?(l(),U(D,{key:3,label:"取卡密码"},{default:u(()=>[t.take_card_type!=0?(l(),U(C,{key:0,modelValue:s.pwdforsearch,"onUpdate:modelValue":o[5]||(o[5]=a=>s.pwdforsearch=a),placeholder:"请输入取卡密码（6-20位）"},null,8,["modelValue"])):g("",!0)]),_:1})):g("",!0)]),_:1})])]),w.length?(l(),c("div",Yt,[i(v),Ht,e("div",Tt,[e("div",jt,[e("div",Jt,[(l(!0),c(S,null,N(w,(a,m)=>(l(),c("div",{key:m,class:K(["pay_type_leng",G.channel_id==a.channel_id?"pay_type_leng_xz":""]),onClick:$=>re(a.channel_id)},[e("img",{style:{width:"21px"},src:J(Ie)+a.ico},null,8,Wt),e("span",null,d(a.show_name),1),qt],10,Kt))),128))])])])])):g("",!0)])):g("",!0)]),_:1}),e("footer",null,[e("div",Pt,[e("span",{innerHTML:oe.value},null,8,Ot)]),e("div",Xt,d(se.value),1)]),e("div",$t,[e("div",eo,[to,e("div",oo,[i(Ae,{modelValue:s.quantity,"onUpdate:modelValue":o[6]||(o[6]=a=>s.quantity=a),step:1,max:t.cards_stock_count,min:t.limit_quantity,"auto-width":"",clearable:"",size:"large",onChange:ue},null,8,["modelValue","max","min"])]),e("div",null,[i(be,{align:"center",size:"large"},{default:u(()=>[e("div",so,[F(" 支付金额 "),e("span",ao,"￥"+d(y.value),1),t.coupon_type&&s.coupon_code?(l(),c("span",no,"原价："+d(T.value),1)):g("",!0)]),i(fe,{shape:"round",theme:"primary",variant:"base",size:"large",onClick:o[7]||(o[7]=a=>_e())},{default:u(()=>[F(" 确认订单 ")]),_:1})]),_:1})])])]),i(we,{loading:Y.value,text:"生成订单中...",attach:"body",fullscreen:"",size:"small"},null,8,["loading"]),i(Ue,{ref_key:"orderRef",ref:O},null,512)])])}}});const Io=Se(io,[["__scopeId","data-v-4e72045e"]]);export{Io as default};
