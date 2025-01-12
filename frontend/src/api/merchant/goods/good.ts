import { request } from '@/utils/request';

// 商品开始
export function list(data: any) {
  return request.post({
    url: '/merchantapi/goods/good/list',
    params: data,
  });
}
// 商品回收站开始
export function trash(data: any) {
  return request.post({
    url: '/merchantapi/goods/good/trash',
    params: data,
  });
}
// 商品回收站数据恢复
export function recover(data: any) {
  return request.post({
    url: '/merchantapi/goods/good/recover',
    data,
  });
}
// 获取商品数据 编辑时使用
export function detail(data: any) {
  return request.post({
    url: '/merchantapi/goods/good/detail',
    params: data,
  });
}
// 编辑 新增商品数据
export function edit(data: any) {
  return request.post({
    url: '/merchantapi/goods/good/edit',
    data,
  });
}
// 新增 商品数据
export function add(data: any) {
  return request.post({
    url: '/merchantapi/goods/good/add',
    data,
  });
}

// 修改商品状态
export function status(data: any) {
  return request.post({
    url: '/merchantapi/goods/good/status',
    data,
  });
}
// 删除商品
export function del(data: any) {
  return request.post({
    url: '/merchantapi/goods/good/del',
    data,
  });
}
// 附加赠送用到的 获取商品列表id+name | 搜索用到
export function goodList() {
  return request.post({
    url: '/merchantapi/goods/good/goodList',
  });
}
// 导出已卖出卡密
export function dumpcards(data: any) {
  return request.post({
    url: '/merchantapi/goods/good/dumpcards',
    params: data,
  });
}

// 主题设置
export function setTheme(data: any) {
  return request.post({
    url: '/merchantapi/goodsCategories/saveCategoryTheme',
    params: data,
  });
}
// 获取主题设置
export function getTheme(data: any) {
  return request.post({
    url: '/merchantapi/goodsCategories/getCategoryTheme',
    params: data,
  });
}
