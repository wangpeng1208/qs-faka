import { PrimaryTableCol, TableRowData } from 'tdesign-vue-next';

export const columns: PrimaryTableCol<TableRowData>[] = [
  {
    colKey: 'id',
    title: 'ID',
  },
  {
    colKey: 'username',
    title: '商户账号',
  },
  {
    colKey: 'hander',
    title: '操作人',
    width: '100px',
  },
  {
    colKey: 'business_type',
    title: '类型',
    width: '120px',
  },
  {
    colKey: 'money',
    title: '资金变动',
    width: '100px',
  },
  {
    colKey: 'balance',
    title: '剩余金额',
    width: '100px',
  },
  {
    colKey: 'reason',
    title: '说明',
  },
  {
    colKey: 'create_at',
    title: '变动时间',
    width: '160px',
  },
];
