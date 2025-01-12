import { request } from '@/utils/request';

export function list(params: any) {
  return request.post({
    url: '/adminapi/merchant/cash/list',
    params,
  });
}
// cashCount
export function cashCount() {
  return request.post({
    url: '/adminapi/merchant/cash/cashCount',
  });
}
// del
export function del(params: any) {
  return request.post({
    url: '/adminapi/merchant/cash/del',
    params,
  });
}
// delBatch
export function delBatch(params: any) {
  return request.post({
    url: '/adminapi/merchant/cash/delBatch',
    params,
  });
}
//  拒绝
export function refuse(params: any) {
  return request.post({
    url: '/adminapi/merchant/cash/refuse',
    params,
  });
}
// 通过
export function pass(params: any) {
  return request.post({
    url: '/adminapi/merchant/cash/pass',
    params,
  });
}
// autoPass
export function autoPass(params: any) {
  return request.post({
    url: '/adminapi/merchant/cash/autoPass',
    params,
  });
}
