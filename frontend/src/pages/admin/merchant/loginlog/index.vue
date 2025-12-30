<template>
  <t-card title="登录日志" class="basic-container" :bordered="false">
    <row-search ref="searchFormRef" @success="fetchSearchData" />
    <t-table :data="lists" :columns="columns" row-key="id" :hover="lists?.length > 0 ? true : false" :pagination="pagination" :header-affixed-top="headerAffixedTop" table-layout="auto" max-height="auto" :loading="dataLoading" @page-change="rehandlePageChange" />
  </t-card>
</template>
<script setup lang="ts">
import { reactive } from 'vue';

import { loginlog } from '@/api/admin/merchant/user';
import { table } from '@/hooks/table';

import { columns } from './components/constant';
import RowSearch from './components/search.vue';

const params = reactive<any>({});

const { pagination, fetchData, dataLoading, headerAffixedTop, rehandlePageChange, lists, searchData } = table({
  fetchFun: loginlog,
  params,
});

const fetchSearchData = (newParams: any) => {
  Object.assign(params, newParams);
  searchData();
};

fetchData();
</script>
