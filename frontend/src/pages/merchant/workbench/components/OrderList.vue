<template>
  <t-row :gutter="[16, 16]">
    <t-col :xs="12" :xl="12">
      <t-card title="最新订单" class="dashboard-rank-card" :bordered="false">
        <t-base-table :data="orderList" :columns="ORDER_COLUMNS" row-key="trade_no" max-height="600">
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
            <t-pagination v-if="pagination.total > pagination.defaultPageSize" v-model="pagination.defaultCurrent" v-model:pageSize="pagination.defaultPageSize" :total="pagination.total" :show-page-size="false" :total-content="false" style="margin-top: 10px" @current-change="fetchData" />
          </template>
        </t-base-table>
      </t-card>
    </t-col>
  </t-row>
</template>

<script setup lang="ts">
import { ref } from 'vue';

import { list } from '@/api/merchant/order/order';
import { formatTime } from '@/utils/date';

import { ORDER_COLUMNS } from '../constant/index';

const orderList = ref([]);
const pagination = ref({
  defaultPageSize: 10,
  total: 0,
  defaultCurrent: 1,
});
const fetchData = async () => {
  const pageParams = {
    limit: pagination.value.defaultPageSize,
    page: pagination.value.defaultCurrent,
  };
  const { data } = await list(pageParams);
  orderList.value = data.list;
  pagination.value.total = data.total;
};
fetchData();
</script>
