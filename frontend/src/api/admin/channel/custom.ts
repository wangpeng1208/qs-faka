import { request } from '@/utils/request';

export function customChannelConfig() {
  return request.post({
    url: '/adminapi/channel/custom/customChannelConfig',
  });
}
// setCustomChannelConfig
export function setCustomChannelConfig(params: any) {
  return request.post({
    url: '/adminapi/channel/custom/setCustomChannelConfig',
    params,
  });
}
// auditList
export function auditList(params: any) {
  return request.post({
    url: '/adminapi/channel/custom/auditList',
    params,
  });
}
// changeAuditStatus
export function changeAuditStatus(params: any) {
  return request.post({
    url: '/adminapi/channel/custom/changeAuditStatus',
    params,
  });
}

// custompayOrder
export function custompayOrder(params: any) {
  return request.post({
    url: '/adminapi/channel/custom/custompayOrder',
    params,
  });
}

// custompayOrderRecharge
export function custompayOrderRecharge(params: any) {
  return request.post({
    url: '/adminapi/channel/custom/custompayOrderRecharge',
    params,
  });
}
// custompayOrderDel
export function custompayOrderDel(params: any) {
  return request.post({
    url: '/adminapi/channel/custom/custompayOrderDel',
    params,
  });
}
