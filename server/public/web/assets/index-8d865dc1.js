import{b as Be}from"./base-847c52cc.js";import{c as qe,a as xe,b as Ue}from"./shop-aaa0fa90.js";import{b as Le,_ as Ve}from"./index-c2dd6a24.js";import De from"./Header-aedd5a02.js";import Ie from"./OrderDialog-9b15ecfe.js";import{M as m,S as Me,p as Oe,I as Qe,F as Ee,a1 as Te,W as Fe,e as Se,b as Ge,h as Xe,B as Ze,N as ze,v as He,w as Ne}from"./ui-ba7aaa7e.js";import{e as Pe,d as ae,r as u,t as Re,l as b,w as R,P as l,Q as c,f as i,a4 as d,a7 as a,I as W,H as y,ab as r,F as U,aa as L,a3 as V,a9 as v,n as We,ac as je,ad as Ke,a5 as j}from"./vue-bf422dc1.js";import"./libs-51817cd7.js";import"./plugins-ca970193.js";import"./others-9f318174.js";import"./echarts-bf9d612c.js";import"./icons-a8498fb6.js";import"./index-b02b5348.js";import"./date-20546ee0.js";const K="data:image/png;base64,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",Je="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABYAAAAWCAYAAADEtGw7AAADyklEQVRIS7WUW2gcVRjH/9+5zF7axMlmm66VKlUpIkmxtV4oIubBihAEtdSH+lKkgjeKD94ehLS2CtJolda2Gm8gSB+qFCSI+NAXBYWatklqN9hgxdiUaNPdZnaT7e4c+c6Znd3VRPTBA8OZnZ35ff/z/y6E/2lRYeyNjKqGrwDUB2PSAKoAASRBJDWEqBmpBtNLO3bRys3lf6uDguE9R0F4oPEBQwVDASFdAKEA0nlB8iWCmoCnU0QeAQpQGiAiY7xAGzlOKzfY4BSc2MM3yQa4DhWAUFEA3hUgtNsl7wxUIMlBlQ1OJEcAeVjmbtvN4AKAdgcmQAgQWC1/4NQ6xQqkExZsjGwCcgB+z+2Rhc8zeAaA77j8ggAisFMZqZUaMplCWDFg62P1LadyYJA42wRmtTZhTb5GaqWGl81i8qMvIdNp5B65D7XL87EFfBqnVERgmo7A5LcmrOn4JOHllqP4w08Y2bobq197Gl1996BanGsCR4LsafnCBQcm6RM/YMW2Elyi+CXt+6gFFZzcshPVQoB1R/fCy3aiNl8FV4Xzv35SC+U1RcGJgRkIBrvyihNFEiK1xILzLxzAxMEjWLXtYdz07g6bg/DiZRiGKw9WlLWQmsAn35whIX2XsEZ2SXpIXJPD5OAQ8i8eAClC5u71yPTejvK581h2fy86ejcgLJZs3dursaYoOLV3hkj5cSMwXCaglrbh96+P4/QTA6jOziK5osuW4tyvU/A6O7D283fQfud6hIXZCBqrdVaURt6+BFJXxUUuFEQiBVMDfn7rCMpnf0Py2qsRnJ5A8dQ4wkoF3Yd2oWvLQwinL7p65/pvXVNUGt1fJFJt1iPbDFyjCjD8W0P77dbr/LMDmDh0GDc8+ShW7+uHKZZhrvBYkQuNj2kqjR4cJiFvibvHFrx2bas1ZLrN1uzwg9sRzldw69D70LnlCC8FgGTo39RyoEkqj723FUJ+ELcvdxXp+uCB8n0Uvh/D6GMv4+b9/cj0bUQ4/cdiFrgGJgyRMf1i7sx135LUd8RAa4lnq0RnOnH+ky8QjP+CG199DuHsHBCaxSywYENmkz1H8cePOz2VOEZCdrsZEPlMCkJ7qBZKUG3toFQKqIT/ZAFTB+Wynm2xQcGZT1coL/EhCb2xMQ5d98n0EtuN4XwNtLivrHGfzK55JpqTrUmtnBt6HCSfIuGtcUOJ27s+Drl9WxrBHR34DqDXVbbnszptwZTyn1cmj90L4d1FJHtIyOtBogMkkwAZAAUC5Y0xw0KKryjT/c1fa25R8ELF+V+e/QmVLQwgs8C69wAAAABJRU5ErkJggg==",Ye="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAASCAYAAABb0P4QAAADRElEQVQ4T4WUW2hcVRSG/3/tvc5MMqYRM9PGRBPStF6inTZaqFCLPlikiEj6oC8iVUrsg+CLSBGt0dIHQaG0GE2FYtE+GBRKxaJQiA8KIibtmKqNMZe2GGtNDZhkpp3OzJJzch2T1sM5D+ec9X/73+uyietc2cz+TRB/yJzvSrTs6gzDrg583GY+2EPRN2JNbceWk/K6wP4Dw6Bvovjuipb2p8K43OAn+0T8K3A6FTT2VZMdpf/qlwXmMvufMadHQA+UtKFy3XMXQqENdVfnJTZG0UoLXd6+teN/gdbT4bPJ5GWKW0HqvoqWna8uFuVHP38BEhykqPmi1rBxy8Ti/0sc5s4c7DK4doqfrGhpX7FcSgoXTv5mos10/piv3dx2Q+B0f+djcE6dxvrja3cMLQe0sZ5k0YLNEKf+1gc+LQNmM2+/aMAO0BuhgHPnSD9l4qpEggaIgtHjAacgFRAN8zgBSpzU1aAQIgLjF5w+/U4fKK0Uh7AIkZCzgFnYAjSCzcZ4QDzIUCdzJv/hZN+BlPd43sTtnQfOu5oDLAYtAGdMhDCG9+sCOzxflOxP75VIZbSq03eN+oOIdlK0gvS7TYIJOt9Fagl0uyh+FSh759xJwW5i7frpeWDu50ODoK4JtxyrujnBusezV0eOZyiaDhq3RXGFP7410I/62k1N4Xtx/MccgDiAacnnV7JuY3YeeOWXw5+Z+O1hAYD4mvjatqH86IkMnKb1tkeEpBUufmdGP6irNt5hIyPxUtXkOIAEgD6XTN8fLrLg8OyRNyn+tTDpoL8z3rz91/z5r/opeq+vH/fkk8XCn98bqcNuZWuzXcwkSp6XAFQC+NAl08+WAwc+2knRD0KHBfX1iYYnxq6dP9kLp/dp/UMzW77Ua6Q761Ib7p7d8tSsw90umX6rDHhl8OijlNiXoUOz4K746m0Dhd97ho3apHUPRsDiX6cMkHGXWp8yOxOULpeyAJwZnvap9NEyYHaou8FRz0U5FB2kBKMQtzVqZLpeET9plIfDqhL42oBqAK0hRKS0hbds+KYMGJ13I8ezUZvMQG/UwGUTKepqWH3P30uA10ZPvGRO95RNSzQ9ixp4yXnF913NupfnPv8L9a372aM0NHkAAAAASUVORK5CYII=",h=D=>(je("data-v-ee5d5628"),D=D(),Ke(),D),$e={style:{background:"#5e0000","min-height":"100vh"}},et={class:"row category"},tt={class:"title"},ot=["src"],at=["onClick"],nt={class:"card"},st={class:"card__s_cateremark"},lt=h(()=>a("img",{class:"lite_img",src:K},null,-1)),it={key:0},ct={class:"row goods"},dt=h(()=>a("h3",{class:"title"},"选择商品",-1)),rt=["innerHTML"],ut={key:0,class:"row"},_t=h(()=>a("span",{style:{padding:"0 20px"}},"(满减优惠)",-1)),pt={key:1,class:"row"},mt=h(()=>a("span",{style:{padding:"0 20px"}},"(活动赠送)",-1)),vt={key:2,class:"row"},gt=h(()=>a("span",{style:{padding:"0 20px"}},"(附加赠送)",-1)),ht=h(()=>a("img",{class:"lite_img",src:K},null,-1)),ft={class:"row"},At={class:"title"},yt=["src"],kt={class:"content"},bt={key:0,class:"row"},wt=h(()=>a("h3",{class:"title"},"选择支付方式",-1)),Ct={class:"ure_info_box"},Bt={class:"pay_type"},qt={class:"pay_type_box"},xt=["onClick"],Ut=["src"],Lt=h(()=>a("img",{class:"xiadui",src:K,alt:""},null,-1)),Vt={class:"container"},Dt={style:{color:"#bf6f6f"}},It=["innerHTML"],Mt={style:{color:"#bf6f6f"}},Ot={class:"create-order"},Qt={class:"create-item container"},Et=h(()=>a("div",{class:"goods-title"},null,-1)),Tt={class:"create-goods-counts"},Ft={class:"price"},St={class:"total"},Gt={key:0,class:"s"},Xt={name:"Default"},Zt=Pe({...Xt,props:{info:{}},setup(D){const J=Le(),ne=ae(()=>J.config.site_shop_copyright),se=ae(()=>J.config.site_info_icp),Y=s=>{const e={lt:"<",gt:">",nbsp:" ",amp:"&",quot:'"'};return s.replace(/&(lt|gt|nbsp|amp|quot);/gi,(A,q)=>e[q])},F=u([]),le=D,{info:k}=Re(le),ie=u(0),X=b({shop_name:"",qq:"",shop_id:"",shop_notice_show:0,shop_notice:"",show_contact:0,shop_contact:{mobile:"",qq:"",wechat:""}}),p=b({categorys:[],goods:[],id:null}),ce=()=>{Object.assign(X,k.value.shop)},de=()=>{Object.assign(p,k.value),p.id=k.value.categorys[0].id},n=b({id:null,content:"",coupon_type:"",visit_type:"",take_card_type:0,limit_quantity:0,price:0,contact_limit:"",sms_payer:0,sms_price:0,name:"",card_order:"",stockStr:"",cards_stock_count:null,wholesale_discount_list:[],event_give:[],addtion_give:[]}),re=()=>{k.value.goods.length>0&&Object.assign(n,k.value.goods[0])};ce(),de(),re();const w=b(k.value.userChannels),Z=b({channel_id:w.length?w[0].channel_id:0,rate:w.length?w[0].rate:0}),ue=async s=>{if(s===p.id)return;const{data:e}=await Ue({cate_id:s,token:k.value.token});if(e.length===0){m.error("该栏目下没有商品!");return}p.id=s,p.goods=e,Object.assign(n,e[0]),n.content=Y(e[0].content),B(),t.goods_id=n.id},_e=s=>{if(s===n.id)return;const e=p.goods.find(A=>A.id===s);Object.assign(n,e),n.content=Y(e.content),B(),t.goods_id=n.id},I=u("无限制"),M=u("[必填]推荐填写QQ号或手机号!"),$=()=>{n.contact_limit==="any"?I.value="任意字符串":n.contact_limit==="mobile"?(I.value="只能输入手机号",M.value="[必填]请填写您的手机号!"):n.contact_limit==="email"?(I.value="只能输入邮箱",M.value="[必填]请填写您的邮箱!"):n.contact_limit==="qq"?(I.value="只能输入QQ号",M.value="[必填]请填写您的QQ号!"):I.value="[必填]请输入联系方式"};$(),R(()=>F.value,s=>{s.includes(1)?(M.value="[必填]请填写您的手机号!",t.is_rev_sms=1):($(),t.is_rev_sms=0),s.includes(2)?t.isemail=1:t.isemail=0,B()});const O=u(!1);R(()=>O.value,s=>{if(s){t.is_coupon=1;return}t.is_coupon=0});const pe=s=>{Z.channel_id=s,t.pid=s},me=s=>{s&&(B(),s>n.cards_stock_count&&m.error("库存不足"))},t=b({goods_id:n.id,contact:"",coupon_code:"",pwdforsearch:"",isemail:0,email:"",is_rev_sms:0,pid:Z.channel_id,is_coupon:0,quantity:n.limit_quantity?n.limit_quantity:1});R(()=>t.coupon_code,s=>{s&&B()});const z=u(!1),ee=b({}),te=u(),ve=async()=>{var e;if(t.contact===""){m.error("请填写联系方式!");return}if(t.quantity===0){m.error("请填写购买数量!");return}if(t.quantity>n.cards_stock_count){m.error("库存不足!");return}if(t.quantity<n.limit_quantity){m.error("购买数量不能小于最小购买数量!");return}if(t.isemail===1&&t.email===""){m.error("请填写邮箱!");return}if(t.is_rev_sms===1&&t.contact===""){m.error("请填写手机号!");return}if(t.is_coupon===1&&t.coupon_code===""){m.error("请填写优惠券!");return}if(n.take_card_type===1&&t.pwdforsearch===""){m.error("请填写卡密查询密码!");return}z.value=!0;const s=await qe(t);s.code===1?(Object.assign(ee,s.data),await We(),(e=te.value)==null||e.init(ee)):m.error(s.msg),z.value=!1},ge=s=>s.toFixed(2),he=(s,e,A)=>(e.sort((g,P)=>g.num-P.num).forEach(g=>{A>=g.num&&(s=g.price)}),s),H=u(0),N=u(0),f=u(),Q=u(0),oe=u(0),C=u(0),S=u(""),B=async()=>{if(oe.value=n.price,Q.value=n.price,n.wholesale_discount_list!=null&&(Q.value=he(n.price,n.wholesale_discount_list,t.quantity)),N.value=oe.value*t.quantity,Q.value>0?f.value=Q.value*t.quantity:f.value=N.value,O.value===!0&&t.coupon_code!==""){const s={coupon_code:t.coupon_code,goods_id:n.id,cate_id:p.id,quantity:t.quantity,shop_id:X.shop_id,total_price:Q.value*t.quantity},e=await xe(s);e.code===1?(e.data.type===1?C.value=e.data.amount:e.data.type===2&&(C.value=f.value*e.data.amount/100),S.value=`优惠券可用,优惠${e.data.amount}${e.data.type===1?"元":"%"}`,C.value>f.value&&(C.value=f.value,S.value=`优惠券可用,优惠${e.data.amount}${e.data.type===1?"元":"%"}，但大于订单金额，本单享受全额优惠【0元购买】`)):(S.value=e.msg,C.value=0)}n.sms_payer===0&&t.is_rev_sms?H.value=n.sms_price:H.value=0,f.value=ge(Number(f.value)+Number(H.value)-Number(C.value))};return B(),(s,e)=>{const A=Me,q=Oe,g=He,P=Ne,G=Qe,x=Ee,fe=Te,Ae=Fe,ye=Se,ke=Ge,be=Xe,we=Ze,Ce=ze;return l(),c("div",$e,[i(De,{"shop-info":X},null,8,["shop-info"]),i(ke,{class:"container section details pb20 index-card",bordered:!1,style:{}},{default:d(()=>[a("div",et,[a("h3",tt,[i(A,{align:"center"},{default:d(()=>[a("img",{src:W(Je)},null,8,ot),y(" 商品分类"+r(ie.value),1)]),_:1})]),(l(!0),c(U,null,L(p.categorys,(o,E)=>(l(),c("div",{key:E,flex:"auto",class:j(["category_box",p.id==o.id?"active":""]),onClick:_=>ue(o.id)},[a("div",nt,[a("div",null,r(o.name),1),a("span",st,"共"+r(o.goodsCount)+"种商品",1),lt])],10,at))),128))]),p.goods.length>0?(l(),c("div",it,[i(q),a("div",ct,[dt,(l(!0),c(U,null,L(p.goods,(o,E)=>(l(),V(P,{key:E,class:j(["card",n.id==o.id?"active":""]),style:{"min-height":"80px","margin-bottom":"10px",position:"relative","align-items":"center"},onClick:_=>_e(o.id)},{default:d(()=>[i(g,{span:4},{default:d(()=>[a("h4",null,r(o.name),1)]),_:2},1024),i(g,{span:1},{default:d(()=>[y(" ￥"+r(o.price),1)]),_:2},1024),i(g,{span:1},{default:d(()=>[y(r(o.stockStr),1)]),_:2},1024),i(g,{span:6},{default:d(()=>[a("span",{innerHTML:o.content},null,8,rt),o.wholesale_discount_list.length>0?(l(),c("span",ut,[_t,(l(!0),c(U,null,L(o.wholesale_discount_list,(_,T)=>(l(),c("span",{key:T},"买满"+r(_.num)+"件，单价"+r(_.price)+"元",1))),128))])):v("",!0),o.event_give!=null&&o.event_give.length>0?(l(),c("span",pt,[mt,(l(!0),c(U,null,L(o.event_give,(_,T)=>(l(),c("span",{key:T},"买满"+r(_.num)+"件，赠送"+r(_.give_num)+"件",1))),128))])):v("",!0),o.addtion_give!=null&&o.addtion_give.length>0?(l(),c("span",vt,[gt,(l(!0),c(U,null,L(o.addtion_give,(_,T)=>(l(),c("span",{key:T},[y(" 买满"+r(_.bug_num)+"件，赠送`",1),a("b",null,r(_.goods_name),1),y("`商品"+r(_.give_num)+"件 ",1)]))),128))])):v("",!0)]),_:2},1024),ht]),_:2},1032,["class","onClick"]))),128))]),i(q),a("div",ft,[a("h3",At,[i(A,{align:"center"},{default:d(()=>[a("img",{src:W(Ye)},null,8,yt),y(" 购买信息 ")]),_:1})]),a("div",kt,[i(ye,{"label-width":"80",style:{width:"400px"}},{default:d(()=>[i(x,{label:"联系方式",tips:"联系方式特别重要,可用来查询订单"},{default:d(()=>[i(G,{modelValue:t.contact,"onUpdate:modelValue":e[0]||(e[0]=o=>t.contact=o),name:"contact",placeholder:M.value,clearable:""},null,8,["modelValue","placeholder"])]),_:1}),i(x,{label:"提醒服务",tips:"短信提醒可能需要支付额外的短信费用"},{default:d(()=>[i(fe,{modelValue:F.value,"onUpdate:modelValue":e[1]||(e[1]=o=>F.value=o),theme:"danger",multiple:"",options:[{label:"短信提醒",value:1},{label:"邮箱提醒",value:2}]},null,8,["modelValue"])]),_:1}),F.value.includes(2)?(l(),V(x,{key:0,label:"邮箱地址"},{default:d(()=>[i(G,{modelValue:t.email,"onUpdate:modelValue":e[2]||(e[2]=o=>t.email=o),name:"email",placeholder:"填写你常用的邮箱地址",clearable:""},null,8,["modelValue"])]),_:1})):v("",!0),n.coupon_type?(l(),V(x,{key:1,label:"优惠券"},{default:d(()=>[i(Ae,{modelValue:O.value,"onUpdate:modelValue":e[3]||(e[3]=o=>O.value=o)},null,8,["modelValue"])]),_:1})):v("",!0),O.value&&n.coupon_type?(l(),V(x,{key:2,label:"优惠券",tips:S.value},{default:d(()=>[i(G,{modelValue:t.coupon_code,"onUpdate:modelValue":e[4]||(e[4]=o=>t.coupon_code=o),name:"coupon_code",placeholder:"请填写你的优惠券"},null,8,["modelValue"])]),_:1},8,["tips"])):v("",!0),n.take_card_type!=0?(l(),V(x,{key:3,label:"取卡密码"},{default:d(()=>[n.take_card_type!=0?(l(),V(G,{key:0,modelValue:t.pwdforsearch,"onUpdate:modelValue":e[5]||(e[5]=o=>t.pwdforsearch=o),placeholder:"请输入取卡密码（6-20位）"},null,8,["modelValue"])):v("",!0)]),_:1})):v("",!0)]),_:1})])]),i(q),w.length?(l(),c("div",bt,[wt,a("div",Ct,[a("div",Bt,[a("div",qt,[(l(!0),c(U,null,L(w,(o,E)=>(l(),c("div",{key:E,class:j(["pay_type_leng",Z.channel_id==o.channel_id?"pay_type_leng_xz":""]),onClick:_=>pe(o.channel_id)},[a("img",{style:{width:"21px"},src:W(Be)+o.ico},null,8,Ut),a("span",null,r(o.show_name),1),Lt],10,xt))),128))])])])])):v("",!0)])):v("",!0)]),_:1}),a("footer",null,[a("div",Vt,[a("p",Dt,[a("span",{innerHTML:ne.value},null,8,It)]),a("p",Mt,r(se.value),1)])]),a("div",Ot,[a("div",Qt,[Et,a("div",Tt,[i(be,{modelValue:t.quantity,"onUpdate:modelValue":e[6]||(e[6]=o=>t.quantity=o),step:1,max:n.cards_stock_count,min:n.limit_quantity,"auto-width":"",clearable:"",size:"large",onChange:me},null,8,["modelValue","max","min"])]),a("div",null,[i(A,{align:"center",size:"large"},{default:d(()=>[a("div",Ft,[y(" 支付金额 "),a("span",St,"￥"+r(f.value),1),n.coupon_type&&t.coupon_code?(l(),c("span",Gt,"原价："+r(N.value),1)):v("",!0)]),i(we,{shape:"round",theme:"danger",variant:"base",size:"large",onClick:e[7]||(e[7]=o=>ve())},{default:d(()=>[y(" 确认订单 ")]),_:1})]),_:1})])])]),i(Ce,{loading:z.value,text:"生成订单中...",attach:"body",fullscreen:"",size:"small"},null,8,["loading"]),i(Ie,{ref_key:"orderRef",ref:te},null,512)])}}});const ao=Ve(Zt,[["__scopeId","data-v-ee5d5628"]]);export{ao as default};
