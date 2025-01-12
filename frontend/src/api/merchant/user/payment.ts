import { request } from '@/utils/request';

// list
export function list() {
  return request.post({
    url: '/merchantapi/user/payment/list',
  });
}

// delCustomChannel
export function delCustomChannel(
  data = {
    id: 0,
  },
) {
  return request.post({
    url: '/merchantapi/user/payment/delCustomChannel',
    data,
  });
}
// changeStatus
export function changeStatus(
  data = {
    status: 0,
    channel_id: 0,
  },
) {
  return request.post({
    url: '/merchantapi/user/payment/changeStatus',
    data,
  });
}

// getCustomChannelConfig
export function getCustomChannelConfig() {
  return request.post({
    url: '/merchantapi/user/payment/getCustomChannelConfig',
  });
}

// getCustomChannel
export function getCustomChannel() {
  return request.post({
    url: '/merchantapi/user/payment/getCustomChannel',
  });
}
// addCustomChannel
export function addCustomChannel(
  data = {
    channel_id: 0,
  },
) {
  return request.post({
    url: '/merchantapi/user/payment/addCustomChannel',
    data,
  });
}
// 自定义渠道账号列表
export function customChannelAccountList(params: any) {
  return request.post({
    url: '/merchantapi/user/payment/customChannelAccountList',
    params,
  });
}
// 自定义渠道账号删除
export function customChannelAccountDel(params: any) {
  return request.post({
    url: '/merchantapi/user/payment/customChannelAccountDel',
    params,
  });
}
// getChannelFields
export function getChannelFields(
  data = {
    channel_id: 0,
  },
) {
  return request.post({
    url: '/merchantapi/user/payment/getChannelFields',
    data,
  });
}

// customChannelAccountAdd
export function customChannelAccountAdd(data: any) {
  return request.post({
    url: '/merchantapi/user/payment/customChannelAccountAdd',
    data,
  });
}
// customChannelAccountDetail
export function customChannelAccountDetail(params: any) {
  return request.post({
    url: '/merchantapi/user/payment/customChannelAccountDetail',
    params,
  });
}
// customChannelAccountEdit
export function customChannelAccountEdit(data: any) {
  return request.post({
    url: '/merchantapi/user/payment/customChannelAccountEdit',
    data,
  });
}
// getUserBalance
export function getUserBalance() {
  return request.post({
    url: '/merchantapi/user/payment/getUserBalance',
  });
}
