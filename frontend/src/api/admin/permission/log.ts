import { request } from '@/utils/request';

export function list(params: any) {
  return request.post({
    url: '/adminapi/permission/log/list',
    params,
  });
}

// delBatch
export function delBatch(params: any) {
  return request.post({
    url: '/adminapi/permission/log/delBatch',
    params,
  });
}
