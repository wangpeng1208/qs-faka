import { request } from '@/utils/request';

// 订单查询
export function query(params: any) {
  return request.post({
    url: '/home/order/query',
    params,
  });
}

// 订单状态查询
export function getGoodsOrderStatus(params: any) {
  return request.post({
    url: '/home/order/orderStatus',
    params,
  });
}
