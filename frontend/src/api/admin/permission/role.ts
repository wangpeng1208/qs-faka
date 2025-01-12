import { request } from '@/utils/request';

export function list(params: any) {
  return request.post({
    url: '/adminapi/permission/role/list',
    params,
  });
}
// listSimple
export function listSimple() {
  return request.post({
    url: '/adminapi/permission/role/listSimple',
  });
}
// listSimpleTree
export function listSimpleTree() {
  return request.post({
    url: '/adminapi/permission/role/listSimpleTree',
  });
}
// delete
export function del(params: any) {
  return request.post({
    url: '/adminapi/permission/role/delete',
    params,
  });
}

// edit|add
export function edit(params: any) {
  return request.post({
    url: '/adminapi/permission/role/edit',
    params,
  });
}

// detail
export function detail(params: any) {
  return request.post({
    url: '/adminapi/permission/role/detail',
    params,
  });
}

// auth
export function auth(params: any) {
  return request.post({
    url: '/adminapi/permission/role/auth',
    params,
  });
}
