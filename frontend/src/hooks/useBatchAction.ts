import { DialogPlugin, MessagePlugin } from 'tdesign-vue-next';

import { tableDelApi } from '@/api/base';

interface Opt {
  title: string; // 弹窗标题，也用于正文与提示
  body: string | (() => any); // 弹窗正文
  ids: number[] | number; // 单个 id 或数组
  url: string; // 接口路径
  fetchList?: () => void; // 成功后刷新
}

export async function useBatchAction(opt: Opt): Promise<void> {
  const { title, body, ids, url, fetchList } = opt;
  const idArr = Array.isArray(ids) ? ids : [ids];

  const dia = DialogPlugin.confirm({
    header: title || '提示',
    body: body || `确定要${title}吗？`,
    onConfirm: async () => {
      try {
        dia.update({ confirmBtn: { content: '提交中', loading: true } });
        if (url) {
          const res = await tableDelApi({ url, ids: { ids: idArr } });
          MessagePlugin.success(res.msg || '操作成功');
        }
        fetchList?.();
      } catch (e: any) {
        MessagePlugin.error(e.msg || '操作失败');
      } finally {
        dia.hide();
      }
    },
  });
}
