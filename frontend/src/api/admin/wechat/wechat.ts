import { request } from '@/utils/request';

export function menuList() {
  return request.post({
    url: '/adminapi/wechat/menu/list',
  });
}
// menuEdit
export function menuEdit(data: any) {
  return request.post({
    url: '/adminapi/wechat/menu/menuEdit',
    data,
  });
}
