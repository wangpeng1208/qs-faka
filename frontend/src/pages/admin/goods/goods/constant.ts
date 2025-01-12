import { PrimaryTableCol, TableRowData } from 'tdesign-vue-next';

export const columns: PrimaryTableCol<TableRowData>[] = [
  {
    colKey: 'id',
    title: 'ID',
    ellipsis: true,
  },
  {
    colKey: 'username',
    title: '商户账号',
    ellipsis: true,
  },
  {
    colKey: 'name',
    title: '商品名称',
    ellipsis: true,
  },
  {
    colKey: 'price',
    title: '商品价格',
    ellipsis: true,
  },
  {
    colKey: 'freeze',
    title: '冻结',
  },
  {
    colKey: 'operate',
    title: '操作',
    ellipsis: true,
  },
];
