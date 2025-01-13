import{y as I,z as F,_ as U}from"./index-b0aabda4.js";import{u as A}from"./index-b02b5348.js";import{M as r,I as M,F as N,B as S,e as V,f as Z}from"./ui-ba7aaa7e.js";import{e as q,l as P,r as d,P as R,a3 as $,a4 as t,a7 as b,ab as g,f as s,I as u,H as _}from"./vue-bf422dc1.js";import"./libs-51817cd7.js";import"./plugins-ca970193.js";import"./others-9f318174.js";import"./echarts-bf9d612c.js";import"./icons-a8498fb6.js";const j={class:"dialog-header"},H={class:"dialog-title"},L={name:"EmailDialog"},O=q({...L,emits:["success","close"],setup(T,{expose:y,emit:h}){const C=h,w=()=>{i.value=!1},[n,x]=A(),o=P({email:"",code:""}),z=async()=>{try{const e=await I({email:o.email});e.code===1?(r.success(e.msg),x()):r.error(e.msg)}catch{r.error("发送失败。接口错误")}},E={email:[{required:!0,message:"请输入邮箱",type:"error"},{pattern:/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/,message:"请输入正确的邮箱",type:"error"}],code:[{required:!0,message:"请输入验证码",type:"error"},{pattern:/^[0-9]{6}$/,message:"请输入正确的验证码",type:"error"}]},f=d(null),k=async()=>{const e=await f.value.validate();if(typeof e!="object"&&e){const a=await F(o);a.code===1?(r.success(a.msg),C("success")):r.error(a.msg)}},i=d(!1),p=d("绑定邮箱");return y({open:e=>{i.value=!0,o.email=e,e&&(p.value="修改邮箱")}}),(e,a)=>{const v=M,c=N,m=S,D=V,B=Z;return R(),$(B,{visible:i.value,"onUpdate:visible":a[2]||(a[2]=l=>i.value=l),"destroy-on-close":!0,"close-on-overlay-click":!0,width:"500",footer:!1,"close-btn":!1},{header:t(()=>[b("div",j,[b("div",H,g(p.value),1)])]),body:t(()=>[s(D,{ref_key:"form",ref:f,data:o,rules:E,class:"set-form","label-width":"80px","label-align":"left",onSubmit:k},{default:t(()=>[s(c,{label:"邮箱账号",name:"email"},{default:t(()=>[s(v,{value:o.email,"onUpdate:value":a[0]||(a[0]=l=>o.email=l),placeholder:"请输入邮箱账号",size:"large"},null,8,["value"])]),_:1}),s(c,{label:"验证码",name:"code",class:"email"},{default:t(()=>[s(v,{value:o.code,"onUpdate:value":a[1]||(a[1]=l=>o.code=l),placeholder:"请输入验证码",size:"large"},null,8,["value"]),s(m,{variant:"outline",disabled:u(n)>0,type:"button",onClick:z},{default:t(()=>[_(g(u(n)==0?"获取验证码":`${u(n)}秒后可重发`),1)]),_:1},8,["disabled"])]),_:1}),s(c,{class:"button","label-width":"0"},{default:t(()=>[s(m,{class:"form-submit-cancel",theme:"default",size:"large",variant:"base",onClick:w},{default:t(()=>[_(" 取消 ")]),_:1}),s(m,{theme:"primary",size:"large",class:"form-submit-confirm",type:"submit"},{default:t(()=>[_(" 提交 ")]),_:1})]),_:1})]),_:1},8,["data"])]),_:1},8,["visible"])}}});const se=U(O,[["__scopeId","data-v-56cdff0e"]]);export{se as default};