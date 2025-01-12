import{a as U,e as D}from"./category-c9a07555.js";import{M as d,I as N,F as P,h as M,e as j,f as q}from"./ui-ba7aaa7e.js";import{e as E,l as f,r as m,d as S,a2 as T,P as $,a3 as z,a4 as s,f as l,a7 as A}from"./vue-bf422dc1.js";const G={name:"CategoryEditPopup"},O=E({...G,emits:["success","close"],setup(H,{expose:_,emit:v}){const c={id:"",name:"",status:1,is_show:1,sort:"",theme:"default"},o=f({...c}),r=m("add"),g=S(()=>r.value==="edit"?"编辑分类":"新增分类"),b=m(!1),i=m(!1),w=(t="add")=>{if(r.value=t,i.value=!0,t==="add")for(const e in o)o[e]=c[e]},h=async t=>{r.value="edit";for(const e in o)t[e]!=null&&t[e]!==void 0&&(o[e]=t[e])},n=f({content:"保存",loading:!1}),y=v,p=m(null),V={name:[{required:!0,message:"请输入分类名称",type:"error"}]},k=async()=>{const t=await p.value.validate();if(typeof t!="object"&&t){n.content="保存中...",n.loading=!0;try{const e=r.value==="add"?await U(o):await D(o);e.code===1?(d.success("操作成功"),i.value=!1,y("success")):d.error(`操作失败：${e.msg}`)}catch{d.error("操作失败")}finally{n.content="保存",n.loading=!1}}};return _({open:w,getDetail:h}),(t,e)=>{const x=N,u=P,B=T("wp-check-tag"),C=M,F=j,I=q;return $(),z(I,{visible:i.value,"onUpdate:visible":e[3]||(e[3]=a=>i.value=a),loading:b.value,"destroy-on-close":!0,"close-on-overlay-click":!1,header:g.value,draggable:"","confirm-btn":n,"on-confirm":k,width:"500px"},{default:s(()=>[l(F,{ref_key:"form",ref:p,data:o,rules:V,"label-width":"120","label-align":"top"},{default:s(()=>[l(u,{label:"分类名称",name:"name",tips:"输入分类名称，长度需在2-20位之间"},{default:s(()=>[l(x,{modelValue:o.name,"onUpdate:modelValue":e[0]||(e[0]=a=>o.name=a),placeholder:"请输入分类名称","show-limit-number":"",minlength:2,maxlength:20},null,8,["modelValue"])]),_:1}),l(u,{label:"在店铺首页显示",name:"is_show",tips:"如果您选择'关闭',则买家访问总店铺将看不到此分类,必须通过分类链接访问"},{default:s(()=>[A("span",null,[l(B,{modelValue:o.is_show,"onUpdate:modelValue":e[1]||(e[1]=a=>o.is_show=a),items:[{label:"显示",value:1},{label:"隐藏",value:0}]},null,8,["modelValue"])])]),_:1}),l(u,{label:"分类排序",name:"sort",tips:"填写数字越大，则此分类在店铺中显示越靠前。"},{default:s(()=>[l(C,{modelValue:o.sort,"onUpdate:modelValue":e[2]||(e[2]=a=>o.sort=a),theme:"column",min:0},null,8,["modelValue"])]),_:1})]),_:1},8,["data"])]),_:1},8,["visible","loading","header","confirm-btn"])}}});export{O as _};
