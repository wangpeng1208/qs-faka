import { PrimaryTableCol, TableRowData } from 'tdesign-vue-next';

export const columns: PrimaryTableCol<TableRowData>[] = [
  {
    colKey: 'id',
    title: 'ID',
  },
  {
    colKey: 'name',
    title: '名称',
  },
  {
    colKey: 'logo',
    title: 'Logo',
  },
  {
    colKey: 'ico',
    title: '图标',
  },
  {
    colKey: 'operate',
    title: '操作',
    fixed: 'right',
  },
];
