import { PrimaryTableCol, TableRowData } from 'tdesign-vue-next';

import { formatTime } from '@/utils/date';

export const importType = [
  {
    label: '元',
    value: 1,
  },
  {
    label: '%',
    value: 100,
  },
];

export const importCoupon = [
  {
    label: '不导出',
    value: 0,
  },
  {
    label: 'TXT格式',
    value: 1,
  },
  {
    label: 'Excel格式',
    value: 2,
  },
];

export const listsColumns: PrimaryTableCol<TableRowData>[] = [
  {
    colKey: 'id',
    type: 'multiple',
  },
  {
    colKey: 'cate_name',
    title: '商品分类',
    fixed: 'left',
  },
  {
    colKey: 'code',
    title: '优惠券',
  },
  {
    colKey: 'amount',
    title: '面额',
  },
  {
    colKey: 'create_at',
    title: '生成时间',
    cell(h, props) {
      return h('span', formatTime(props.row.create_at));
    },
  },
  {
    colKey: 'status',
    title: '有效期',
  },
  {
    colKey: 'min_banlance',
    title: '使用条件',
  },
  {
    colKey: 'remark',
    title: '备注',
  },
];
export const statusList = [
  {
    label: '已售出',
    value: 2,
  },
  {
    label: '未售出',
    value: 1,
  },
];

export const trashListsColumns: PrimaryTableCol<TableRowData>[] = [
  {
    colKey: 'id',
    type: 'multiple',
    width: '5%',
  },
  {
    colKey: 'cate_name',
    title: '商品分类',
    fixed: 'left',
    width: '10%',
  },
  {
    colKey: 'code',
    title: '优惠券',
    width: '15%',
  },
  {
    colKey: 'amount',
    title: '面额',
    width: '8%',
  },
  {
    colKey: 'create_at',
    title: '生成时间',
    width: '15%',
  },
  {
    colKey: 'status',
    title: '有效期',
    width: '10%',
  },
  {
    colKey: 'remark',
    title: '备注',
    width: '10%',
  },
  {
    colKey: 'operation',
    title: '操作',
    width: '10%',
    cell: 'operation',
    fixed: 'right',
  },
];
