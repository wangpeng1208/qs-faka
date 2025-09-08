import { PrimaryTableCol, TableRowData } from 'tdesign-vue-next';

export const COLUMNS: PrimaryTableCol<TableRowData>[] = [
  {
    colKey: 'id',
    title: 'ID',
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
  },
];
