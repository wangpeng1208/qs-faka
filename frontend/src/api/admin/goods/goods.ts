import { request } from '@/utils/request';

export function list(params: any) {
  return request.post({
    url: '/adminapi/goods/goods/list',
    params,
  });
}
// detail
export function detail(params: any) {
  return request.post({
    url: '/adminapi/goods/goods/detail',
    params,
  });
}
// edit/add
export function edit(params: any) {
  return request.post({
    url: '/adminapi/goods/goods/edit',
    params,
  });
}
// del
export function del(params: any) {
  return request.post({
    url: '/adminapi/goods/goods/del',
    params,
  });
}

// freeze
export function freeze(params: any) {
  return request.post({
    url: '/adminapi/goods/goods/freeze',
    params,
  });
}

// status
export function status(params: any) {
  return request.post({
    url: '/adminapi/goods/goods/status',
    params,
  });
}
