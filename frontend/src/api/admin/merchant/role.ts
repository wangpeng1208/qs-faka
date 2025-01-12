import { request } from '@/utils/request';

export function list(params: any) {
  return request.post({
    url: '/adminapi/merchant/role/list',
    params,
  });
}
export function listsimple() {
  return request.post({
    url: '/adminapi/merchant/role/listsimple',
  });
}

export function detail(params: any) {
  return request.post({
    url: '/adminapi/merchant/role/detail',
    params,
  });
}

export function menu() {
  return request.post({
    url: '/adminapi/merchant/role/menu',
  });
}

export function add(params: any) {
  return request.post({
    url: '/adminapi/merchant/role/add',
    params,
  });
}

export function edit(params: any) {
  return request.post({
    url: '/adminapi/merchant/role/edit',
    params,
  });
}

export function del(params: any) {
  return request.post({
    url: '/adminapi/merchant/role/del',
    params,
  });
}

export function rateList(params: any) {
  return request.post({
    url: '/adminapi/merchant/role/rateList',
    params,
  });
}

export function editRate(params: any) {
  return request.post({
    url: '/adminapi/merchant/role/editRate',
    params,
  });
}
