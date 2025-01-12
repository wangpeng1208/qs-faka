import type { MenuListResult } from '@/api/model/permissionModel';
import { request } from '@/utils/request';

const Api = {
  MerchantMenuList: '/merchantapi/menu/getMenuListI18n',
};

export function getMerchantMenuList() {
  return request.post<MenuListResult>({
    url: Api.MerchantMenuList,
  });
}
