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
    colKey: 'remark',
    title: '备注',
  },
  {
    colKey: 'operate',
    title: '操作',
  },
];
