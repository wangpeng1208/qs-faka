import FingerprintJS from '@fingerprintjs/fingerprintjs';
import { defineStore } from 'pinia';

import { checkScanStatus, login } from '@/api/merchant/user/account';
import { userDetail } from '@/api/merchant/user/user';
import { usePermissionStore } from '@/store';

export const useUserStore = defineStore('user', {
  state: () => ({
    accessToken: localStorage.getItem('merchant.accessToken'),
    userInfo: {
      id: 0,
      username: '',
      avatar: '',
      mobile: '',
      status: 0,
      email: '',
      openid: '',
      create_at: '',
    },
    shop: {
      shop_status: 0,
      shop_verify: 0,
      shop_freeze: 0,
    },
    showVerifyDialog: false,
    perms: ['*'],
    visitorId: '',
    wss: {} as any,
  }),

  getters: {},
  actions: {
    setAvatar(avatar: string) {
      this.userInfo.avatar = avatar;
    },
    // 显示审核弹出层
    showVerifyDialogAction() {
      this.showVerifyDialog = true;
    },
    // 隐藏审核弹出层
    hideVerifyDialogAction() {
      this.showVerifyDialog = false;
    },
    async login(userInfo: Record<string, unknown>) {
      await this.getUniqueCode();
      const res = await login(userInfo);
      if (res.code === 1) {
        this.accessToken = res.data.access_token;
        this.userInfo.id = res.data.id;
        this.shop.shop_status = res.data.shop_status;
        this.shop.shop_verify = res.data.shop_verify;
      }
      return res;
    },
    async wxQrcodeLoginStatus(userId: number, token: string) {
      const res = await checkScanStatus({
        user_id: userId,
        token,
      });
      if (res.code === 1) {
        this.accessToken = res.data.access_token;
        this.new = res.data.refresh_token;
        this.refreshToken = res.data.refresh_token;
        return { status: 1 };
      }
      return { status: 0, msg: res.msg };
    },
    async getUniqueCode() {
      const fpPromise = FingerprintJS.load();
      const fp = await fpPromise;
      const result = await fp.get();
      this.visitorId = result.visitorId;
    },
    async getUserInfo() {
      const res = await userDetail({
        visitor_id: this.visitorId,
      });
      if (res.code === 1) {
        this.userInfo = res.data.user;
        this.perms = res.data.perms.length > 0 ? res.data.perms : ['*'];
        // 如果 res.data.shop 返回 null，说明该用户没有店铺
        if (res.data.shop) {
          this.shop = res.data.shop;
        }
      } else {
        throw res;
      }
    },
    async logout() {
      this.$reset();
      // 获取 user store
      // const userStore = useUserStore();
      // 重置 user store 的状态
      // userStore.$reset();
      // localStorage.clear();
    },
  },
  persist: {
    afterRestore: () => {
      const permissionStore = usePermissionStore();
      permissionStore.restoreRoutes();
    },
    key: 'merchant',
    paths: ['userInfo', 'shop', 'accessToken', 'visitorId'],
  },
});
