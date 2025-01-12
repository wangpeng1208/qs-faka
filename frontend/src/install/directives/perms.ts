/**
 * perm 操作权限处理
 * 指令用法：
 *  <el-button v-perms="['auth/menu/edit']">编辑</el-button>
 */

import { watchEffect } from 'vue';

import { useAdminUserStore } from '@/store/modules/admin';
import { useUserStore } from '@/store/modules/user';

export default {
  mounted: (el: HTMLElement, binding: any) => {
    const { value } = binding;
    const userAdminStore = useAdminUserStore();
    const userMerchantStore = useUserStore();
    const allPermission = '*';

    watchEffect(() => {
      let permissions = [];
      const app = window.location.pathname.split('/')[1];
      switch (app) {
        case 'admin':
          permissions = userAdminStore.perms;
          break;
        case 'merchant':
          permissions = userMerchantStore.perms;
          break;
        default:
          permissions = userMerchantStore.perms;
      }
      if (Array.isArray(value)) {
        if (value.length > 0) {
          const hasPermission = permissions.some((key: string) => {
            return allPermission === key || value.includes(key);
          });
          if (!hasPermission) {
            if (el.parentNode) {
              el.parentNode.removeChild(el);
            }
          }
        }
      } else {
        throw new Error('like v-perms="[\'auth/menu/edit\']"');
      }
    });
  },
};
