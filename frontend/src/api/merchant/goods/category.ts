import { request } from '@/utils/request';

// 栏目列表
export function list(params: any) {
  return request.post({
    url: '/merchantapi/goods/category/list',
    params,
  });
}
// listSimple
export function listSimple() {
  return request.post({
    url: '/merchantapi/goods/category/listSimple',
  });
}
// 添加栏目
export function add(data: any) {
  return request.post({
    url: '/merchantapi/goods/category/add',
    data,
  });
}
// 编辑栏目
export function edit(data: any) {
  return request.post({
    url: '/merchantapi/goods/category/edit',
    data,
  });
}
// 栏目状态变更
export function status(data: any) {
  return request.post({
    url: '/merchantapi/goods/category/status',
    data,
  });
}

// 删除栏目
export function del(data: any) {
  return request.post({
    url: '/merchantapi/goods/category/del',
    data,
  });
}

// 主题设置
export function setTheme(params: any) {
  return request.post({
    url: '/merchantapi/goods/category/saveTheme',
    params,
  });
}
// 获取主题设置
export function theme(params: any) {
  return request.post({
    url: '/merchantapi/goods/category/theme',
    params,
  });
}
