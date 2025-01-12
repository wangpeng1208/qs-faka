import { PrimaryTableCol, TableRowData } from 'tdesign-vue-next';

export const COLUMNS: PrimaryTableCol<TableRowData>[] = [
  {
    colKey: 'trade_no',
    title: '投诉订单',
    ellipsis: true,
  },
  {
    colKey: 'user_id',
    title: '商户ID',
    ellipsis: true,
  },
  {
    colKey: 'username',
    title: '商户账号',
    ellipsis: true,
  },
  {
    colKey: 'type',
    title: '投诉类型',
    ellipsis: true,
  },
  {
    colKey: 'desc',
    title: '投诉说明',
    ellipsis: true,
  },
  {
    colKey: 'qq',
    title: 'QQ',
    ellipsis: true,
  },
  {
    colKey: 'mobile',
    title: '手机',
    ellipsis: true,
  },
  {
    colKey: 'pwd',
    title: '密码',
    ellipsis: true,
  },
  {
    colKey: 'status',
    title: '状态',
    ellipsis: true,
  },
  {
    colKey: 'admin_read',
    title: '读取状态',
    ellipsis: true,
  },
  {
    colKey: 'create_ip',
    title: 'IP',
    ellipsis: true,
  },
  {
    width: 200,
    colKey: 'create_at',
    title: '投诉时间',
  },
  {
    width: 120,
    colKey: 'action',
    title: '操作',
    fixed: 'right',
  },
];

export const STATUSLIST = [
  {
    label: '已处理',
    value: 1,
  },
  {
    label: '未处理',
    value: 2,
  },
  {
    label: '已撤销',
    value: -1,
  },
];

export const TYPELIST = [
  {
    label: '无效卡密',
    value: '无效卡密',
  },
  {
    label: '虚假商品',
    value: '虚假商品',
  },
  {
    label: '非法商品',
    value: '非法商品',
  },
  {
    label: '侵权商品',
    value: '侵权商品',
  },
  {
    label: '不能购买',
    value: '不能购买',
  },
  {
    label: '恐怖色情',
    value: '恐怖色情',
  },
  {
    label: '其他投诉',
    value: '其他投诉',
  },
];
