<template>
  <t-card title="后台操作日志" class="basic-container" :bordered="false">
    <row-search ref="searchFormRef" @success="fetchSearchData" />
    <div class="category-header c-flex">
      <div class="l">
        <t-button v-perms="['adminapi/permission/log/delBatch']" theme="danger" :disabled="!selectedRowKeys.length" @click="batchDel"> 批量删除 </t-button>
        <p v-if="!!selectedRowKeys.length" class="selected-count">已选{{ selectedRowKeys.length }}项</p>
      </div>
    </div>
    <t-table row-key="id" :data="lists" :columns="columns" :hover="lists?.length > 0 ? true : false" :header-affixed-top="headerAffixedTop" :pagination="pagination" table-layout="auto" max-height="100%" :selected-row-keys="selectedRowKeys" :loading="dataLoading" @page-change="rehandlePageChange" @select-change="rehandleSelectChange"> </t-table>
  </t-card>
</template>
<script setup lang="ts">
import { reactive, ref } from 'vue';

import { list } from '@/api/admin/permission/log';
import { table } from '@/hooks/table';
import { useBatchAction } from '@/hooks/useBatchAction';

import { columns } from './components/constant';
import RowSearch from './components/search.vue';

const selectedRowKeys = ref<number[]>([]);

const rehandleSelectChange = (val: number[]) => {
  selectedRowKeys.value = val;
};

// 批量删除
const batchDel = async () => {
  useBatchAction({
    title: '提醒',
    body: `是否确认删除？`,
    ids: selectedRowKeys.value,
    url: '/adminapi/permission/log/delBatch',
    fetchList: () => {
      fetchData();
      selectedRowKeys.value = [];
    },
  });
};

const params = reactive<any>({});

const { pagination, fetchData, dataLoading, headerAffixedTop, rehandlePageChange, lists, searchData } = table({
  fetchFun: list,
  params,
});

fetchData();

const fetchSearchData = (newParams: any) => {
  Object.assign(params, newParams);
  searchData();
};
</script>
<style lang="less" scoped>
.selected-count {
  display: inline-block;
  margin-left: 8px;
  color: var(--td-text-color-secondary);
}
</style>
