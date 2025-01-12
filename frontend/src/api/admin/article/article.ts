import { request } from '@/utils/request';

export function list(params: any) {
  return request.post({
    url: '/adminapi/article/article/list',
    params,
  });
}

// add
export function add(params: any) {
  return request.post({
    url: '/adminapi/article/article/add',
    params,
  });
}
// edit
export function edit(params: any) {
  return request.post({
    url: '/adminapi/article/article/edit',
    params,
  });
}

// delete
export function del(params: any) {
  return request.post({
    url: '/adminapi/article/article/del',
    params,
  });
}
