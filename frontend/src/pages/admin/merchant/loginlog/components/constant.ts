import { PrimaryTableCol, TableRowData } from 'tdesign-vue-next';

export const columns: PrimaryTableCol<TableRowData>[] = [
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
    title: '登录IP',
  },
  // {
  //   colKey: 'ipInfos',
  //   title: '地理位置',
  // },
  {
    colKey: 'create_at',
    title: '登录时间',
  },
];
