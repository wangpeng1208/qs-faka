import { request } from '@/utils/request';

// 仪表盘信息
export function getDashboard() {
  return request.post({
    url: '/merchantapi/workbench/dashboard',
  });
}

// 统计
export function getAnalysis() {
  return request.post({
    url: '/merchantapi/workbench/analysis',
  });
}

// 库存列表
export function getGoodsCardList(params: Record<string, unknown>) {
  return request.post({
    url: '/merchantapi/goodsCard/index',
    params,
  });
}

export function news(params: Record<string, unknown>) {
  return request.post({
    url: '/merchantapi/workbench/news',
    params,
  });
}

// notice
export function notice() {
  return request.post({
    url: '/merchantapi/workbench/notice',
  });
}
