import { request } from '@/utils/request';

export const baseUrl = window.location.origin;

/**
 * @description 表格--删除
 * @param {number} param id {Number} 配置id
 */
export function tableDelApi(data: any) {
  return request.post({
    url: data.url,
    data: data.ids,
  });
}
