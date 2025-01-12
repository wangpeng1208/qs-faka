import { request } from '@/utils/request';

export function list(params: any) {
  return request.post({
    url: '/adminapi/channel/collectionAccount/list',
    params,
  });
}
// getFields
export function getFields(params: any) {
  return request.post({
    url: '/adminapi/channel/collectionAccount/getFields',
    params,
  });
}

// detail
export function detail(params: any) {
  return request.post({
    url: '/adminapi/channel/collectionAccount/detail',
    params,
  });
}
// add
export function add(params: any) {
  return request.post({
    url: '/adminapi/channel/collectionAccount/add',
    params,
  });
}
// edit
export function edit(params: any) {
  return request.post({
    url: '/adminapi/channel/collectionAccount/edit',
    params,
  });
}
// del
export function del(params: any) {
  return request.post({
    url: '/adminapi/channel/collectionAccount/del',
    params,
  });
}
