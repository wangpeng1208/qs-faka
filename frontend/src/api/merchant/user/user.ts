import { request } from '@/utils/request';

export function bindEmail(data: any) {
  return request.post({
    url: '/merchantapi/user/user/bindEmail',
    data,
  });
}
// sendEmailCode
export function sendEmailCode(data: any) {
  return request.post({
    url: '/merchantapi/user/user/sendEmailCode',
    data,
  });
}
// resetPassword
export function resetPassword(data: any) {
  return request.post({
    url: '/merchantapi/user/user/resetPassword',
    data,
  });
}
// loginLog
export function loginLog(data: any) {
  return request.post({
    url: '/merchantapi/user/user/loginLog',
    data,
  });
}
// userDetail 传入浏览器指纹 与用户id 绑定
export function userDetail(data: any) {
  return request.post({
    url: '/merchantapi/user/user/userDetail',
    data,
  });
}
// setAvatar
export function setAvatar(data: any) {
  return request.post({
    url: '/merchantapi/user/user/setAvatar',
    data,
  });
}
// checkBind 检查微信是否绑定;绑定返回状态0 未绑定返回状态1和url地址
export function bindWechat() {
  return request.post({
    url: '/merchantapi/user/user/bindWechat',
  });
}

// getWechatNotify
export function getWechatNotify() {
  return request.post({
    url: '/merchantapi/user/user/getWechatNotify',
  });
}

// setWechatNotify

export function setWechatNotify(data: any) {
  return request.post({
    url: '/merchantapi/user/user/setWechatNotify',
    data,
  });
}
// unBindWechat
export function unBindWechat() {
  return request.post({
    url: '/merchantapi/user/user/unBindWechat',
  });
}
