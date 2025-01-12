import { request } from '@/utils/request';

export function getInfo() {
  return request.post({
    url: '/adminapi/system/system/getInfo',
  });
}
// cacheList
export function cacheList() {
  return request.post({
    url: '/adminapi/system/system/cache',
  });
}
// clearCache
export function clearCache(params: any) {
  return request.post({
    url: '/adminapi/system/system/clearCache',
    params,
  });
}
