import{a as S,e as q,b as A}from"./collection-1a561a8a.js";import{M as c,I as N,F as C,g as G,O as L,d as j,R as Q,h as z,e as H,f as J}from"./ui-ba7aaa7e.js";import{e as K,l as W,r as d,G as X,P as _,a3 as V,a4 as o,f as t,Q as Y,F as Z,aa as $,a7 as p,ab as ee}from"./vue-bf422dc1.js";import{_ as le}from"./index-c2dd6a24.js";import"./icons-a8498fb6.js";import"./libs-51817cd7.js";import"./plugins-ca970193.js";import"./others-9f318174.js";import"./echarts-bf9d612c.js";const ae={class:"tdesign-demo__user-option"},te=["src"],oe={class:"tdesign-demo__user-option-info"},se={name:"AdminMenuEditPopup"},ne=K({...se,props:{payTypeOptions:{}},emits:["success"],setup(g,{expose:w,emit:U}){const x=[{label:"启用",value:1},{label:"禁用",value:0}],k=[{label:"手机",value:1},{label:"电脑",value:2},{label:"通用",value:0}],i={id:0,title:"",code:"",show_name:"",account_fields:"",applyurl:"",status:1,is_available:1,sort:0,lowrate:0,type:1,paytype:"",is_custom:0},l=W({...i}),f=g,b=d(f.payTypeOptions);X(()=>{b.value=f.payTypeOptions});const y=d(),r=d(!1),m=d("添加收款渠道"),O=u=>{if(u)m.value="编辑收款渠道",T(u);else{m.value="添加收款渠道";for(const e in i)l[e]=i[e]}r.value=!0},T=async u=>{const{data:e}=await S({id:u});for(const s in l)e[s]!=null&&e[s]!==void 0&&(l[s]=e[s])};w({init:O});const F={title:[{required:!0,message:"必填",type:"error"}],code:[{required:!0,message:"接口代码必选",type:"error"}],paytype:[{required:!0,message:"分类必选，此处图标会显示在购卡页面",type:"error"}]},R=U,h=async()=>{const u=await y.value.validate();if(typeof u!="object"&&u)try{let e;l.id>0?e=await q(l):e=await A(l),e.code===1?(c.success("操作成功"),r.value=!1,R("success")):c.error(e.msg)}catch(e){c.error(e.msg)}};return(u,e)=>{const s=N,n=C,D=G,E=L,I=j,v=Q,B=z,M=H,P=J;return _(),V(P,{visible:r.value,"onUpdate:visible":e[10]||(e[10]=a=>r.value=a),"close-on-overlay-click":!1,"destroy-on-close":!0,header:m.value,"on-confirm":h},{default:o(()=>[t(M,{ref_key:"formRef",ref:y,"label-align":"left",data:l,rules:F,"label-width":80},{default:o(()=>[t(n,{label:"接口名称",name:"title"},{default:o(()=>[t(s,{modelValue:l.title,"onUpdate:modelValue":e[0]||(e[0]=a=>l.title=a),clearable:"",placeholder:"请输入接口名称"},null,8,["modelValue"])]),_:1}),t(n,{label:"充值费率",name:"lowrate",tips:"单位：千分之"},{default:o(()=>[t(s,{modelValue:l.lowrate,"onUpdate:modelValue":e[1]||(e[1]=a=>l.lowrate=a),theme:"normal",type:"number",clearable:"",placeholder:"请输入充值费率",suffix:"‰"},null,8,["modelValue"])]),_:1}),t(n,{label:"代码接口",name:"code",tips:"请输入接口名称(英文标识)，必须是home/collection里的文件名"},{default:o(()=>[t(s,{modelValue:l.code,"onUpdate:modelValue":e[2]||(e[2]=a=>l.code=a),clearable:"",placeholder:"请输入接口名称(英文标识)"},null,8,["modelValue"])]),_:1}),t(n,{label:"显示名称",name:"show_name",tips:"用于店铺售卡页支付方式名显示"},{default:o(()=>[t(s,{modelValue:l.show_name,"onUpdate:modelValue":e[3]||(e[3]=a=>l.show_name=a),clearable:"",placeholder:"显示名称"},null,8,["modelValue"])]),_:1}),t(n,{label:"账户字段",name:"account_fields",tips:"含证书字符的将自动识别为证书上传框"},{default:o(()=>[t(D,{modelValue:l.account_fields,"onUpdate:modelValue":e[4]||(e[4]=a=>l.account_fields=a),clearable:"",placeholder:"用户添加渠道账户所需的字段，用“|”分割字段,用:分隔名称，如：应用号:appid|应用秘钥:appsecret"},null,8,["modelValue"])]),_:1}),t(n,{label:"申请地址",name:"applyurl"},{default:o(()=>[t(s,{modelValue:l.applyurl,"onUpdate:modelValue":e[5]||(e[5]=a=>l.applyurl=a),clearable:"",placeholder:"请输入账户申请地址"},null,8,["modelValue"])]),_:1}),t(n,{label:"分类",name:"paytype"},{default:o(()=>[t(I,{modelValue:l.paytype,"onUpdate:modelValue":e[6]||(e[6]=a=>l.paytype=a),clearable:"",placeholder:"请选择分类"},{default:o(()=>[(_(!0),Y(Z,null,$(b.value,a=>(_(),V(E,{key:a.value,value:a.value,label:a.label},{default:o(()=>[p("div",ae,[p("img",{src:a.ico,style:{width:"16px"}},null,8,te),p("div",oe,[p("div",null,ee(a.label),1)])])]),_:2},1032,["value","label"]))),128))]),_:1},8,["modelValue"])]),_:1}),t(n,{label:"状态",name:"status"},{default:o(()=>[t(v,{modelValue:l.status,"onUpdate:modelValue":e[7]||(e[7]=a=>l.status=a),options:x},null,8,["modelValue"])]),_:1}),t(n,{label:"适用终端",name:"is_available"},{default:o(()=>[t(v,{modelValue:l.is_available,"onUpdate:modelValue":e[8]||(e[8]=a=>l.is_available=a),options:k},null,8,["modelValue"])]),_:1}),t(n,{label:"排序",name:"sort",tips:"排序(越大越靠前)"},{default:o(()=>[t(B,{modelValue:l.sort,"onUpdate:modelValue":e[9]||(e[9]=a=>l.sort=a),theme:"normal",min:0,clearable:"",placeholder:"请输入排序"},null,8,["modelValue"])]),_:1})]),_:1},8,["data"])]),_:1},8,["visible","header"])}}});const be=le(ne,[["__scopeId","data-v-2a27817a"]]);export{be as default};
