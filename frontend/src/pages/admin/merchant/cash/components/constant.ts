import { PrimaryTableCol, TableRowData, Tag } from 'tdesign-vue-next';

import { formatTime } from '@/utils/date';

export const columns: PrimaryTableCol<TableRowData>[] = [
  {
    colKey: 'id',
    type: 'multiple',
  },
  {
    colKey: 'username',
    title: '商户账号',
    width: '160px',
  },
  {
    colKey: 'type',
    title: '收款类型',
    width: '120px',
    cell: (h, { row }) => typeOptions.find((t) => t.value === row.type)?.label,
  },
  {
    colKey: 'money',
    width: '160px',
    title: '提现金额（元）',
  },
  {
    colKey: 'actual_money',
    width: '160px',
    title: '实际到账（元）',
  },
  {
    colKey: 'status',
    title: '状态',
    cell: (h, { row }) => {
      const statusOption = statusOptions.find((t) => t.value === row.status);
      return h(
        Tag,
        {
          theme: statusOption.theme,
          variant: 'light',
          shape: 'round',
        },
        () => statusOption?.label,
      );
    },
  },
  {
    colKey: 'fee',
    title: '手续费',
  },
  {
    colKey: 'create_at',
    title: '创建时间',
    width: '180px',
    cell: (h, { row }) => formatTime(row.create_at),
  },
  {
    colKey: 'complete_at',
    title: '操作时间',
    width: '180px',
    cell: (h, { row }) => {
      if (row.complete_at) {
        return formatTime(row.complete_at);
      }
      return '-';
    },
  },
  {
    colKey: 'operate',
    title: '操作',
    width: '180px',
    fixed: 'right',
  },
];

export const typeOptions = [
  {
    label: '支付宝',
    value: 1,
  },
  {
    label: '微信',
    value: 2,
  },
  {
    label: '银行卡',
    value: 3,
  },
];
interface StatusOption {
  value: number;
  label: string;
  theme: 'default' | 'primary' | 'warning' | 'danger' | 'success';
}

export const statusOptions: StatusOption[] = [
  {
    label: '待审核',
    value: 0,
    theme: 'warning',
  },
  {
    label: '审核通过',
    value: 1,
    theme: 'success',
  },
  {
    label: '审核不通过',
    value: 2,
    theme: 'danger',
  },
];
