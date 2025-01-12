import { PrimaryTableCol, TableRowData } from 'tdesign-vue-next';

export const COLUMNS: PrimaryTableCol<TableRowData>[] = [
  {
    colKey: 'id',
    title: '登录编号',
  },
  {
    colKey: 'user_id',
    title: '用户ID',
    ellipsis: true,
    cell: 'user_id',
  },
  {
    colKey: 'username',
    title: '账号',
  },
  {
    colKey: 'ip',
    title: '	登录IP',
  },
  {
    colKey: 'create_at',
    title: '	登录时间',
    fixed: 'right',
  },
];
