<template>
  <t-card title="提现记录" :bordered="false">
    <t-base-table :data="lists" :columns="columns" row-key="id" vertical-align="middle" :hover="lists?.length > 0 ? true : false" :pagination="pagination" :loading="dataLoading" :header-affixed-top="headerAffixedTop" max-height="auto" @page-change="rehandlePageChange">
      <template #status="{ row }">
        <t-tag v-if="row.status === 0" theme="primary" variant="outline"> 结算中 </t-tag>
        <t-tag v-if="row.status === 1" theme="success" variant="outline"> 提现成功 </t-tag>
        <t-tag v-else-if="row.status === 2" theme="danger" variant="outline"> 提现失败 </t-tag>
      </template>
      <template #auto_cash="{ row }">
        <span v-if="row.auto_cash === 1">自动提现</span>
        <span v-else>手动提现</span>
      </template>
      <template #create_at="{ row }">
        <span>{{ formatTime(row.create_at) }}</span>
      </template>
      <template #complete_at="{ row }">
        <span v-if="row.complete_at">{{ formatTime(row.complete_at) }}</span>
        <span v-else> 未结算 </span>
      </template>
      <template #empty>
        <result title="" tip="当前没有任何提现记录" type="list"> </result>
      </template>
    </t-base-table>
  </t-card>
</template>

<script lang="ts">
export default {
  name: 'UserCash',
};
</script>

<script setup lang="ts">
import { PrimaryTableCol, TableRowData } from 'tdesign-vue-next';
import { onMounted } from 'vue';

import { index } from '@/api/merchant/finance/cash';
import Result from '@/components/result/index.vue';
import { table } from '@/hooks/table';
import { formatTime } from '@/utils/date';

const columns: PrimaryTableCol<TableRowData>[] = [
  {
    colKey: 'auto_cash',
    title: '提现方式',
    width: '100px',
  },
  {
    colKey: 'create_at',
    title: '提现时间',
    width: '140px',
  },
  {
    colKey: 'money',
    title: '提现金额',
  },
  {
    colKey: 'fee',
    title: '手续费',
  },
  {
    colKey: 'actual_money',
    title: '实际到账',
  },
  {
    colKey: 'status',
    title: '结算状态',
  },

  {
    colKey: 'complete_at',
    title: '结算时间',
    fixed: 'right',
  },
];

const { pagination, fetchData, dataLoading, headerAffixedTop, rehandlePageChange, lists } = table({
  fetchFun: index,
});

onMounted(() => {
  fetchData();
});
</script>
