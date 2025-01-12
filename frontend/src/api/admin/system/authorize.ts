import { request } from '@/utils/request';

export function index() {
  return request.post({
    url: '/adminapi/system/authorize/index',
  });
}
