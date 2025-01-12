import { request } from '@/utils/request';

export function list(params: any) {
  return request.post({
    url: '/adminapi/permission/admin/list',
    params,
  });
}
// delete
export function del(params: any) {
  return request.post({
    url: '/adminapi/permission/admin/delete',
    params,
  });
}

// edit|add
export function edit(params: any) {
  return request.post({
    url: '/adminapi/permission/admin/edit',
    params,
  });
}

// detail
export function detail(params: any) {
  return request.post({
    url: '/adminapi/permission/admin/detail',
    params,
  });
}

// getRoles
export function getRoles(params: any) {
  return request.post({
    url: '/adminapi/permission/admin/getRoles',
    params,
  });
}
// setRoles
export function setRoles(params: any) {
  return request.post({
    url: '/adminapi/permission/admin/setRoles',
    params,
  });
}
