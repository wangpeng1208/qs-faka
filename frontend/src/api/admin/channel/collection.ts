import { request } from '@/utils/request';

export function list(params: any) {
  return request.post({
    url: '/adminapi/channel/collection/list',
    params,
  });
}
export function listSimple() {
  return request.post({
    url: '/adminapi/channel/collection/listSimple',
  });
}

// detail
export function detail(params: any) {
  return request.post({
    url: '/adminapi/channel/collection/detail',
    params,
  });
}
// add
export function add(params: any) {
  return request.post({
    url: '/adminapi/channel/collection/add',
    params,
  });
}
// edit
export function edit(params: any) {
  return request.post({
    url: '/adminapi/channel/collection/edit',
    params,
  });
}
// del
export function del(params: any) {
  return request.post({
    url: '/adminapi/channel/collection/del',
    params,
  });
}
// code
export function code() {
  return request.post({
    url: '/adminapi/channel/collection/code',
  });
}
