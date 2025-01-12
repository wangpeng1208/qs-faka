import{r as m}from"./index-8db2df2c.js";import{l as M}from"./category-7f0098f4.js";import{f as q}from"./date-20546ee0.js";import{T as C,M as g,d as F,F as P,I as T,D as h,R as N,e as j,f as A}from"./ui-ba7aaa7e.js";import{e as B,r,a2 as E,P as J,a3 as L,a4 as s,f as l,I as _}from"./vue-bf422dc1.js";function ae(o){return m.post({url:"/adminapi/article/article/list",params:o})}function G(o){return m.post({url:"/adminapi/article/article/add",params:o})}function z(o){return m.post({url:"/adminapi/article/article/edit",params:o})}function le(o){return m.post({url:"/adminapi/article/article/del",params:o})}const oe=[{colKey:"id",title:"ID"},{colKey:"cate_name",title:"分类"},{colKey:"title",title:"名称"},{colKey:"views",title:"浏览量"},{colKey:"status",title:"状态",cell:(o,{row:n})=>o(C,{variant:"light",theme:n.status===1?"success":"danger"},()=>n.status===1?"正常":"禁用")},{colKey:"top",title:"置顶",cell:(o,{row:n})=>n.top?"是":"否"},{colKey:"create_at",title:"添加时间",cell(o,n){return o("span",q(n.row.create_at))}},{colKey:"operate",title:"操作",fixed:"right"}],H=[{label:"正常",value:1},{label:"禁用",value:0}],V=[{label:"是",value:1},{label:"否",value:0}],Q={name:"EditPopup"},se=B({...Q,emits:["success"],setup(o,{expose:n,emit:w}){const f=r([]);(async()=>{const{data:i}=await M();f.value=i})();const y={id:0,cate_id:null,title:"",content:"",status:1,top:0,create_at:Date.now(),is_system:0},t=r({...y}),O=(i,e)=>{var c;t.value.create_at=((c=e.dayjsValue)==null?void 0:c.valueOf())||0},d=r(!1),p=r("添加文章");n({init:i=>{const e=JSON.parse(JSON.stringify(i));(e==null?void 0:e.id)>0?(p.value="编辑文章",e.create_at*=1e3,t.value={...e}):(p.value="添加文章",t.value={...y},t.value.create_at=Date.now()),d.value=!0}});const U={cate_id:[{required:!0,message:"必填",type:"error"}],content:[{required:!0,message:"必填",type:"error"}],title:[{required:!0,message:"必填",type:"error"}]},x=w,b=r(),D=async()=>{const i=await b.value.validate();if(typeof i!="object"&&i){const e=t.value.id===0?await G(t.value):await z(t.value);e.code===1?(g.success(e.msg),d.value=!1,x("success")):g.error(e.msg)}};return(i,e)=>{const c=F,u=P,K=T,k=h,R=E("wp-editor"),v=N,S=j,I=A;return J(),L(I,{visible:d.value,"onUpdate:visible":e[7]||(e[7]=a=>d.value=a),"close-on-overlay-click":!1,"destroy-on-close":!0,header:p.value,"on-confirm":D,width:"900px"},{default:s(()=>[l(S,{ref_key:"formRef",ref:b,"label-align":"left",data:t.value,rules:U,"label-width":80},{default:s(()=>[l(u,{label:"文章栏目",name:"cate_id"},{default:s(()=>[l(c,{value:t.value.cate_id,"onUpdate:value":e[0]||(e[0]=a=>t.value.cate_id=a),placeholder:"请选择文章栏目",options:f.value,clearable:"",filterable:""},null,8,["value","options"])]),_:1}),l(u,{label:"文章标题",name:"title"},{default:s(()=>[l(K,{modelValue:t.value.title,"onUpdate:modelValue":e[1]||(e[1]=a=>t.value.title=a),clearable:"",placeholder:"请输入文章标题"},null,8,["modelValue"])]),_:1}),l(u,{label:"添加时间",name:"create_at"},{default:s(()=>[l(k,{modelValue:t.value.create_at,"onUpdate:modelValue":e[2]||(e[2]=a=>t.value.create_at=a),"enable-time-picker":"","allow-input":"",clearable:"",style:{width:"500px"},onChange:O},null,8,["modelValue"])]),_:1}),l(u,{label:"文章内容",name:"content"},{default:s(()=>[l(R,{"model-value":t.value.content,"onUpdate:modelValue":e[3]||(e[3]=a=>t.value.content=a),"user-type":"admin",height:"300px",width:"100%",mode:"simple"},null,8,["model-value"])]),_:1}),l(u,{label:"状态",name:"status"},{default:s(()=>[l(v,{modelValue:t.value.status,"onUpdate:modelValue":e[4]||(e[4]=a=>t.value.status=a),options:_(H)},null,8,["modelValue","options"])]),_:1}),l(u,{label:"置顶",name:"top"},{default:s(()=>[l(v,{modelValue:t.value.top,"onUpdate:modelValue":e[5]||(e[5]=a=>t.value.top=a),options:_(V)},null,8,["modelValue","options"])]),_:1}),l(u,{label:"系统调用",name:"is_system"},{default:s(()=>[l(v,{modelValue:t.value.is_system,"onUpdate:modelValue":e[6]||(e[6]=a=>t.value.is_system=a),options:_(V)},null,8,["modelValue","options"])]),_:1})]),_:1},8,["data"])]),_:1},8,["visible","header"])}}});export{se as _,oe as c,le as d,ae as l};
