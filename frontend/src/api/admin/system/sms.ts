import { request } from '@/utils/request';

export function list(params: any) {
  return request.post({
    url: '/adminapi/system/sms/list',
    params,
  });
}
// smsConfig
export function smsConfig(params: any) {
  return request.post({
    url: '/adminapi/system/sms/smsConfig',
    params,
  });
}

// getSmsConfig
export function getSmsConfig(params: any) {
  return request.post({
    url: '/adminapi/system/sms/getSmsConfig',
    params,
  });
}

// setSmsConfig
export function setSmsConfig(params: any) {
  return request.post({
    url: '/adminapi/system/sms/setSmsConfig',
    params,
  });
}
