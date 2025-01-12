import { request } from '@/utils/request';

export function list(params: any) {
  return request.post({
    url: '/adminapi/merchant/moneylog/list',
    params,
  });
}

// business_types
export function businessTypes() {
  return request.post({
    url: '/adminapi/merchant/moneylog/businessTypes',
  });
}
