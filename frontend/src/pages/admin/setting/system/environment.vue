<template>
  <div>
    <t-card title="服务器信息" :bordered="false">
      <t-table size="small" :data="lists?.server" row-key="id" :columns="servercolumns" vertical-align="middle" :loading="dataLoading" :header-affixed-top="headerAffixedTop" table-layout="fixed" max-height="100%" />
    </t-card>
    <t-card title="PHP环境要求" :bordered="false">
      <t-table size="small" :data="lists?.env" row-key="id" :columns="envcolumns" vertical-align="middle" :loading="dataLoading" :header-affixed-top="headerAffixedTop" table-layout="fixed" max-height="100%" />
    </t-card>
    <t-card title="目录权限" :bordered="false">
      <t-table size="small" :data="lists?.auth" row-key="id" :columns="authcolumns" vertical-align="middle" :loading="dataLoading" :header-affixed-top="headerAffixedTop" table-layout="fixed" max-height="100%" />
    </t-card>
  </div>
</template>

<script lang="ts">
export default {
  name: 'Environment',
};
</script>

<script setup lang="ts">
import { PrimaryTableCol, TableRowData, Tag } from 'tdesign-vue-next';

import { getInfo } from '@/api/admin/system/system';
import { table } from '@/hooks/table';

const servercolumns: PrimaryTableCol<TableRowData>[] = [
  {
    title: '服务器信息',
    colKey: 'param',
  },
  {
    title: '服务器值',
    colKey: 'value',
  },
];
const envcolumns: PrimaryTableCol<TableRowData>[] = [
  {
    title: '选项',
    colKey: 'option',
  },
  {
    title: '要求',
    colKey: 'require',
  },
  {
    title: '状态',
    colKey: 'status',
    cell: (h, { row }) => {
      return h(
        Tag,
        {
          variant: 'light',
          theme: row.status === true ? 'success' : 'danger',
        },
        () => (row.status === true ? '正常' : '禁用'),
      );
    },
  },
  {
    title: '说明',
    colKey: 'remark',
  },
];
const authcolumns: PrimaryTableCol<TableRowData>[] = [
  {
    title: '目录',
    colKey: 'dir',
  },
  {
    title: '要求',
    colKey: 'require',
  },
  {
    colKey: 'status',
    title: '状态',
    cell: (h, { row }) => {
      return h(
        Tag,
        {
          variant: 'light',
          theme: row.status === true ? 'success' : 'danger',
        },
        () => (row.status === true ? '可写' : '不可写'),
      );
    },
  },
  {
    title: '说明',
    colKey: 'remark',
  },
];
const { fetchData, dataLoading, headerAffixedTop, lists } = table({
  fetchFun: getInfo,
});
fetchData();
</script>
