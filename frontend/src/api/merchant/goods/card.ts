import { request } from '@/utils/request';

// 库存列表
export function list(params: any) {
  return request.post({
    url: '/merchantapi/goods/card/list',
    params,
  });
}

// 添加卡密
export function add(data: any) {
  return request.post({
    url: '/merchantapi/goods/card/add',
    data,
    headers: { 'Content-Type': 'multipart/form-data' },
  });
}
// 删除卡密
export function del(data: any) {
  return request.post({
    url: '/merchantapi/goods/card/del',
    data,
  });
}
// 卡密回收站列表
export function getGoodsCardTrashList(data: any) {
  return request.post({
    url: '/merchantapi/goods/card/trash',
    data,
  });
}

// 设置优先销售
export function first(data: any) {
  return request.post({
    url: '/merchantapi/goods/card/first',
    data,
  });
}

// 一键清空卡密至回收站 软删除
export function clearGoodsCards() {
  return request.post({
    url: '/merchantapi/goods/card/allDel',
  });
}
// 导出库存
export function dumpcards(data: any) {
  return request.post({
    url: '/merchantapi/goods/card/dumpcards',
    data,
  });
}

// trash_batch_del 真批量删除
export function trashBatchDel(data: any) {
  return request.post({
    url: '/merchantapi/goods/card/trashBatchDel',
    data,
  });
}
// restore 批量恢复
export function restore(data: any) {
  return request.post({
    url: '/merchantapi/goods/card/trashBatchRestore',
    data,
  });
}
// 清空回收站 clear
export function trashBatchDelAll() {
  return request.post({
    url: '/merchantapi/goods/card/clear',
  });
}
