import { PrimaryTableCol, TableRowData } from 'tdesign-vue-next';

import { formatTime } from '@/utils/date';

export const columns: PrimaryTableCol<TableRowData>[] = [
  {
    colKey: 'id',
    title: 'ID',
    width: '80px',
  },
  {
    colKey: 'username',
    title: '账号',
    width: '180px',
  },
  // {
  //   colKey: 'sub_user_count',
  //   title: '下级商户数',
  // },
  // {
  //   colKey: 'is_merchant',
  //   title: '类型',
  // },
  // {
  //   colKey: 'shop_name',
  //   title: '店铺名',
  // },
  {
    colKey: 'mobile',
    title: '手机',
    width: '180px',
  },
  {
    colKey: 'idcard_number',
    title: '身份证号码',
    width: '180px',
  },
  {
    colKey: 'money',
    title: '余额',
    width: '90px',
  },
  {
    colKey: 'freeze_money',
    title: '冻结金额',
    width: '160px',
  },
  // {
  //   colKey: 'rebate',
  //   title: '佣金',
  //   width: '90px',
  // },
  {
    colKey: 'status',
    title: '状态',
    width: '90px',
  },
  {
    colKey: 'is_freeze',
    title: '冻结',
    width: '90px',
  },
  {
    colKey: 'complaint_count',
    title: '投诉数',
    width: '90px',
  },
  {
    colKey: 'create_at',
    title: '注册时间',
    cell(h, props) {
      return h('span', formatTime(props.row.create_at));
    },
    width: '180px',
  },
  {
    colKey: 'operate',
    title: '操作',
    width: '120px',
    fixed: 'right',
  },
];
