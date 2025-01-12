import { request } from '@/utils/request';

export function list(data: any) {
  return request.post({
    url: '/adminapi/order/complaint/list',
    data,
  });
}

export function detail(data: any) {
  return request.post({
    url: '/adminapi/order/complaint/detail',
    data,
  });
}
export function send(data: any) {
  return request.post({
    url: '/adminapi/order/complaint/send',
    data,
  });
}
export function win(data: any) {
  return request.post({
    url: '/adminapi/order/complaint/win',
    data,
  });
}

export function del(data: any) {
  return request.post({
    url: '/adminapi/order/complaint/del',
    data,
  });
}
