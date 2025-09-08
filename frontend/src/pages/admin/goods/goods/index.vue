<template>
  <t-card title="商品管理" :bordered="false">
    <div class="category-header c-flex">
      <row-search ref="searchFormRef" @success="search" />
    </div>
    <t-table :data="lists" :columns="columns" row-key="id" :expand-on-row-click="false" :hover="lists?.length > 0 ? true : false" :pagination="pagination" :header-affixed-top="headerAffixedTop" table-layout="auto" max-height="100%" :loading="dataLoading" @page-change="rehandlePageChange">
      <template #status="{ row }">
        <t-tag v-if="row.status === 1" theme="success">启用</t-tag>
        <t-tag v-else theme="danger">禁用</t-tag>
      </template>
      <template #freeze="{ row }">
        <t-link v-if="row.delete_at == null" v-perms="['adminapi/goods/goods/freeze']" theme="primary" size="small" @click="freezeRow(row.id)">
          {{ row.is_freeze === 1 ? '解冻' : '冻结' }}
        </t-link>
      </template>
      <template #operate="{ row }">
        <t-space>
          <t-link v-if="row.delete_at == null" v-perms="['adminapi/goods/goods/status']" theme="primary" size="small" @click="statusRow(row.id)">
            {{ row.status === 1 ? '下架' : '上架' }}
          </t-link>
          <t-link v-perms="['adminapi/goods/goods/del']" theme="danger" size="small" @click="deleteRow(row.id, 0)">
            {{ row.delete_at ? '恢复' : '放回收站' }}
          </t-link>
          <t-link v-perms="['adminapi/goods/goods/del']" theme="danger" size="small" @click="deleteRow(row.id, 1)"> 删除 </t-link>
        </t-space>
      </template>
    </t-table>
  </t-card>
</template>
<script setup lang="ts">
import { MessagePlugin } from 'tdesign-vue-next';
import { reactive } from 'vue';

import { del, freeze, list, status } from '@/api/admin/goods/goods';
import { table } from '@/hooks/table';

import { columns } from './constant';
import RowSearch from './search.vue';

const searchParams = reactive<any>({});

const { pagination, fetchData, dataLoading, headerAffixedTop, rehandlePageChange, lists, searchData } = table({
  fetchFun: list,
  params: searchParams,
});

fetchData();

const search = (params = {}) => {
  Object.assign(searchParams, params);
  searchData();
};

const executeAction = async (action: Function, id: number, val?: number) => {
  const params = val !== undefined ? { id, val } : { id };
  const res = await action(params);
  if (res.code === 1) {
    MessagePlugin.success(res.msg);
    fetchData();
    return;
  }
  MessagePlugin.error(res.msg);
};

const deleteRow = (id: number, val = 0) => executeAction(del, id, val);
const freezeRow = (id: number) => executeAction(freeze, id);
const statusRow = (id: number) => executeAction(status, id);
</script>
