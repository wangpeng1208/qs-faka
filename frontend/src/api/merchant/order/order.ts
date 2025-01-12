import { request } from '@/utils/request';

// 订单列表
export function list(params: any) {
  return request.post({
    url: '/merchantapi/order/order/list',
    params,
  });
}
// 查看卡密
export function card(params: any) {
  return request.post({
    url: '/merchantapi/order/order/card',
    params,
  });
}
