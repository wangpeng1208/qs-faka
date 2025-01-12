import { PrimaryTableCol, TableRowData } from 'tdesign-vue-next';

export const COLUMNS: PrimaryTableCol<TableRowData>[] = [
  // { colKey: 'row-select', type: 'multiple', width: 64, fixed: 'left' },
  // {
  //   title: 'ID',
  //   align: 'left',
  //   width: 100,
  //   colKey: 'id',
  // },
  {
    title: '订单号',
    align: 'left',
    colKey: 'trade_no',
  },
  {
    title: '商品名称',
    colKey: 'goods_name',
  },
  {
    title: '支付方式',
    colKey: 'paytype',
  },
  {
    title: '总价',
    colKey: 'total_product_price',
  },
  {
    title: '购买者信息',
    colKey: 'contact',
  },
  {
    title: '状态',
    colKey: 'status',
  },
  {
    title: '取卡状态',
    colKey: 'task_status',
  },

  {
    title: '创建时间',
    ellipsis: true,
    colKey: 'create_at',
  },
];
