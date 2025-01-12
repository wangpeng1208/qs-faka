import { request } from '@/utils/request';

export function list(params: any) {
  return request.post({
    url: '/adminapi/system/notification/list',
    params,
  });
}
// add
export function add(params: any) {
  return request.post({
    url: '/adminapi/system/notification/add',
    params,
  });
}
// edit
export function edit(params: any) {
  return request.post({
    url: '/adminapi/system/notification/edit',
    params,
  });
}
// del
export function del(params: any) {
  return request.post({
    url: '/adminapi/system/notification/del',
    params,
  });
}

// setSmsConfig
export function setSmsConfig(params: any) {
  return request.post({
    url: '/adminapi/system/notification/setSmsConfig',
    params,
  });
}
