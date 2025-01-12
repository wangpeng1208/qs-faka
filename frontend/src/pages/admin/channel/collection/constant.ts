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
  // paytype
  {
    colKey: 'paytype',
    title: '分类',
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
    colKey: 'lowrate',
    title: '费率',
    cell: (h, { row }) => `${(row.lowrate * 1000).toFixed(2)}‰`,
  },
  {
    colKey: 'status',
    title: '状态',
  },
  {
    colKey: 'is_available',
    title: '平台',
  },
  {
    colKey: 'sort',
    title: '排序',
  },
  {
    colKey: 'operate',
    title: '操作',
    fixed: 'right',
  },
];
