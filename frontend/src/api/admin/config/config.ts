import { request } from '@/utils/request';

export function getConfig(params: any) {
  return request.post({
    url: '/adminapi/config/config/getConfig',
    params,
  });
}

// editConfig
export function editConfig(data: any) {
  return request.post({
    url: '/adminapi/config/config/editConfig',
    data,
  });
}

// emailTest
export function emailTest(data: any) {
  return request.post({
    url: '/adminapi/config/config/emailTest',
    data,
  });
}
// imgUpload
export const adminUpload = '/adminapi/upload/upload';
export const merchantUpload = '/merchantapi/upload/upload';

export const baseUrl = window.location.origin;
