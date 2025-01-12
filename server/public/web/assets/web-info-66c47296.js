import{g as h,e as k}from"./config-6561e667.js";import{_ as d}from"./index.vue_vue_type_script_setup_true_lang-188644c2.js";import{M as r,R as w,F as x,I as v,e as C,B as I,S as R,b as B}from"./ui-ba7aaa7e.js";import{e as F,l as N,r as Q,P as p,a3 as f,a4 as o,a7 as M,f as l,H as c,a9 as S}from"./vue-bf422dc1.js";import{_ as j}from"./index-c2dd6a24.js";import"./icons-a8498fb6.js";import"./libs-51817cd7.js";import"./plugins-ca970193.js";import"./others-9f318174.js";import"./echarts-bf9d612c.js";const O={name:"WebInfo"},P=F({...O,setup(W){const e=N({site_status:1,site_close_tips:"",site_name:"",site_subtitle:"",site_keywords:"",site_desc:"",site_logo:"",merchant_logo:"",merchant_logo_sm:"",site_info_address:"",site_info_email:"",site_info_copyright:"",site_shop_copyright:"",site_info_icp:"",site_info_tel:"",site_info_tel_desc:"",site_info_qq:"",site_info_qq_desc:""}),_=({name:n,url:t})=>{e[n]=t};(async()=>{const{data:n}=await h({field:Object.keys(e)});for(const t in n)e[t]=n[t]})();const b={site_status:[{required:!0,message:"请选择站点开关"}],site_name:[{required:!0,message:"请填写网站名称"}],site_subtitle:[{required:!0,message:"请填写网站副标题"}],site_info_address:[{required:!0,message:"请填写联系地址"}],site_info_email:[{required:!0,message:"请填写客服邮箱"}]},m=Q(),V=async()=>{const n=await m.value.validate();if(typeof n!="object"&&n){const t=await k({data:e});t.code===1?r.success("操作成功"):r.error(t.msg)}};return(n,t)=>{const g=w,s=x,i=v,y=C,u=I,q=R,U=B;return p(),f(U,{style:{"padding-top":"20px"},class:"basic-container",bordered:!1},{footer:o(()=>[M("div",null,[l(q,{size:"small"},{default:o(()=>[l(u,{theme:"primary",onClick:V},{default:o(()=>[c("提交")]),_:1}),l(u,{theme:"default",variant:"base",type:"reset"},{default:o(()=>[c("重置")]),_:1})]),_:1})])]),default:o(()=>[l(y,{ref_key:"formRef",ref:m,"label-align":"left",data:e,rules:b,"label-width":150,style:{width:"500px"}},{default:o(()=>[l(s,{label:"站点开关",name:"site_status"},{default:o(()=>[l(g,{modelValue:e.site_status,"onUpdate:modelValue":t[0]||(t[0]=a=>e.site_status=a),options:[{label:"开启",value:1},{label:"关闭",value:-1}]},null,8,["modelValue"])]),_:1}),e.site_status===-1?(p(),f(s,{key:0,label:"网站关闭提示",name:"site_close_tips",tips:"网站关闭时显示的提示信息"},{default:o(()=>[l(i,{modelValue:e.site_close_tips,"onUpdate:modelValue":t[1]||(t[1]=a=>e.site_close_tips=a),clearable:"",placeholder:"请填写网站关闭提示"},null,8,["modelValue"])]),_:1})):S("",!0),l(s,{label:"网站名称",name:"site_name",tips:"网站名称，显示在浏览器标签上"},{default:o(()=>[l(i,{modelValue:e.site_name,"onUpdate:modelValue":t[2]||(t[2]=a=>e.site_name=a),clearable:"",placeholder:"请填写网站名称"},null,8,["modelValue"])]),_:1}),l(s,{label:"网站副标题",name:"site_subtitle",tips:"网站副标题，显示在浏览器标签上"},{default:o(()=>[l(i,{modelValue:e.site_subtitle,"onUpdate:modelValue":t[3]||(t[3]=a=>e.site_subtitle=a),clearable:"",placeholder:"请填写网站副标题"},null,8,["modelValue"])]),_:1}),l(s,{label:"网站关键字",name:"site_keywords",tips:"一般不超过100个字符，关键词用英文逗号隔开"},{default:o(()=>[l(i,{modelValue:e.site_keywords,"onUpdate:modelValue":t[4]||(t[4]=a=>e.site_keywords=a),clearable:"",placeholder:"请填写网站关键字"},null,8,["modelValue"])]),_:1}),l(s,{label:"网站描述",name:"site_desc"},{default:o(()=>[l(i,{modelValue:e.site_desc,"onUpdate:modelValue":t[5]||(t[5]=a=>e.site_desc=a),clearable:"",placeholder:"请填写网站描述"},null,8,["modelValue"])]),_:1}),l(s,{label:"前台网站logo",name:"site_logo",tips:"推荐180*50px"},{default:o(()=>[l(d,{theme:"image",initial:e,name:"site_logo",app:"admin",data:{type:"image"},onUpdate:_},null,8,["initial"])]),_:1}),l(s,{label:"商户中心大logo",name:"merchant_logo",tips:"推荐120*30px"},{default:o(()=>[l(d,{theme:"image",initial:e,name:"merchant_logo",app:"admin",data:{type:"image"},onUpdate:_},null,8,["initial"])]),_:1}),l(s,{label:"商户中心小logo",name:"merchant_logo_sm",tips:"推荐64*64px"},{default:o(()=>[l(d,{theme:"image",initial:e,name:"merchant_logo_sm",app:"admin",data:{type:"image"},onUpdate:_},null,8,["initial"])]),_:1}),l(s,{label:"联系地址",name:"site_info_address",tips:""},{default:o(()=>[l(i,{modelValue:e.site_info_address,"onUpdate:modelValue":t[6]||(t[6]=a=>e.site_info_address=a),clearable:"",placeholder:"请填写联系地址"},null,8,["modelValue"])]),_:1}),l(s,{label:"客服邮箱",name:"site_info_email",tips:""},{default:o(()=>[l(i,{modelValue:e.site_info_email,"onUpdate:modelValue":t[7]||(t[7]=a=>e.site_info_email=a),clearable:"",placeholder:"请填写客服邮箱"},null,8,["modelValue"])]),_:1}),l(s,{label:"版权信息",name:"site_info_copyright",tips:"商户后台和前台底部通用"},{default:o(()=>[l(i,{modelValue:e.site_info_copyright,"onUpdate:modelValue":t[8]||(t[8]=a=>e.site_info_copyright=a),clearable:"",placeholder:"请填写版权信息"},null,8,["modelValue"])]),_:1}),l(s,{label:"售卡页版权信息",name:"site_shop_copyright",tips:"售卡页版权信息底部版权信息(支持html标签)"},{default:o(()=>[l(i,{modelValue:e.site_shop_copyright,"onUpdate:modelValue":t[9]||(t[9]=a=>e.site_shop_copyright=a),clearable:"",placeholder:"请填写售卡页版权信息"},null,8,["modelValue"])]),_:1}),l(s,{label:"备案号码",name:"site_info_icp"},{default:o(()=>[l(i,{modelValue:e.site_info_icp,"onUpdate:modelValue":t[10]||(t[10]=a=>e.site_info_icp=a),clearable:"",placeholder:"请填写备案号码"},null,8,["modelValue"])]),_:1}),l(s,{label:"客服电话",name:"site_info_tel"},{default:o(()=>[l(i,{modelValue:e.site_info_tel,"onUpdate:modelValue":t[11]||(t[11]=a=>e.site_info_tel=a),clearable:"",placeholder:"请填写客服电话"},null,8,["modelValue"])]),_:1}),l(s,{label:"客服电话描述",name:"site_info_tel_desc"},{default:o(()=>[l(i,{modelValue:e.site_info_tel_desc,"onUpdate:modelValue":t[12]||(t[12]=a=>e.site_info_tel_desc=a),clearable:"",placeholder:"请填写客服电话描述"},null,8,["modelValue"])]),_:1}),l(s,{label:"客服QQ",name:"site_info_qq"},{default:o(()=>[l(i,{modelValue:e.site_info_qq,"onUpdate:modelValue":t[13]||(t[13]=a=>e.site_info_qq=a),clearable:"",placeholder:"请填写客服QQ"},null,8,["modelValue"])]),_:1}),l(s,{label:"服务时间描述",name:"site_info_qq_desc"},{default:o(()=>[l(i,{modelValue:e.site_info_qq_desc,"onUpdate:modelValue":t[14]||(t[14]=a=>e.site_info_qq_desc=a),clearable:"",placeholder:"请填写服务时间描述"},null,8,["modelValue"])]),_:1})]),_:1},8,["data"])]),_:1})}}});const X=j(P,[["__scopeId","data-v-f7fef913"]]);export{X as default};
