import{d as x,b as D,e as F}from"./user-8ed5a501.js";import{M as c,R as T,F as I,I as M,e as P,f as A}from"./ui-ba7aaa7e.js";import{e as B,l as C,r as i,P as E,a3 as O,a4 as s,f as t}from"./vue-bf422dc1.js";const Q={name:"EditPopup"},N=B({...Q,emits:["success"],setup(S,{expose:b,emit:_}){const V=[{label:"启用",value:1},{label:"禁用",value:0}],v=[{label:"T+0",value:0},{label:"T+1",value:1}],d={id:0,lowrate:"",settlement_type:1,username:"",email:"",mobile:"",qq:"",shop_name:"",status:1,password:""},l=C({...d}),p=i(),r=i(!1),f=i("添加"),y=o=>{if(f.value=o?"编辑":"添加",o)q(o);else for(const e in d)l[e]=d[e];r.value=!0},q=async o=>{const{data:e}=await x({id:o});for(const n in l)e[n]!=null&&e[n]!==void 0&&(l[n]=e[n])};b({init:y});const g={name:[{required:!0,message:"必填",type:"error"}],title:[{required:!0,message:"必填",type:"error"}]},w=_,U=async()=>{const o=await p.value.validate();if(typeof o!="object"&&o){let e;l.id===0?e=await D(l):e=await F(l),e.code===1?(c.success(e.msg),r.value=!1,w("success")):c.error(e.msg)}};return(o,e)=>{const n=T,m=I,u=M,k=P,R=A;return E(),O(R,{visible:r.value,"onUpdate:visible":e[7]||(e[7]=a=>r.value=a),"close-on-overlay-click":!1,"destroy-on-close":!0,header:f.value,"on-confirm":U},{default:s(()=>[t(k,{ref_key:"formRef",ref:p,"label-align":"left",data:l,rules:g,"label-width":80},{default:s(()=>[t(m,{label:"结算周期",name:"settlement_type"},{default:s(()=>[t(n,{modelValue:l.settlement_type,"onUpdate:modelValue":e[0]||(e[0]=a=>l.settlement_type=a),options:v},null,8,["modelValue"])]),_:1}),t(m,{label:"用户名",name:"username"},{default:s(()=>[t(u,{modelValue:l.username,"onUpdate:modelValue":e[1]||(e[1]=a=>l.username=a),clearable:"",placeholder:"请输入用户名"},null,8,["modelValue"])]),_:1}),t(m,{label:"邮箱",name:"email"},{default:s(()=>[t(u,{modelValue:l.email,"onUpdate:modelValue":e[2]||(e[2]=a=>l.email=a),clearable:"",placeholder:"请输入邮箱"},null,8,["modelValue"])]),_:1}),t(m,{label:"手机号",name:"mobile"},{default:s(()=>[t(u,{modelValue:l.mobile,"onUpdate:modelValue":e[3]||(e[3]=a=>l.mobile=a),clearable:"",placeholder:"请输入手机号"},null,8,["modelValue"])]),_:1}),t(m,{label:"QQ",name:"qq"},{default:s(()=>[t(u,{modelValue:l.qq,"onUpdate:modelValue":e[4]||(e[4]=a=>l.qq=a),clearable:"",placeholder:"请输入qq"},null,8,["modelValue"])]),_:1}),t(m,{label:"状态",name:"status"},{default:s(()=>[t(n,{modelValue:l.status,"onUpdate:modelValue":e[5]||(e[5]=a=>l.status=a),options:V},null,8,["modelValue"])]),_:1}),t(m,{label:"登录密码",name:"password",help:"留空则不更新"},{default:s(()=>[t(u,{modelValue:l.password,"onUpdate:modelValue":e[6]||(e[6]=a=>l.password=a),clearable:"",placeholder:"请输入密码"},null,8,["modelValue"])]),_:1})]),_:1},8,["data"])]),_:1},8,["visible","header"])}}});export{N as _};
