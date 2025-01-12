import{e as E,a8 as $,l as j,r as _,o as G,a2 as O,P as n,a3 as m,a4 as o,f as a,I as z,H as c,a9 as f,Q as p,F as w,aa as H,ab as K}from"./vue-bf422dc1.js";import{a as Q}from"./card-c6ac5d29.js";import{g as X}from"./good-8f08fe48.js";import{M as g,l as J,B as W,d as Y,F as Z,g as ee,L as te,U as le,e as ae,b as oe}from"./ui-ba7aaa7e.js";import{_ as se}from"./index-c2dd6a24.js";import"./icons-a8498fb6.js";import"./libs-51817cd7.js";import"./plugins-ca970193.js";import"./others-9f318174.js";import"./echarts-bf9d612c.js";const ne={key:0,style:{padding:"0"}},re={key:0},de={name:"GoodsCardAdd"},ue=E({...de,setup(ie){const C=[{label:"手动输入",value:1},{label:"txt文件",value:2}],T=[{label:"仅卡密",value:""},{label:"卡号+逗号+卡密",value:","},{label:"卡号+“|”+卡密",value:"|"},{label:"卡号+“----”+卡密",value:"----"},{label:"卡号+____”+卡密",value:"_____"}],F=[{label:"顺序插入",value:1},{label:"随机插入",value:2}],v=[{label:"关闭",value:0},{label:"开启",value:1}],y=$(),e=j({goods_id:null,order_type:1,import_type:1,split_type:",",files:[],is_pre:0,check_card:0,content:""}),{query:V}=y.currentRoute.value;Object.keys(V).forEach(s=>{e[s]!==void 0&&(e[s]=Number(V[s]))});const k=_([]),L=async()=>{const{data:s}=await X();k.value=s},h=_(null),B={goods_id:[{required:!0,message:"请选择商品",type:"error"}],content:[{required:!0,message:"请输入虚拟卡内容",type:"error"}],split_type:[{required:!1,message:"请选择导入格式",type:"error"}]},d=_("请输入虚拟卡内容"),S=s=>{s===","?d.value=`请输入虚拟卡内容，每行一个
    例如：
    卡号1111,卡密2222
    卡号3333,卡密4444`:s==="|"?d.value=`请输入虚拟卡内容，每行一个
    例如：
    卡号1111|卡密2222
    卡号3333|卡密4444`:s==="----"?d.value=`请输入虚拟卡内容，每行一个
    例如：
    卡号1111----卡密2222
    卡号3333----卡密4444`:s==="_____"?d.value=`请输入虚拟卡内容，每行一个
    例如：
    卡号1111_____卡密2222
    卡号3333_____卡密4444`:s===""&&(d.value=`请输入虚拟卡内容，每行一个
    （卡号卡密是写在一起的形式，或者只有卡密、卡号）
    例如：
    卡号1111卡密2222
    卡号3333卡密4444
    卡密4444
    卡密5555555555`)};G(()=>{L()});const q=async()=>{const s=await h.value.validate();if(typeof s!="object"&&s){const t={...e};try{const u=await Q(t);u.code===1?(g.success("新增成功"),y.push("/merchant/goods/card")):g.error(`新增失败：${u.msg}`)}catch{g.error("新增失败")}}},x=_(0),I=s=>{x.value=s};return(s,t)=>{const u=J,b=W,M=Y,r=Z,i=O("wp-check-tag"),N=ee,P=te,R=le,A=ae,D=oe;return n(),m(D,{title:"添加库存",class:"basic-container",bordered:!1},{actions:o(()=>[a(b,{variant:"text",theme:"default",onClick:t[0]||(t[0]=l=>z(y).push("/merchant/goods/card"))},{icon:o(()=>[a(u,{name:"rollback"})]),default:o(()=>[c(" 返回 ")]),_:1})]),default:o(()=>[a(A,{ref_key:"form",ref:h,class:"base-form",data:e,rules:B,"label-align":"left","label-width":150,onSubmit:q},{default:o(()=>[a(r,{label:"选择商品",name:"goods_id"},{default:o(()=>[a(M,{modelValue:e.goods_id,"onUpdate:modelValue":t[1]||(t[1]=l=>e.goods_id=l),placeholder:"请选择商品",options:k.value,keys:{value:"id",label:"name"},style:{width:"800px"}},null,8,["modelValue","options"])]),_:1}),a(r,{label:"插入方式",name:"order_type",help:""},{default:o(()=>[a(i,{modelValue:e.order_type,"onUpdate:modelValue":t[2]||(t[2]=l=>e.order_type=l),items:F},null,8,["modelValue"])]),_:1}),a(r,{label:"导入方式",name:"import_type",help:""},{default:o(()=>[a(i,{modelValue:e.import_type,"onUpdate:modelValue":t[3]||(t[3]=l=>e.import_type=l),items:C},null,8,["modelValue"])]),_:1}),a(r,{label:"导入格式",name:"split_type"},{default:o(()=>[a(i,{modelValue:e.split_type,"onUpdate:modelValue":t[4]||(t[4]=l=>e.split_type=l),items:T,onActions:S},null,8,["modelValue"])]),_:1}),e.import_type===1?(n(),m(r,{key:0,label:"虚拟卡内容",name:"content",style:{width:"960px"}},{default:o(()=>[a(N,{modelValue:e.content,"onUpdate:modelValue":t[5]||(t[5]=l=>e.content=l),placeholder:d.value,style:{height:"400px"},tips:"除了道具名称和CDK之间有空格 其他地方不允许有空格 手动输入一次最多添加500张"},null,8,["modelValue","placeholder"])]),_:1})):f("",!0),e.import_type===2?(n(),m(r,{key:1,label:"TXT文件",name:"file",help:""},{default:o(()=>[a(R,{modelValue:e.files,"onUpdate:modelValue":t[6]||(t[6]=l=>e.files=l),accept:"text/plain",theme:"custom","auto-upload":!1,"abridge-name":[10,8],draggable:"",onProgress:I},{dragContent:o(l=>[e.files&&e.files.length?(n(),p("ul",ne,[(n(!0),p(w,null,H(e.files,U=>(n(),p("li",{key:U.name,style:{"list-style-type":"none"}},K(U.name),1))),128))])):(n(),p(w,{key:1},[l&&l.dragActive?(n(),p("p",re,"释放鼠标")):x.value<1?(n(),m(P,{key:1},{default:o(()=>[c("拖拽文件至此或点击上传文件")]),_:1})):f("",!0)],64)),e.files&&e.files.length?(n(),m(b,{key:2,size:"small",style:{"margin-top":"36px"}},{default:o(()=>[c("更换文件")]),_:1})):f("",!0)]),_:1},8,["modelValue"])]),_:1})):f("",!0),a(r,{label:"卡密前缀",name:"is_pre",help:""},{default:o(()=>[a(i,{modelValue:e.is_pre,"onUpdate:modelValue":t[7]||(t[7]=l=>e.is_pre=l),items:v},null,8,["modelValue"])]),_:1}),a(r,{label:"检查重复",name:"check_card",help:""},{default:o(()=>[a(i,{modelValue:e.check_card,"onUpdate:modelValue":t[8]||(t[8]=l=>e.check_card=l),items:v},null,8,["modelValue"])]),_:1}),a(r,null,{default:o(()=>[a(b,{theme:"primary",class:"form-submit-confirm",type:"submit"},{default:o(()=>[c(" 提交 ")]),_:1})]),_:1})]),_:1},8,["data"])]),_:1})}}});const ke=se(ue,[["__scopeId","data-v-a9f8fb70"]]);export{ke as default};
