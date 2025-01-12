import { defineStore } from 'pinia';
import { MessagePlugin } from 'tdesign-vue-next';
import { RouteRecordRaw } from 'vue-router';

import { getAdminMenuList } from '@/api/admin/permission/menu';
import { RouteItem } from '@/api/model/permissionModel';
import { getMerchantMenuList } from '@/api/permission';
import router from '@/router';
// import router, { homepageRouterList } from '@/router';
import * as white from '@/router/white';
import { store } from '@/store';
import { transformObjectToRoute } from '@/utils/route';

interface PermissionState {
  whiteListRouters: string[];
  asyncRoutes: RouteItem[];
  app: string;
}

export const usePermissionStore = defineStore('permission', {
  state: () => ({
    whiteListRouters: white.default.map((item) => item.name),
    asyncRoutes: [],
    app: 'merchant',
  }),
  getters: {
    getAsyncRoutes: (state: PermissionState) => state.asyncRoutes,
  },
  actions: {
    async buildAsyncRoutes(app: string) {
      this.app = app;
      try {
        let asyncRoutes: Array<RouteItem> = [];
        if (app === 'admin') {
          try {
            asyncRoutes = (await getAdminMenuList()).data;
          } catch (error) {
            MessagePlugin.error(error.response.data.msg);
            if (error.response.status === 401) {
              // 3s后跳转到登录页
              setTimeout(() => {
                window.location.href = '/admin/login';
              }, 3000);
            }
            asyncRoutes = [];
          }
        }
        if (app === 'merchant') {
          try {
            asyncRoutes = (await getMerchantMenuList()).data.list;
          } catch (error) {
            MessagePlugin.error(error.response.data.msg);
            if (error.response.status === 401) {
              // 3s后跳转到登录页
              setTimeout(() => {
                window.location.href = '/merchant/login';
              }, 3000);
            }
            asyncRoutes = [];
          }
        }
        this.asyncRoutes = await transformObjectToRoute(asyncRoutes);
        return this.asyncRoutes;
      } catch (error) {
        throw new Error("Can't build routes");
      }
    },

    async restoreRoutes() {
      this.asyncRoutes.forEach((item: RouteRecordRaw) => {
        if (item.name) {
          router.removeRoute(item.name);
        }
      });
      this.asyncRoutes = [];
    },
  },
  // persist: {},
});

export function getPermissionStore() {
  return usePermissionStore(store);
}
