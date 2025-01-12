import { request } from '@/utils/request';

export function list(params: any) {
  return request.post({
    url: '/adminapi/merchant/menu/list',
    params,
  });
}
// label value数下拉选择

export function menuTreeSimple(params: any) {
  return request.post({
    url: '/adminapi/merchant/menu/treeSimple',
    params,
  });
}
// detail
export function detail(params: any) {
  return request.post({
    url: '/adminapi/merchant/menu/detail',
    params,
  });
}
// add
export function add(params: any) {
  return request.post({
    url: '/adminapi/merchant/menu/add',
    params,
  });
}
export function edit(params: any) {
  return request.post({
    url: '/adminapi/merchant/menu/edit',
    params,
  });
}
// delete
export function del(params: any) {
  return request.post({
    url: '/adminapi/merchant/menu/del',
    params,
  });
}

export function getAdminMenuList() {
  return request.post({
    url: '/adminapi/user/getAdminUserMenu',
  });
}
