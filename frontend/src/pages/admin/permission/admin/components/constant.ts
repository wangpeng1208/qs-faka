import { PrimaryTableCol, TableRowData } from 'tdesign-vue-next';

export const columns: PrimaryTableCol<TableRowData>[] = [
  {
    colKey: 'id',
    title: 'ID',
  },
  {
    colKey: 'username',
    title: '用户名',
  },
  {
    colKey: 'avatar',
    title: '头像',
  },
  {
    colKey: 'nickname',
    title: '昵称',
  },
  {
    colKey: 'created_at',
    title: '创建时间',
  },
  {
    colKey: 'operate',
    title: '操作',
  },
];
