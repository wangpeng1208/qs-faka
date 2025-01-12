import { defineStore } from 'pinia';

import { list, read, readAll, unReadCount } from '@/api/merchant/user/message';
import type { NotificationItem } from '@/types/interface';

export const useMessageStore = defineStore('message', {
  state: () => ({
    msgDataList: [] as NotificationItem[],
    unReadMsgCount: 0,
  }),
  getters: {
    msgData() {
      return this.msgDataList;
    },
    unReadCount() {
      return this.unReadMsgCount;
    },
  },
  actions: {
    async getMsgData() {
      const { data } = await list({ page: 1, limit: 5, status: 0 });
      this.msgDataList = data.list;
      const res = await unReadCount();
      if (res.code === 1) {
        this.unReadMsgCount = res.data ?? 0;
      }
    },
    async setMsgRead(id: string) {
      const res = await read({ id });
      // getMsgData
      if (res.code === 1) {
        await this.getMsgData();
      }
    },
    async setMsgReadAll() {
      const res = await readAll();
      if (res.code === 1) {
        this.msgData.forEach((e: NotificationItem) => {
          e.status = true;
        });
      }
    },
  },
  persist: true,
});
