import { request } from '@/utils/request';

// 提现记录
export function log(data: any) {
  return request.post({
    url: '/merchantapi/finance/money/log',
    data,
  });
}

// rechargeOrder
export function rechargeOrder(data: any) {
  return request.post({
    url: '/merchantapi/finance/money/rechargeOrder',
    data,
  });
}

// 充值相关开始
// getRechargeChannel
export function getRechargeChannel() {
  return request.post({
    url: '/merchantapi/finance/money/getRechargeChannel',
  });
}
// doRecharge
export function doRecharge(data: any) {
  return request.post({
    url: '/merchantapi/finance/money/doRecharge',
    data,
  });
}
