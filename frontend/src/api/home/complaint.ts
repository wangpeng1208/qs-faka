import { request } from '@/utils/request';

export function query(params: any) {
  return request.post({
    url: '/home/complaint/complaintQuery',
    params,
  });
}
export function send(params: any) {
  return request.post({
    url: '/home/complaint/send',
    params,
  });
}

export function doComplaint(params: any) {
  return request.post({
    url: '/home/complaint/doComplaint',
    params,
  });
}
