import FingerprintJS from '@fingerprintjs/fingerprintjs';
import { defineStore } from 'pinia';

import { getAdminUserInfo, login } from '@/api/admin/user';

export const useAdminUserStore = defineStore('adminUser', {
  state: () => ({
    accessToken: localStorage.getItem('admin.accessToken'),
    userInfo: {
      id: 0,
      username: '',
      nickname: '',
      avatar: '',
    },
    perms: ['*'],
    visitorId: '',
    wss: {} as any,
  }),

  getters: {},
  actions: {
    async getUniqueCode() {
      const fpPromise = FingerprintJS.load();
      const fp = await fpPromise;
      const result = await fp.get();
      this.visitorId = result.visitorId;
    },
    async login(userInfo: Record<string, unknown>) {
      const res = await login(userInfo);
      if (res.code === 1) {
        this.accessToken = res.data.access_token;
      } else {
        throw res;
      }
    },
    async getUserInfo() {
      const res = await getAdminUserInfo({});
      if (res.code === 1) {
        this.userInfo = res.data.user;
        this.perms = res.data.perms.length > 0 ? res.data.perms : ['*'];
      } else {
        throw res;
      }
    },
    async logout() {
      this.$reset();
    },
  },
  persist: {
    afterRestore: () => {
      // const permissionStore = usePermissionStore();
      // permissionStore.initRoutes();
    },
    key: 'admin',
    paths: ['userInfo', 'accessToken', 'visitorId'],
  },
});
