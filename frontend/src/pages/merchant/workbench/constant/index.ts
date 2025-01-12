import { PrimaryTableCol, TableRowData } from 'tdesign-vue-next';

interface DashboardPanel {
  title: string;
  number: any;
  tip?: string;
}

export const PANE_LIST: Array<DashboardPanel> = [
  {
    title: '可提现余额',
    number: 0.0,
    tip: '',
  },
  {
    title: '冻结金额',
    number: 0.0,
    tip: '未结余额',
  },
  {
    title: '今日流水',
    number: 0.0,
    tip: '今日流水金额',
  },
  {
    title: '今日利润',
    number: 0.0,
    tip: '今日利润 = 今日流水 - 今日成本',
  },
  {
    title: '昨日流水',
    number: 0.0,
    tip: '昨日流水',
  },
  {
    title: '昨日利润',
    number: 0.0,
    tip: '昨日利润 = 昨日流水 - 昨日成本',
  },
  // {
  //   title: '今日订单',
  //   number: 0,
  //   tip: '今日订单数量',
  // },
];

export const ORDER_COLUMNS: PrimaryTableCol<TableRowData>[] = [
  {
    title: '订单号',
    colKey: 'trade_no',
    width: 200,
    align: 'left',
  },
  {
    title: '商品名称',
    colKey: 'goods_name',
    width: 200,
    align: 'left',
  },
  {
    title: '客户信息',
    colKey: 'contact',
    width: 100,
    align: 'left',
  },
  {
    title: '交易金额',
    colKey: 'total_price',
    width: 100,
    align: 'left',
  },
  {
    title: '下单时间',
    colKey: 'create_at',
    width: 200,
    align: 'left',
  },
  {
    title: '状态',
    colKey: 'status',
    width: 100,
    align: 'left',
  },
];
