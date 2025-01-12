import { request } from '@/utils/request';

// token查询店铺信息
export function getShopInfo(params: any) {
  return request.post({
    url: '/shop',
    params,
  });
}
// 获取栏目下的商品列表
export function getGoodsList(params: any) {
  return request.post({
    url: '/shop/index/getGoodsListJson',
    params,
  });
}

// 发起订单请求
export function createOrder(params: any) {
  return request.post({
    url: '/home/pay/order',
    params,
  });
}

// 去支付
export function goPayment(params: any) {
  // 跳转到支付宝支付
  return `${window.location.origin}/home/pay/pay?trade_no=${params.trade_no}`;
}

export function getCouponInfo(params: any) {
  return request.post({
    url: '/shop/index/getCouponInfo',
    params,
  });
}
