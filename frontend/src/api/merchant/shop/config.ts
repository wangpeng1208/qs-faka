import { request } from '@/utils/request';

// 获取店铺设置
export function index() {
  return request.post({
    url: '/merchantapi/shop/config/index',
  });
}
// 更新店铺设置
export function saveConfig(data: any) {
  return request.post({
    url: '/merchantapi/shop/config/saveConfig',
    data,
  });
}
