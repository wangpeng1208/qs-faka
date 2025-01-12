import { request } from '@/utils/request';

// 投诉管理
export function list(data: any) {
  return request.post({
    url: '/merchantapi/order/complaint/list',
    data,
  });
}

// 投诉详情
export function detail(data: any) {
  return request.post({
    url: '/merchantapi/order/complaint/detail',
    data,
  });
}

// send
export function send(data: any) {
  return request.post({
    url: '/merchantapi/order/complaint/send',
    data,
  });
}
