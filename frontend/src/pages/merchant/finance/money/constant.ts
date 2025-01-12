import { PrimaryTableCol, TableRowData } from 'tdesign-vue-next';

export const COLUMNS: PrimaryTableCol<TableRowData>[] = [
  {
    colKey: 'trade_no',
    title: '充值订单',
  },
  {
    colKey: 'order_title',
    title: '名称',
  },
  {
    colKey: 'total_price',
    title: '金额',
    width: '120px',
  },
  {
    colKey: 'status',
    title: '状态',
    width: '120px',
  },
  {
    colKey: 'create_at',
    title: '交易时间',
    width: '180px',
  },
  {
    colKey: 'pay_at',
    title: '付款时间',
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
