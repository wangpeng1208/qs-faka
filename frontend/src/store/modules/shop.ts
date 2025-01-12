import { defineStore } from 'pinia';

import { store } from '@/store';

export const useShopStore = defineStore('shop', {
  state: () => ({
    config: {},
    // 显示审核弹出层
    showVerifyDialog: false,
  }),
  getters: {},
  actions: {},
});

export function getShopStore() {
  return useShopStore(store);
}
