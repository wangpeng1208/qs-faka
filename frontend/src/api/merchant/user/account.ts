import { request } from '@/utils/request';

// 注册配置
export function getRegisterConfig() {
  return request.post({
    url: '/merchantapi/user/account/registerConfig',
  });
}
export function login(data: any) {
  return request.post({
    url: '/merchantapi/user/account/login',
    data,
  });
}
// 获取微信扫码登录二维码地址
export function getWechatQrUri() {
  return request.post({
    url: '/merchantapi/user/account/wechatQrCodeUri',
  });
}

export function checkScanStatus(data: any) {
  return request.post({
    url: '/merchantapi/user/account/checkScanStatus',
    data,
  });
}

export function register(data: any) {
  return request.post({
    url: '/merchantapi/user/account/register',
    data,
  });
}

// 获取短信验证码token
export function getSmsToken(data: any) {
  return request.post({
    url: '/merchantapi/user/account/smsToken',
    data,
  });
}
// 发送短信验证码
export function sendSms(data: any) {
  return request.post({
    url: '/merchantapi/user/account/sendSmsCode',
    data,
  });
}

// 发送邮箱验证码
export function sendEmail(data: any) {
  return request.post({
    url: '/merchantapi/user/account/sendEmailCode',
    data,
  });
}
// refreshToken换取token
export function refreshToken(data: any) {
  return request.post({
    url: '/merchantapi/user/account/refresh_token',
    data,
  });
}
