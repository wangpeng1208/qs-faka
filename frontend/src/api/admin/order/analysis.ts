import { request } from '@/utils/request';

export function merchant(params: any) {
  return request.post({
    url: '/adminapi/order/analysis/merchant',
    params,
  });
}
// channel
export function channel(params: any) {
  return request.post({
    url: '/adminapi/order/analysis/channel',
    params,
  });
}
