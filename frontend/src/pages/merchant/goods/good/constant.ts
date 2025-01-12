import { PrimaryTableCol, TableRowData } from 'tdesign-vue-next';

export const COLUMNS: PrimaryTableCol<TableRowData>[] = [
  {
    colKey: 'name',
    title: '商品名称',
    ellipsis: true,
  },
  {
    colKey: 'cate_name',
    title: '商品分类',
    ellipsis: true,
  },
  {
    colKey: 'price',
    title: '价格(￥)',
    ellipsis: true,
  },
  {
    colKey: 'status',
    title: '上下架',
    ellipsis: true,
  },
  {
    colKey: 'create_at',
    title: '创建时间',
    ellipsis: true,
  },
  {
    colKey: 'operation',
    title: '操作',
    fixed: 'right',
    ellipsis: true,

    minWidth: 200,
  },
];

export const TRUEFALSESWITCH = [
  { label: '开启', value: 1 },
  { label: '关闭', value: 0 },
];

export const SMSPAYER = [
  { label: '商户承担', value: 1 },
  { label: '买家承担', value: 0 },
];

export const CARDORDER = [
  { label: '先售老卡', value: 0 },
  { label: '先售新卡', value: 1 },
  { label: '随机售卡', value: 2 },
  // { label: '自助选号', value: 3 },
];
// take_card_type
export const TAKECARDTYPE = [
  { label: '关闭', value: 0 },
  { label: '选填', value: 1 },
  { label: '必填', value: 2 },
];

// inventory_notify_type
export const INVENTORYNOTIFYTYPE = [
  { label: '站内信', value: 1 },
  { label: '邮件', value: 2 },
  { label: '微信', value: 3 },
];

// contact_limit
export const CONTACTLIMIT = [
  { label: '手机号码', value: 'mobile' },
  { label: 'QQ号码', value: 'qq' },
  // 微信
  { label: '任意字符', value: 'any' },
];
