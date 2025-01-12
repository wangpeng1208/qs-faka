import { request } from '@/utils/request';

interface handleLinkParams {
  status: number;
  id: number;
  type: String;
}

// category主题内容
export function category(data: { id: number }) {
  return request.post({
    url: '/merchantapi/goods/link/category',
    data,
  });
}

// good主题内容
export function good(data: { id: number }) {
  return request.post({
    url: '/merchantapi/goods/link/good',
    data,
  });
}
// getTheme
export function getTheme(data: any) {
  return request.post({
    url: '/merchantapi/goods/link/getTheme',
    data,
  });
}
// setTheme
export function setTheme(data: any) {
  return request.post({
    url: '/merchantapi/goods/link/saveTheme',
    data,
  });
}

export function reset(data = {} as handleLinkParams) {
  return request.post({
    url: '/merchantapi/goods/link/reset',
    data,
  });
}

export function close(data = {} as handleLinkParams) {
  return request.post({
    url: '/merchantapi/goods/link/close',
    data,
  });
}

// getTemplate
export function getTemplate() {
  return request.post({
    url: '/merchantapi/goods/link/getTemplate',
  });
}

// setTemplate
export function setTemplate(data: any) {
  return request.post({
    url: '/merchantapi/goods/link/setTemplate',
    data,
  });
}

// 购卡风格
export function getPcThemes() {
  return request.post({
    url: '/merchantapi/goods/link/pcTemplate',
  });
}

// 购卡风格
export function getMobileThemes() {
  return request.post({
    url: '/merchantapi/goods/link/mobileTemplate',
  });
}
