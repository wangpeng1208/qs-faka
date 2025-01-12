import { request } from '@/utils/request';

export function userList() {
  return request.post({
    url: '/adminapi/merchant/message/userList',
  });
}

// messageList
export function messageList(params: any) {
  return request.post({
    url: '/adminapi/merchant/message/messageList',
    data: params,
  });
}
