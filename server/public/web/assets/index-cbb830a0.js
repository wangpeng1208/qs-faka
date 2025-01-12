import{e as H,a8 as O,l as W,r,d as X,M as q,P as u,a3 as m,a4 as o,f as i,I as R,A as _,H as p,ab as J,n as V}from"./vue-bf422dc1.js";import{b as Q,d as Y,s as Z}from"./category-c9a07555.js";import{R as ee}from"./index-fb16f061.js";import{p as te}from"./global-0d825ba6.js";import{u as ae}from"./index-8db2df2c.js";import{f as oe}from"./date-20546ee0.js";import{X as ne}from"./icons-a8498fb6.js";import{_ as se}from"./edit.vue_vue_type_script_setup_true_lang-b02abb21.js";import le from"./link-27dcb063.js";import{m as ie,V as f,B as ce,L as re,S as de,W as ue,j as me,b as pe}from"./ui-ba7aaa7e.js";import"./no-list-e2f85d5e.js";import"./libs-51817cd7.js";import"./plugins-ca970193.js";import"./others-9f318174.js";import"./echarts-bf9d612c.js";import"./link-1b41ef85.js";import"./link-cc8ac83f.js";const fe=[{title:"排序",colKey:"drag",width:"5%",cell:v=>v(ne),align:"center",ellipsis:!0},{title:"分类名称",align:"left",colKey:"name",filter:{type:"input",resetValue:"",confirmEvents:["onEnter"],props:{placeholder:"输入关键词过滤"},showConfirmAndReset:!0},ellipsis:!0},{title:"商品数量",colKey:"goods_count",ellipsis:!0},{title:"状态",colKey:"status",ellipsis:!0},{title:"首页显示",colKey:"is_show",ellipsis:!0},{title:"创建时间",colKey:"create_at",cell(v,w){return v("span",oe(w.row.create_at))}},{align:"left",colKey:"operation",title:"操作",width:"200px",fixed:"right",ellipsis:!0}],ge={name:"GoodsCategory"},Le=H({...ge,setup(v){const w=ae(),b=O(),S=W({name:"",status:""}),c=r({defaultPageSize:10,total:0,defaultCurrent:1}),x=r([]),$=r(!1),d=async()=>{$.value=!0;const e={page:c.value.defaultCurrent,limit:c.value.defaultPageSize,...S};try{const{data:t}=await Q(e);x.value=t.list,c.value={...c.value,total:t.total}}catch{}finally{$.value=!1}};d();const P=r([]),K=e=>{P.value=e},L=(e,t)=>{c.value.defaultCurrent=e.current,c.value.defaultPageSize=e.pageSize,d()},y=r(),U=async e=>{var t,n,s;await V(),(t=y.value)==null||t.featchCategoryLink(e.id),(n=y.value)==null||n.getTemplate(),(s=y.value)==null||s.getUserTemplate(e.id)},C=r(),z=async e=>{var t,n;await V(),(t=C.value)==null||t.open("edit"),(n=C.value)==null||n.getDetail(e)},B=async()=>{var e;await V(),(e=C.value)==null||e.open("add")},I=async e=>{const t=ie({header:"提醒？",body:`是否确认删除(${e.name})？`,confirmBtn:"确认",onConfirm:()=>{t.hide();const{id:n}=e;Y({ids:[n]}).then(g=>{g.code===1?(d(),f.success({title:"提醒",content:"删除成功"})):f.success({title:"提醒",content:`删除失败：${g.msg}`})}).catch(()=>{f.success({title:"提醒",content:"删除失败"})})},onClose:()=>{t.hide()}})},k=async e=>{try{const t=await Z(e);t.code===1?f.success({title:"提醒",content:"修改成功"}):f.error({title:"提醒",content:`修改失败：${t.msg}`})}catch{f.error({title:"提醒",content:"修改失败"})}d()},N=async e=>{const{id:t,status:n}=e;k({id:t,field:"status",value:n})},A=async e=>{const t={id:e.id,field:"is_show",value:e.is_show};k(t)},E=e=>{if(e.currentIndex-e.targetIndex>0){const t={id:e.current.id,field:"sort",value:e.target.sort+1};k(t)}else{const t={id:e.current.id,field:"sort",value:e.target.sort-1};k(t)}},T=r(null),M=e=>{T.value=e,S.name=e==null?void 0:e.name,S.status=e==null?void 0:e.status,d()},j=X(()=>({offsetTop:w.isUseTabsRouter?48:0,container:`.${te}-layout`}));return(e,t)=>{const n=ce,s=re,g=de,D=ue,F=me,G=pe,h=q("perms");return u(),m(G,{title:"商品分类",class:"basic-container",bordered:!1},{default:o(()=>[i(F,{data:x.value,"drag-sort":"row-handler",columns:R(fe),"row-key":"id","vertical-align":"middle",hover:x.value.length>0,"selected-row-keys":P.value,loading:$.value,"lazy-load":"","header-affixed-top":j.value,"max-height":"90%",pagination:c.value,"filter-value":T.value,onDragSort:E,onPageChange:L,onSelectChange:K,onFilterChange:M},{topContent:o(()=>[_((u(),m(n,{style:{"margin-bottom":"15px"},onClick:t[0]||(t[0]=a=>B())},{default:o(()=>[p(" 添加 ")]),_:1})),[[h,["merchantapi/goods/category/add"]]])]),goods_count:o(({row:a})=>[i(g,null,{default:o(()=>[i(s,{theme:"primary",onClick:l=>R(b).push(`/merchant/goods/index?cate_id=${a.id}`)},{default:o(()=>[p(J(a.goods_count),1)]),_:2},1032,["onClick"])]),_:2},1024)]),status:o(({row:a})=>[i(D,{modelValue:a.status,"onUpdate:modelValue":l=>a.status=l,"custom-value":[1,0],onClick:l=>N(a)},null,8,["modelValue","onUpdate:modelValue","onClick"])]),is_show:o(({row:a})=>[i(D,{modelValue:a.is_show,"onUpdate:modelValue":l=>a.is_show=l,"custom-value":[1,0],onClick:l=>A(a)},null,8,["modelValue","onUpdate:modelValue","onClick"])]),operation:o(({row:a})=>[i(g,null,{default:o(()=>[_((u(),m(s,{theme:"primary",hover:"color",onClick:l=>U(a)},{default:o(()=>[p("链接")]),_:2},1032,["onClick"])),[[h,["merchantapi/goods/category"]]]),_((u(),m(s,{theme:"primary",hover:"color",onClick:l=>R(b).push(`/merchant/goods/card?cate_id=${a.id}`)},{default:o(()=>[p("库存卡")]),_:2},1032,["onClick"])),[[h,["merchantapi/goods/card"]]]),_((u(),m(s,{theme:"primary",hover:"color",onClick:l=>z(a)},{default:o(()=>[p("编辑")]),_:2},1032,["onClick"])),[[h,["merchantapi/goods/category/edit"]]]),_((u(),m(s,{theme:"danger",hover:"color",onClick:l=>I(a)},{default:o(()=>[p("删除")]),_:2},1032,["onClick"])),[[h,["merchantapi/goods/category/del"]]])]),_:2},1024)]),empty:o(()=>[i(ee,{title:"",tip:"商品分类为空",type:"list"})]),_:1},8,["data","columns","hover","selected-row-keys","loading","header-affixed-top","pagination","filter-value"]),i(le,{ref_key:"linkRef",ref:y},null,512),i(se,{ref_key:"editRef",ref:C,onSuccess:d},null,512)]),_:1})}}});export{Le as default};
