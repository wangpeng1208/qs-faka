import { PrimaryTableCol, TableRowData } from 'tdesign-vue-next';

export const COLUMNS: PrimaryTableCol<TableRowData>[] = [
  {
    colKey: 'trade_no',
    title: '订单',
  },
  {
    colKey: 'goods_name',
    title: '商品名称',
  },
  {
    colKey: 'total_product_price',
    title: '价格',
  },
  // {
  //   colKey: 'total_price',
  //   title: '实付款',
  // },
  {
    colKey: 'contact',
    title: '联系方式',
  },
  {
    colKey: 'status',
    title: '状态',
  },
  {
    colKey: 'take_status_text',
    title: '取卡状态',
  },
  {
    colKey: 'take_card_password',
    title: '取卡密码',
    width: '100px',
  },
  {
    colKey: 'create_at',
    title: '交易时间',
  },
  {
    colKey: 'operation',
    title: '操作',
    fixed: 'right',
  },
];

export const TYPE = [
  {
    label: '联系方式搜索',
    value: 'contact',
  },
  {
    label: '订单编号搜索',
    value: 'trade_no',
  },
  {
    label: '商品名称搜索',
    value: 'goods_name',
  },
];

export const STATUS = [
  {
    label: '待支付',
    value: 0,
  },
  {
    label: '已支付',
    value: 1,
  },
  {
    label: '已取消',
    value: 2,
  },
  {
    label: '已退款',
    value: 3,
  },
];
