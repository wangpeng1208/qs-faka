<template>
  <t-card title="商户支付分析" class="basic-container" :bordered="false">
    <row-search @success="fetchSearchData" />
    <t-base-table :data="lists" :columns="columns" row-key="id" vertical-align="middle" :hover="lists?.length > 0 ? true : false" :pagination="pagination" :header-affixed-top="headerAffixedTop" table-layout="auto" max-height="100%" :loading="dataLoading" @page-change="rehandlePageChange" />

    <rank-card style="margin-bottom: 20px" />
  </t-card>
</template>

<script setup lang="ts">
import { reactive } from 'vue';

import { merchant } from '@/api/admin/order/analysis';
import { table } from '@/hooks/table';
import RankCard from '@/pages/admin/workbench/components/RankCard.vue';

import { columns } from './components/constant';
import RowSearch from './components/row-search.vue';

const params = reactive<any>({});
const { pagination, fetchData, dataLoading, headerAffixedTop, rehandlePageChange, lists, searchData } = table({
  fetchFun: merchant,
  params,
});

fetchData();

const fetchSearchData = (newParams: any) => {
  Object.assign(params, newParams);
  searchData();
};
</script>
