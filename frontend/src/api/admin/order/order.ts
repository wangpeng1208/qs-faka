import { request } from '@/utils/request';

export function list(params: any) {
  return request.post({
    url: '/adminapi/order/order/list',
    params,
  });
}
export function del(params: any) {
  return request.post({
    url: '/adminapi/order/order/del',
    params,
  });
}
export function clear() {
  return request.post({
    url: '/adminapi/order/order/clear',
  });
}

export function notify(params: any) {
  return request.post({
    url: '/adminapi/order/order/notify',
    params,
  });
}
export function refund(params: any) {
  return request.post({
    url: '/adminapi/order/order/refund',
    params,
  });
}
export function freeze(params: any) {
  return request.post({
    url: '/adminapi/order/order/freeze',
    params,
  });
}
