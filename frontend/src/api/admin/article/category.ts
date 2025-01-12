import { request } from '@/utils/request';

export function list(params: any) {
  return request.post({
    url: '/adminapi/article/articleCategory/list',
    params,
  });
}
// listSimple
export function listSimple() {
  return request.post({
    url: '/adminapi/article/articleCategory/listSimple',
  });
}

// add
export function add(params: any) {
  return request.post({
    url: '/adminapi/article/articleCategory/add',
    params,
  });
}
// edit
export function edit(params: any) {
  return request.post({
    url: '/adminapi/article/articleCategory/edit',
    params,
  });
}

// delete
export function del(params: any) {
  return request.post({
    url: '/adminapi/article/articleCategory/del',
    params,
  });
}
