import { request } from '@/utils/request';

// 优惠券列表
export function getGoodsCouponList(params: any) {
  return request.post({
    url: '/merchantapi/goods/coupon/index',
    params,
  });
}
// 添加
export function add(data: any) {
  return request.post({
    url: '/merchantapi/goods/coupon/add',
    data,
  });
}
// 批量删除 batch_del
export function batchDelGoodsCoupon(params: any) {
  return request.post({
    url: '/merchantapi/goods/coupon/batchDel',
    params,
  });
}
// 导出优惠券
export function dumpcoupon(params: any) {
  return request.post({
    url: '/merchantapi/goods/coupon/dumpcoupon',
    params,
    // responseType: 'blob',
  });
}
// 优惠券回收站列表
export function getGoodsCouponTrashList(params: any) {
  return request.post({
    url: '/merchantapi/goods/coupon/trash',
    params,
  });
}
// 批量恢复
export function batchRecoverGoodsCoupon(params: any) {
  return request.post({
    url: '/merchantapi/goods/coupon/restore',
    params,
  });
}
// 清空回收站
export function emptyGoodsCouponTrash(params: any) {
  return request.post({
    url: '/merchantapi/goods/coupon/clear',
    params,
  });
}
