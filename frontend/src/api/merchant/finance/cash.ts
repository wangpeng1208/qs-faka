import { request } from '@/utils/request';

// 提现记录
export function index(params: any) {
  return request.post({
    url: '/merchantapi/finance/cash/index',
    params,
  });
}

// 提现参数
export function applyConfig() {
  return request.post({
    url: '/merchantapi/finance/cash/applyConfig',
  });
}
// 提现申请
export function applyCash(params: any) {
  return request.post({
    url: '/merchantapi/finance/cash/apply',
    params,
  });
}

// 用户提现方式
// export function cashType() {
//   return request.post({
//     url: '/merchantapi/finance/cash/cashType',
//   });
// }

// 收款设置获取
export function getCollect() {
  return request.post({
    url: '/merchantapi/finance/cash/getCollect',
  });
}
// 收款设置保存
export function setCollect(data: any) {
  return request.post({
    url: '/merchantapi/finance/cash/setCollect',
    data,
  });
}

// 收款设置
export function setUserCashType(data: any) {
  return request.post({
    url: '/merchantapi/finance/cash/setUserCashType',
    data,
  });
}
