import { DialogPlugin } from 'tdesign-vue-next';

import { tableDelApi } from '@/api/base';

// 定义接口来描述 delfromData 的结构
interface DelFromData {
  title: string;
  info?: string;
  success?: () => Promise<any>; // 确保 success 是一个返回 Promise 的函数
}

export function modalSure(delfromData: DelFromData) {
  const { title, info } = delfromData;
  const content = `
      确定要${title}吗？
      ${info ? `${info}` : ''}
    `;
  return new Promise((resolve, reject) => {
    const confirmDialog = DialogPlugin.confirm({
      header: '提示',
      body: content,
      onConfirm: async () => {
        try {
          confirmDialog.update({ confirmBtn: { content: '提交中', loading: true } });
          const res = await tableDelApi(delfromData);
          confirmDialog.hide();
          resolve(res);
        } catch (error) {
          reject(error);
        }
      },
    });
  });
}
