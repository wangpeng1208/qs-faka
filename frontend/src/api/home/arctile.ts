import { request } from '@/utils/request';

// getNewsType
export function getNewsType() {
  return request.post({
    url: '/home/article/type',
  });
}
// getNewsList
export function getNewsList(data: any) {
  return request.post({
    url: '/home/article/list',
    data,
  });
}
// getDetailContent
export function getDetailContent(data: any) {
  return request.post({
    url: '/home/article/detail',
    data,
  });
}
