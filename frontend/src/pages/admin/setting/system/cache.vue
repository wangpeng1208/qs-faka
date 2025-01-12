<template>
  <div>
    <t-card title="缓存管理" :bordered="false">
      <t-table size="small" :data="lists" row-key="id" :columns="columns" vertical-align="middle" :loading="dataLoading" :header-affixed-top="headerAffixedTop" table-layout="fixed" max-height="100%">
        <template #value="{ row }">
          {{ formatSize(row.value) }}
        </template>
        <template #opt="{ row }">
          <t-link theme="success" hover="color" @click="clearCacheAc(row.dir)">清空</t-link>
        </template>
      </t-table>
    </t-card>
  </div>
</template>

<script lang="ts">
export default {
  name: 'Environment',
};
</script>

<script setup lang="ts">
import { MessagePlugin, PrimaryTableCol, TableRowData } from 'tdesign-vue-next';

import { cacheList, clearCache } from '@/api/admin/system/system';
import { table } from '@/hooks/table';

const columns: PrimaryTableCol<TableRowData>[] = [
  {
    title: '目录',
    colKey: 'dir',
  },
  {
    title: '名称',
    colKey: 'param',
  },
  {
    colKey: 'value',
    title: '大小',
  },
  {
    title: '操作',
    colKey: 'opt',
  },
];
const { fetchData, dataLoading, headerAffixedTop, lists } = table({
  fetchFun: cacheList,
});
fetchData();

// size转kb  mb  gb
const formatSize = (size: number) => {
  if (size < 1024) {
    return `${size}B`;
  }
  if (size < 1024 * 1024) {
    return `${(size / 1024).toFixed(2)}KB`;
  }
  if (size < 1024 * 1024 * 1024) {
    return `${(size / 1024 / 1024).toFixed(2)}MB`;
  }
  return `${(size / 1024 / 1024 / 1024).toFixed(2)}GB`;
};

const clearCacheAc = async (dir: string) => {
  const res = await clearCache({ dir });
  if (res.code === 1) {
    MessagePlugin.success(res.msg);
    fetchData();
  } else {
    MessagePlugin.error(res.msg);
  }
};
</script>
