import{r as t}from"./index-b0aabda4.js";function o(r){return t.post({url:"/merchantapi/goods/card/list",params:r})}function s(r){return t.post({url:"/merchantapi/goods/card/add",data:r,headers:{"Content-Type":"multipart/form-data"}})}function e(r){return t.post({url:"/merchantapi/goods/card/del",data:r})}function n(r){return t.post({url:"/merchantapi/goods/card/trash",data:r})}function c(r){return t.post({url:"/merchantapi/goods/card/first",data:r})}function d(){return t.post({url:"/merchantapi/goods/card/allDel"})}function u(r){return t.post({url:"/merchantapi/goods/card/trashBatchDel",data:r})}function i(r){return t.post({url:"/merchantapi/goods/card/trashBatchRestore",data:r})}function l(){return t.post({url:"/merchantapi/goods/card/clear"})}export{s as a,l as b,d as c,e as d,c as f,n as g,o as l,i as r,u as t};