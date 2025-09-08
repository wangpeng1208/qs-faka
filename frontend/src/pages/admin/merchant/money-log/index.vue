<template>
  <t-card title="资金日志" class="basic-container" :bordered="false">
    <row-search ref="searchFormRef" @success="fetchSearchData" />
    <t-table :data="lists" :columns="columns" row-key="id" :hover="lists?.length > 0 ? true : false" :pagination="pagination" :header-affixed-top="headerAffixedTop" table-layout="auto" :loading="dataLoading" @page-change="rehandlePageChange">
      <template #money="{ row }">
        <span :style="{ color: row.money > 0 ? '#52c41a' : '#f5222d' }">{{ row.money }}</span>
      </template>
    </t-table>
  </t-card>
</template>
<script setup lang="ts">
import { reactive } from 'vue';

import { list } from '@/api/admin/merchant/money-log';
import { table } from '@/hooks/table';

import { columns } from './components/constant';
import RowSearch from './components/search.vue';

// 搜索
const params = reactive<any>({});

const { pagination, fetchData, dataLoading, headerAffixedTop, rehandlePageChange, lists, searchData } = table({
  fetchFun: list,
  params,
});

const fetchSearchData = (newParams: any) => {
  Object.assign(params, newParams);
  searchData();
};

fetchData();
</script>
