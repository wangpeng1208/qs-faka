import { request } from '@/utils/request';

// 首页注册统计
export function indexCount() {
  return request.post({
    url: '/home/index/indexCount',
  });
}
// 获取模板配置
export function getSiteConfig() {
  return request.post({
    url: '/home/index/siteConfig',
  });
}
