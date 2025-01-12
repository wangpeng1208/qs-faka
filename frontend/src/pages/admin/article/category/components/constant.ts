import { PrimaryTableCol, TableRowData } from 'tdesign-vue-next';

import { formatTime } from '@/utils/date';

export const columns: PrimaryTableCol<TableRowData>[] = [
  {
    colKey: 'id',
    title: 'ID',
  },
  {
    colKey: 'name',
    title: '名称',
  },
  {
    colKey: 'alias',
    title: '别名',
  },
  {
    colKey: 'type',
    title: '类型',
    cell(h, props) {
      let typeLabel = '';
      switch (props.row.type) {
        case 1:
          typeLabel = '前台列表';
          break;
        case 2:
          typeLabel = '后台列表';
          break;
        default:
          typeLabel = '单页';
          break;
      }
      return h('span', typeLabel);
    },
  },
  {
    colKey: 'status',
    title: '状态',
  },
  {
    colKey: 'create_at',
    title: '添加时间',
    cell(h, props) {
      return h('span', formatTime(props.row.create_at));
    },
  },
  {
    colKey: 'operate',
    title: '操作',
    fixed: 'right',
  },
];

export const statusOptions = [
  {
    label: '正常',
    value: 1,
  },
  {
    label: '禁用',
    value: 0,
  },
];

export const typeOptions = [
  {
    label: '前台列表',
    value: 1,
  },
  {
    label: '后台列表',
    value: 2,
  },
  {
    label: '单页',
    value: 3,
  },
];
