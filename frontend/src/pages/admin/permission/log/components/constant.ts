import { PrimaryTableCol, TableRowData } from 'tdesign-vue-next';

export const columns: PrimaryTableCol<TableRowData>[] = [
  { colKey: 'id', type: 'multiple' },
  {
    colKey: 'username',
    title: '用户名',
    width: '80px',
  },
  {
    colKey: 'action',
    title: '访问链接',
    width: '260px',
  },
  {
    colKey: 'params',
    title: '请求参数',
    ellipsis: true,
  },
  {
    colKey: 'content',
    title: '返回结果',
    ellipsis: true,
  },
  {
    colKey: 'ip',
    title: 'IP',
  },
  {
    colKey: 'create_at',
    title: '日志时间',
    width: '160px',
  },
];
