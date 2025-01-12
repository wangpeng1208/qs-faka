import { request } from '@/utils/request';

// 收益统计
export function getChartsMoney(params: any) {
  return request.post({
    url: '/merchantapi/charts/charts/money',
    params,
  });
}

// 累计金额
export function getChartsMoneyTotal(params: any) {
  return request.post({
    url: '/merchantapi/charts/charts/ranklist',
    params,
  });
}

// 渠道分析
export function getChartsChannel(params: any) {
  return request.post({
    url: '/merchantapi/charts/charts/channel',
    params,
  });
}
