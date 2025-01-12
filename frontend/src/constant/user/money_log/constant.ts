import { PrimaryTableCol, TableRowData } from 'tdesign-vue-next';

// import Result from '@/components/result/index.vue';

export const COLUMNS: PrimaryTableCol<TableRowData>[] = [
  {
    width: 200,
    colKey: 'create_at',
    title: '时间',
    ellipsis: true,
    cell: 'create_at',
  },
  {
    width: 120,
    colKey: 'money',
    title: '变动金额',
  },
  {
    width: 120,
    colKey: 'balance',
    title: '变动后余额',
  },
  {
    colKey: 'reason',
    title: '描述',
    cell: 'reason',
    fixed: 'right',
  },
];
