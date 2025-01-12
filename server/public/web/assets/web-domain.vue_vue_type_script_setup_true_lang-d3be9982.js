import{g,e as S}from"./config-3b189d83.js";import{M as u,I as C,F as P,d as E,B as U,S as w,e as v,b as x}from"./ui-ba7aaa7e.js";import{e as R,l as A,r as B,P as i,a3 as d,a4 as l,f as t,a9 as m,H as c}from"./vue-bf422dc1.js";const F={name:"WebDomain"},Y=R({...F,setup(I){const e=A({site_domain:"",site_shop_domain:"",site_domain_short:"",sina_app_key:"",sina_app_secret:"",suo_app_key:"",site_shortlink_domain:""});(async()=>{const{data:n}=await g({field:Object.keys(e)});for(const a in n)e[a]=n[a]})();const f={site_domain:[{required:!0,message:"请输入主站域名"}]},r=B(),b=async()=>{const n=await r.value.validate();if(typeof n!="object"&&n){const a=await S({data:e});a.code===1?u.success("操作成功"):u.error(a.msg)}};return(n,a)=>{const _=C,s=P,y=E,p=U,V=w,k=v,h=x;return i(),d(h,{style:{"padding-top":"20px"},class:"basic-container",bordered:!1},{default:l(()=>[t(k,{ref_key:"formRef",ref:r,"label-align":"left",data:e,rules:f,"label-width":150,style:{width:"500px"}},{default:l(()=>[t(s,{label:"主站域名",name:"site_domain",tips:""},{default:l(()=>[t(_,{modelValue:e.site_domain,"onUpdate:modelValue":a[0]||(a[0]=o=>e.site_domain=o),clearable:"",placeholder:"请输入主站域名"},null,8,["modelValue"])]),_:1}),t(s,{label:"链接域名",name:"site_shop_domain",tips:"短链接将会通过此处填写的域名生成对应的短链接。"},{default:l(()=>[t(_,{modelValue:e.site_shop_domain,"onUpdate:modelValue":a[1]||(a[1]=o=>e.site_shop_domain=o),clearable:"",placeholder:"请输入链接域名"},null,8,["modelValue"])]),_:1}),t(s,{label:"短网址功能",name:"site_domain_short"},{default:l(()=>[t(y,{modelValue:e.site_domain_short,"onUpdate:modelValue":a[2]||(a[2]=o=>e.site_domain_short=o),options:[{label:"新浪短网址",value:"Sina"},{label:"缩我短网址",value:"Suo"}],clearable:"",placeholder:"请选择短网址功能"},null,8,["modelValue"])]),_:1}),e.site_domain_short=="Site"?(i(),d(s,{key:0,label:"短网址域名",name:"sina_app_key"},{default:l(()=>[t(_,{modelValue:e.site_shortlink_domain,"onUpdate:modelValue":a[3]||(a[3]=o=>e.site_shortlink_domain=o),clearable:"",placeholder:"请输入短网址域名"},null,8,["modelValue"])]),_:1})):m("",!0),e.site_domain_short=="Sina"?(i(),d(s,{key:1,label:"新浪短网址配置（APP_KEY）",name:"sina_app_key"},{default:l(()=>[t(_,{modelValue:e.sina_app_key,"onUpdate:modelValue":a[4]||(a[4]=o=>e.sina_app_key=o),clearable:"",placeholder:"请输入APP_KEY"},null,8,["modelValue"])]),_:1})):m("",!0),e.site_domain_short=="Sina"?(i(),d(s,{key:2,label:"新浪短网址配置（APP_SECRET）",name:"sina_app_secret"},{default:l(()=>[t(_,{modelValue:e.sina_app_secret,"onUpdate:modelValue":a[5]||(a[5]=o=>e.sina_app_secret=o),clearable:"",placeholder:"请输入APP_SECRET"},null,8,["modelValue"])]),_:1})):m("",!0),e.site_domain_short=="Suo"?(i(),d(s,{key:3,label:"缩我客短网址配置（KEY）",name:"suo_app_key",tips:"缩我短网址申请网址：https://suowo.cn/"},{default:l(()=>[t(_,{modelValue:e.suo_app_key,"onUpdate:modelValue":a[6]||(a[6]=o=>e.suo_app_key=o),clearable:"",placeholder:"请输入缩我key"},null,8,["modelValue"])]),_:1})):m("",!0),t(s,null,{default:l(()=>[t(V,{size:"small"},{default:l(()=>[t(p,{theme:"primary",onClick:b},{default:l(()=>[c("提交")]),_:1}),t(p,{theme:"default",variant:"base",type:"reset"},{default:l(()=>[c("重置")]),_:1})]),_:1})]),_:1})]),_:1},8,["data"])]),_:1})}}});export{Y as _};
