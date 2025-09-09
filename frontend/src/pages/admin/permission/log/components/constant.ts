import { PrimaryTableCol, TableRowData } from 'tdesign-vue-next';

export const columns: PrimaryTableCol<TableRowData>[] = [
  { colKey: 'id', type: 'multiple', width: '60px' },
  {
    colKey: 'username',
    title: '用户名',
    width: '120px',
  },
  {
    colKey: 'action',
    title: '访问链接',
    width: '200px',
  },
  {
    colKey: 'content',
    title: '返回结果',
    ellipsis: true,
    width: '200px',
  },
  {
    colKey: 'ip',
    title: 'IP',
    width: '140px',
  },
  {
    colKey: 'create_at',
    title: '日志时间',
    width: '160px',
  },
  {
    colKey: 'operate',
    title: '操作',
    width: '80px',
    fixed: 'right',
  },
];
