import { PrimaryTableCol, TableRowData, Tag } from 'tdesign-vue-next';

import { formatTime } from '@/utils/date';

export const columns: PrimaryTableCol<TableRowData>[] = [
  {
    colKey: 'id',
    title: 'ID',
  },
  {
    colKey: 'cate_name',
    title: '分类',
  },
  {
    colKey: 'title',
    title: '名称',
  },
  {
    colKey: 'views',
    title: '浏览量',
  },
  {
    colKey: 'status',
    title: '状态',
    cell: (h, { row }) => {
      return h(
        Tag,
        {
          variant: 'light',
          theme: row.status === 1 ? 'success' : 'danger',
        },
        () => (row.status === 1 ? '正常' : '禁用'),
      );
    },
  },
  {
    colKey: 'top',
    title: '置顶',
    cell: (h, { row }) => {
      return row.top ? '是' : '否';
    },
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

export const topOptions = [
  {
    label: '是',
    value: 1,
  },
  {
    label: '否',
    value: 0,
  },
];
