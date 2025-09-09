<template>
  <t-card title="后台操作日志" class="basic-container" :bordered="false">
    <row-search ref="searchFormRef" @success="fetchSearchData" />
    <div class="table-header">
      <t-button v-perms="['adminapi/permission/log/delBatch']" theme="danger" :disabled="!selectedRowKeys.length" @click="batchDel"> 批量删除 </t-button>
      <p v-if="!!selectedRowKeys.length" class="selected-count">已选{{ selectedRowKeys.length }}项</p>
    </div>
    <t-table row-key="id" :data="lists" :columns="columns" :hover="lists?.length > 0 ? true : false" :header-affixed-top="headerAffixedTop" :pagination="pagination" table-layout="auto" max-height="100%" :selected-row-keys="selectedRowKeys" :loading="dataLoading" @page-change="rehandlePageChange" @select-change="rehandleSelectChange">
      <template #operate="{ row }">
        <t-button theme="primary" variant="text" size="small" @click="showDetail(row)"> 详情 </t-button>
      </template>
    </t-table>

    <log-detail ref="detailRef" />
  </t-card>
</template>
<script setup lang="ts">
import { reactive, ref } from 'vue';

import { list } from '@/api/admin/permission/log';
import { table } from '@/hooks/table';
import { useBatchAction } from '@/hooks/useBatchAction';

import { columns } from './components/constant';
import LogDetail from './components/detail.vue';
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

// 详情弹窗
const detailRef = ref<InstanceType<typeof LogDetail>>();
const showDetail = (row: any) => {
  detailRef.value?.init(row);
};
</script>
<style lang="less" scoped>
.table-header {
  margin: 16px 0;
  display: flex;
  align-items: center;
  gap: 8px;
}

.selected-count {
  color: var(--td-text-color-secondary);
  margin: 0;
}
</style>
