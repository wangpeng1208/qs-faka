import { request } from '@/utils/request';

export const baseUrl = window.location.origin;

export function list(params: any) {
  return request.post({
    url: '/adminapi/channel/payType/list',
    params,
  });
}
// detail
export function detail(params: any) {
  return request.post({
    url: '/adminapi/channel/payType/detail',
    params,
  });
}
// add
export function add(params: any) {
  return request.post({
    url: '/adminapi/channel/payType/add',
    params,
  });
}
// edit
export function edit(params: any) {
  return request.post({
    url: '/adminapi/channel/payType/edit',
    params,
  });
}
// del
export function del(params: any) {
  return request.post({
    url: '/adminapi/channel/payType/del',
    params,
  });
}

// payTypeSimple
export function payTypeSimple() {
  return request.post({
    url: '/adminapi/channel/payType/payTypeSimple',
  });
}
