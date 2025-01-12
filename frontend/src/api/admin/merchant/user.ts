import { request } from '@/utils/request';

export function list(params: any) {
  return request.post({
    url: '/adminapi/merchant/user/list',
    params,
  });
}
// detail
export function detail(params: any) {
  return request.post({
    url: '/adminapi/merchant/user/detail',
    params,
  });
}
// add
export function add(params: any) {
  return request.post({
    url: '/adminapi/merchant/user/add',
    params,
  });
}
// edit
export function edit(params: any) {
  return request.post({
    url: '/adminapi/merchant/user/edit',
    params,
  });
}
// del
export function del(params: any) {
  return request.post({
    url: '/adminapi/merchant/user/del',
    params,
  });
}

// message
export function message(params: any) {
  return request.post({
    url: '/adminapi/merchant/user/message',
    params,
  });
}
// loginlog
export function loginlog(params: any) {
  return request.post({
    url: '/adminapi/merchant/user/loginlog',
    params,
  });
}
// money
export function money(params: any) {
  return request.post({
    url: '/adminapi/merchant/user/money',
    params,
  });
}

// role 用户的角色
export function role(params: any) {
  return request.post({
    url: '/adminapi/merchant/user/role',
    params,
  });
}
// setRole
export function setRole(params: any) {
  return request.post({
    url: '/adminapi/merchant/user/setRole',
    params,
  });
}

// rateList
export function rateList(params: any) {
  return request.post({
    url: '/adminapi/merchant/user/rateList',
    params,
  });
}
// editRate
export function editRate(params: any) {
  return request.post({
    url: '/adminapi/merchant/user/editRate',
    params,
  });
}
// rateType
export function setRateType(params: any) {
  return request.post({
    url: '/adminapi/merchant/user/setRateType',
    params,
  });
}

// collectDetail
export function collectDetail(params: any) {
  return request.post({
    url: '/adminapi/merchant/user/collectDetail',
    params,
  });
}
// collectEdit
export function collectEdit(params: any) {
  return request.post({
    url: '/adminapi/merchant/user/collectEdit',
    params,
  });
}
// unlock
export function unlock(params: any) {
  return request.post({
    url: '/adminapi/merchant/user/unlock',
    params,
  });
}
