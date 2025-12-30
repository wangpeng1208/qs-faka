import type { PrimaryTableCol, TableRowData } from 'tdesign-vue-next';
import { computed } from 'vue';

import { getModulesKey } from '@/router/index';

export const columns: PrimaryTableCol<TableRowData>[] = [
  {
    colKey: 'title',
    title: '标题',
  },
  {
    colKey: 'icon',
    title: '图标',
  },
  {
    colKey: 'path',
    title: '路由地址',
  },
  // {
  //   colKey: 'component',
  //   title: '组件',
  // },
  {
    colKey: 'perms',
    title: '权限字符',
  },
  {
    colKey: 'orderNo',
    title: '排序',
  },
  {
    colKey: 'hidden',
    title: '隐藏',
  },
  {
    colKey: 'type',
    title: '类型',
  },
  {
    colKey: 'operate',
    title: '操作',
  },
];

export const isHiddenOptions = [
  {
    label: '显示',
    value: 0,
  },
  {
    label: '隐藏',
    value: 1,
  },
];

export const typeOptions = [
  {
    label: '目录',
    value: 'L',
  },
  {
    label: '菜单',
    value: 'M',
  },
  {
    label: '按钮',
    value: 'B',
  },
];

export const keepAliveOptions = [
  {
    label: '缓存',
    value: 1,
  },
  {
    label: '不缓存',
    value: 0,
  },
];

export const componentsOptions = computed(() => {
  // 以admin/开头的组件 且不包含 /components/ 的组件
  const modules = getModulesKey();
  const components = modules
    .filter((item) => item.startsWith('admin/'))
    .filter((item) => !item.includes('/components/'))
    .map((item) => {
      return {
        label: item,
        value: item,
      };
    });
  return components;
});
