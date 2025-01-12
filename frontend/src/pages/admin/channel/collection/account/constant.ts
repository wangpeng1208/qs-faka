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
    colKey: 'rate_type_text',
    title: '费率设置',
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
export const statusOptions = [
  { label: '启用', value: 1 },
  { label: '禁用', value: 0 },
];
export const rateTypeOptins = [
  { label: '继承接口', value: 0 },
  { label: '单独设置', value: 1 },
];
