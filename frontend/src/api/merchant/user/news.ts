import { request } from '@/utils/request';

export function getNewsList(params: Record<string, unknown>) {
  return request.post({
    url: '/merchantapi/user/news/list',
    params,
  });
}
// read
export function read(params: Record<string, unknown>) {
  return request.post({
    url: '/merchantapi/user/news/read',
    params,
  });
}
// readAll
export function readAll() {
  return request.post({
    url: '/merchantapi/user/news/readAll',
  });
}
// get_article_detail
export function detail(params: Record<string, unknown>) {
  return request.post({
    url: '/merchantapi/user/news/detail',
    params,
  });
}
