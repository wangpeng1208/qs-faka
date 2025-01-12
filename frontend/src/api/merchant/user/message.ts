import { request } from '@/utils/request';

export function list(params: any) {
  return request.post({
    url: '/merchantapi/user/message/list',
    params,
  });
}
// read
export function read(params: Record<string, unknown>) {
  return request.post({
    url: '/merchantapi/user/message/read',
    params,
  });
}
// readAll
export function readAll() {
  return request.post({
    url: '/merchantapi/user/message/readAll',
  });
}
// get_article_detail
export function detail(params: Record<string, unknown>) {
  return request.post({
    url: '/merchantapi/user/message/detail',
    params,
  });
}
// unReadCount
export function unReadCount() {
  return request.post({
    url: '/merchantapi/user/message/unReadCount',
  });
}

// del
export function del(params: Record<string, unknown>) {
  return request.post({
    url: '/merchantapi/user/message/del',
    params,
  });
}
