<template>
  <t-row :gutter="[16, 16]">
    <t-col :xs="12" :xl="12">
      <t-card title="最新订单" class="dashboard-rank-card" :bordered="false">
        <t-base-table :data="lists" :columns="ORDER_COLUMNS" row-key="trade_no" max-height="600" :loading="dataLoading" :header-affixed-top="headerAffixedTop" @page-change="rehandlePageChange">
          <template #status="{ row }">
            <t-tag v-if="row.status === 0" variant="light" theme="danger" size="small">未付款</t-tag>
            <t-tag v-else-if="row.status === 1" variant="light" theme="success" size="small">已付款</t-tag>
            <t-tag v-else-if="row.status === 2" variant="light" theme="danger" size="small">已关闭</t-tag>
            <t-tag v-else-if="row.status === 3" variant="light" theme="danger" size="small">已退款</t-tag>
          </template>
          <template #create_at="{ row }">
            {{ formatTime(row.create_at) }}
          </template>
          <template #bottomContent>
            <t-pagination v-if="pagination.total > pagination.defaultPageSize" v-model="pagination.defaultCurrent" v-model:page-size="pagination.defaultPageSize" :total="pagination.total" :show-page-size="false" :total-content="false" style="margin-top: 10px" @current-change="fetchData" />
          </template>
        </t-base-table>
      </t-card>
    </t-col>
  </t-row>
</template>

<script setup lang="ts">
import { list } from '@/api/merchant/order/order';
import { table } from '@/hooks/table';
import { formatTime } from '@/utils/date';

import { ORDER_COLUMNS } from '../constant/index';

const { pagination, fetchData, dataLoading, headerAffixedTop, rehandlePageChange, lists } = table({
  fetchFun: list,
});

fetchData();
</script>
