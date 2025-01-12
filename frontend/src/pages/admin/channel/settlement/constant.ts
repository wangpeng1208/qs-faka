import { PrimaryTableCol, TableRowData } from 'tdesign-vue-next';

export const columns: PrimaryTableCol<TableRowData>[] = [
  {
    colKey: 'id',
    title: '通道ID',
  },
  {
    colKey: 'title',
    title: '名称',
  },
  {
    colKey: 'code',
    title: '接口代码',
  },
  {
    colKey: 'show_name',
    title: '显示名称',
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
