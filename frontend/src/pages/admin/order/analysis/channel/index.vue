<template>
  <t-card title="支付渠道分析" class="basic-container" :bordered="false">
    <div class="category-header c-flex">
      <row-search ref="searchFormRef" @success="fetchSearchData" />
    </div>
    <t-base-table :data="lists" :columns="columns" row-key="id" vertical-align="middle" :hover="lists?.length > 0 ? true : false" :pagination="pagination" :header-affixed-top="headerAffixedTop" table-layout="auto" max-height="100%" :loading="dataLoading" @page-change="rehandlePageChange" />
  </t-card>
</template>

<script setup lang="ts">
import { reactive } from 'vue';

import { channel } from '@/api/admin/order/analysis';
import { table } from '@/hooks/table';

import { columns } from './components/constant';
import RowSearch from './components/row-search.vue';

const params = reactive<any>({});
const { pagination, fetchData, dataLoading, headerAffixedTop, rehandlePageChange, lists, searchData } = table({
  fetchFun: channel,
  params,
});

fetchData();

const fetchSearchData = (newParams: any) => {
  Object.assign(params, newParams);
  searchData();
};
</script>
