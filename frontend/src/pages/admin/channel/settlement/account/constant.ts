import { PrimaryTableCol, TableRowData } from 'tdesign-vue-next';

export const columns: PrimaryTableCol<TableRowData>[] = [
  {
    colKey: 'id',
    title: '账号编号',
  },
  {
    colKey: 'name',
    title: '账号备注',
  },
  {
    colKey: 'code',
    title: '接口代码',
  },
  {
    colKey: 'status',
    title: '状态',
  },
  {
    colKey: 'operate',
    title: '操作',
    fixed: 'right',
  },
];
