import { PrimaryTableCol, TableRowData } from 'tdesign-vue-next';

export const COLUMNS: PrimaryTableCol<TableRowData>[] = [
  {
    title: '支付方式',
    align: 'left',
    width: '20%',
    colKey: 'title',
  },
  {
    title: '	提交订单数',
    width: '20%',
    colKey: 'count',
  },
  {
    title: '已付订单数',
    colKey: 'paid',
    width: '20%',
  },
  {
    title: '未付订单数',
    colKey: 'unpaid',
    width: '20%',
  },
  {
    title: '订单总金额',
    colKey: 'sum_money',
    width: '20%',
  },
  {
    title: '订单实收金额',
    colKey: 'sum_actual_money',
    width: '20%',
  },
];
