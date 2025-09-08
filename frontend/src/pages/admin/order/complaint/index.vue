<template>
  <t-card title="投诉管理" class="basic-container" :bordered="false">
    <div class="category-header c-flex">
      <!-- <div class="l c-flex">
        <t-tag variant="light" theme="success" size="large">未处理投诉数</t-tag>
      </div> -->
      <div class="r c-flex">
        <t-space>
          <t-select v-model="params.status" placeholder="全部状态" type="search" clearable :options="STATUSLIST"></t-select>
          <t-select v-model="params.type" placeholder="全部类型" type="search" clearable :options="TYPELIST"></t-select>
          <t-button theme="primary" @click="searchData">查询</t-button>
        </t-space>
      </div>
    </div>
    <t-base-table :data="lists" :columns="COLUMNS" row-key="id" vertical-align="top" :hover="list?.length > 0 ? true : false" :pagination="pagination" :header-affixed-top="headerAffixedTop" max-height="auto" :loading="dataLoading" @page-change="rehandlePageChange">
      <template #money="{ row }">
        <t-tag v-if="row.money < 0" theme="danger">{{ row.money }}</t-tag>
        <t-tag v-else theme="success">{{ row.money }}</t-tag>
      </template>
      <template #status="{ row }">
        <t-tag v-if="row.status === 0" variant="light" theme="danger">未处理</t-tag>
        <t-tag v-else-if="row.status === 1" variant="light" theme="success">已处理</t-tag>
        <t-tag v-else-if="row.status === -1" variant="light" theme="success">已撤销</t-tag>
      </template>
      <template #admin_read="{ row }">
        <t-tag v-if="row.admin_read === 0" variant="light" theme="danger">未读</t-tag>
        <t-tag v-else-if="row.admin_read === 1" variant="light" theme="success">已读</t-tag>
      </template>
      <template #empty>
        <result title="" tip="暂无投诉" type="list"> </result>
      </template>
      <template #action="{ row }">
        <t-space>
          <t-link theme="primary" @click="detailRow(row.id)">详情</t-link>
          <t-link theme="danger" @click="delRow(row.id)">删除</t-link>
        </t-space>
      </template>
    </t-base-table>
  </t-card>
</template>
<script lang="ts">
export default {
  name: 'ComplaintIndex',
};
</script>

<script setup lang="ts">
import { reactive } from 'vue';
import { useRouter } from 'vue-router';

import { del, list } from '@/api/admin/order/complaint';
import Result from '@/components/result/index.vue';
import { table } from '@/hooks/table';

import { COLUMNS, STATUSLIST, TYPELIST } from './components/constant';

const params = reactive<any>({});
const { pagination, fetchData, dataLoading, headerAffixedTop, rehandlePageChange, lists, searchData } = table({
  fetchFun: list,
  params,
});

fetchData();


const router = useRouter();
const detailRow = (id: number) => {
  router.push({
    name: 'adminOrderComplaint/detail',
    query: {
      id,
    },
  });
};
const delRow = (id: number) => {
  del({ id }).then(() => {
    fetchData();
  });
};
</script>
