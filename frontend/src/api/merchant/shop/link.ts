import { request } from '@/utils/request';

interface handleLinkParams {
  status: number;
}

// 店铺主题内容
export function index() {
  return request.post({
    url: '/merchantapi/shop/link/index',
  });
}

export function reset(data = {} as handleLinkParams) {
  return request.post({
    url: '/merchantapi/shop/link/reset',
    data,
  });
}

export function close(data = {} as handleLinkParams) {
  return request.post({
    url: '/merchantapi/shop/link/close',
    data,
  });
}

// getTemplate
export function getTemplate() {
  return request.post({
    url: '/merchantapi/shop/link/getTemplate',
  });
}

// setTemplate
export function setTemplate(data: any) {
  return request.post({
    url: '/merchantapi/shop/link/setTemplate',
    data,
  });
}

// 购卡风格
export function getPcThemes() {
  return request.post({
    url: '/merchantapi/shop/link/pcTemplate',
  });
}

// 购卡风格
export function getMobileThemes() {
  return request.post({
    url: '/merchantapi/shop/link/mobileTemplate',
  });
}
