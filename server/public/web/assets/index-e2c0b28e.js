import{g as U,e as y}from"./config-3b189d83.js";import{M as f,R as C,F as R,h as w,p as B,B as F,S as I,e as N,b as P}from"./ui-ba7aaa7e.js";import{e as h,l as M,r as S,P as g,a3 as c,a4 as i,f as t,H as n,a9 as j}from"./vue-bf422dc1.js";import"./index-8db2df2c.js";import"./libs-51817cd7.js";import"./plugins-ca970193.js";import"./others-9f318174.js";import"./echarts-bf9d612c.js";import"./icons-a8498fb6.js";const K=h({__name:"index",setup(D){const l=M({site_register_status:0,site_register_need_username:0,site_register_need_mobile:0,site_register_need_mobile_check:0,site_register_need_email:0,site_register_need_email_check:0,site_register_smscode_max_count:0,site_register_smscode_max_time:0,sms_error_limit:0,sms_error_time:0,site_register_smscode_expire_time:0,ip_register_limit:0,site_register_verify:1});(async()=>{const{data:o}=await U({field:Object.keys(l)});for(const e in o)l[e]=o[e]})();const b={site_domain:[{required:!0,message:"请输入主站域名"}]},d=S(),V=async()=>{const o=await d.value.validate();if(typeof o!="object"&&o){const e=await y({data:l});e.code===1?f.success("操作成功"):f.error(e.msg)}},_=[{label:"开启",value:1},{label:"关闭",value:0}];return(o,e)=>{const a=C,r=R,m=w,u=B,p=F,x=I,k=N,v=P;return g(),c(v,{title:"注册设置",class:"basic-container",bordered:!1},{default:i(()=>[t(k,{ref_key:"formRef",ref:d,"label-align":"left",data:l,rules:b,"label-width":180},{default:i(()=>[t(r,{label:"开启会员注册",name:"site_register_status",tips:""},{default:i(()=>[t(a,{modelValue:l.site_register_status,"onUpdate:modelValue":e[0]||(e[0]=s=>l.site_register_status=s),options:_},null,8,["modelValue"])]),_:1}),t(r,{label:"审核机制",name:"site_register_check",tips:"开启注册审核：自动审核-注册账号后可以直接登录"},{default:i(()=>[t(a,{modelValue:l.site_register_verify,"onUpdate:modelValue":e[1]||(e[1]=s=>l.site_register_verify=s),options:[{label:"自动审核",value:1},{label:"手动审核",value:2}]},null,8,["modelValue"])]),_:1}),t(r,{label:"次数限制",name:"ip_register_limit",tips:"一天内同个IP地址限制注册次数, 0表示不限制"},{default:i(()=>[t(m,{modelValue:l.ip_register_limit,"onUpdate:modelValue":e[2]||(e[2]=s=>l.ip_register_limit=s),theme:"normal",min:"0",clearable:"",placeholder:"请输入一天内同个IP地址限制注册次数",suffix:"次"},null,8,["modelValue"])]),_:1}),t(r,{label:"用户名称必填",name:"site_register_need_username",tips:"勾选否，则手机号或者邮箱必须勾选一个(将作为用户名)，否则注册无法进行"},{default:i(()=>[t(a,{modelValue:l.site_register_need_username,"onUpdate:modelValue":e[3]||(e[3]=s=>l.site_register_need_username=s),options:_},null,8,["modelValue"])]),_:1}),t(u,null,{default:i(()=>[n("手机号")]),_:1}),t(r,{label:"手机号码必填",name:"site_register_need_mobile",tips:""},{default:i(()=>[t(a,{modelValue:l.site_register_need_mobile,"onUpdate:modelValue":e[4]||(e[4]=s=>l.site_register_need_mobile=s),options:_},null,8,["modelValue"])]),_:1}),l.site_register_need_mobile?(g(),c(r,{key:0,label:"验证手机号码",name:"site_register_need_mobile_check",tips:"是否验证 手机短信验证码"},{default:i(()=>[t(a,{modelValue:l.site_register_need_mobile_check,"onUpdate:modelValue":e[5]||(e[5]=s=>l.site_register_need_mobile_check=s),options:_},null,8,["modelValue"])]),_:1})):j("",!0),t(r,{label:"短信发送频率",name:"site_register_smscode_max_time",tips:"注册短信 发送频率限制, 0表示不限制;单位是秒，建议设置为60秒"},{default:i(()=>[t(m,{modelValue:l.site_register_smscode_max_time,"onUpdate:modelValue":e[6]||(e[6]=s=>l.site_register_smscode_max_time=s),theme:"normal",min:"0",clearable:"",placeholder:"请输入注册短信 发送频率限制",suffix:"秒"},null,8,["modelValue"])]),_:1}),t(r,{label:"输错次数限制",name:"sms_error_limit",tips:"短信验证码输错次数限制, 0表示不限制"},{default:i(()=>[t(m,{modelValue:l.sms_error_limit,"onUpdate:modelValue":e[7]||(e[7]=s=>l.sms_error_limit=s),theme:"normal",min:"0",clearable:"",placeholder:"请输入短信验证码输错次数限制",suffix:"次"},null,8,["modelValue"])]),_:1}),t(r,{label:"输错次数超限禁用时间",name:"sms_error_time",tips:"短信验证码输错次数超限禁用时间（分钟）, 0表示不限制"},{default:i(()=>[t(m,{modelValue:l.sms_error_time,"onUpdate:modelValue":e[8]||(e[8]=s=>l.sms_error_time=s),theme:"normal",min:"0",clearable:"",placeholder:"请输入短信验证码输错次数超限禁用时间（分钟）",suffix:"分钟"},null,8,["modelValue"])]),_:1}),t(u,null,{default:i(()=>[n("邮箱")]),_:1}),t(r,{label:"邮箱地址必填",name:"site_register_need_email",tips:""},{default:i(()=>[t(a,{modelValue:l.site_register_need_email,"onUpdate:modelValue":e[9]||(e[9]=s=>l.site_register_need_email=s),options:_},null,8,["modelValue"])]),_:1}),t(r,{label:"开启邮件验证",name:"site_register_need_email_check",tips:"是否验证 邮箱"},{default:i(()=>[t(a,{modelValue:l.site_register_need_email_check,"onUpdate:modelValue":e[10]||(e[10]=s=>l.site_register_need_email_check=s),options:_},null,8,["modelValue"])]),_:1}),t(r,{label:"验证码超时时间",name:"site_register_smscode_expire_time",tips:"验证码超时时间, 0表示不限制"},{default:i(()=>[t(m,{modelValue:l.site_register_smscode_expire_time,"onUpdate:modelValue":e[11]||(e[11]=s=>l.site_register_smscode_expire_time=s),theme:"normal",min:"0",clearable:"",placeholder:"请输入验证码超时时间",suffix:"秒"},null,8,["modelValue"])]),_:1}),t(r,null,{default:i(()=>[t(x,{size:"small"},{default:i(()=>[t(p,{theme:"primary",onClick:V},{default:i(()=>[n("提交")]),_:1}),t(p,{theme:"default",variant:"base",type:"reset"},{default:i(()=>[n("重置")]),_:1})]),_:1})]),_:1})]),_:1},8,["data"])]),_:1})}}});export{K as default};
