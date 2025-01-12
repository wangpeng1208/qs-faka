import { request } from '@/utils/request';

export function list(params: any) {
  return request.post({
    url: '/adminapi/merchant/shop/list',
    params,
  });
}

export function verifyList(params: any) {
  return request.post({
    url: '/adminapi/merchant/shop/verifyList',
    params,
  });
}

export function verifyDetail(params: any) {
  return request.get({
    url: '/adminapi/merchant/shop/verifyDetail',
    params,
  });
}

export function doVerify(params: any) {
  return request.post({
    url: '/adminapi/merchant/shop/doVerify',
    params,
  });
}
