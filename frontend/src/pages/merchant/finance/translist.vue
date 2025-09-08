<template>
  <t-card title="资金明细" :bordered="false">
    <t-base-table :data="lists" :columns="COLUMNS" row-key="id" vertical-align="middle" :hover="lists?.length > 0 ? true : false" table-layout="auto" max-height="auto" :pagination="pagination" :header-affixed-top="headerAffixedTop" :loading="dataLoading" @page-change="rehandlePageChange">
      <template #create_at="{ row }">
        <span>{{ formatTime(row.create_at) }}</span>
      </template>
      <template #money="{ row }">
        <t-tag v-if="row.money < 0" theme="danger" variant="light">{{ row.money }}</t-tag>
        <t-tag v-else theme="success" variant="light">{{ row.money }}</t-tag>
      </template>
      <template #empty>
        <result title="" tip="流水为空" type="list"> </result>
      </template>
    </t-base-table>
  </t-card>
</template>
<script lang="ts">
export default {
  name: 'FinanceTranslist',
};
</script>

<script setup lang="ts">
import { onMounted } from 'vue';

import { log } from '@/api/merchant/finance/money';
import Result from '@/components/result/index.vue';
import { COLUMNS } from '@/constant/user/money_log/constant';
import { table } from '@/hooks/table';
import { formatTime } from '@/utils/date';

const { pagination, fetchData, dataLoading, headerAffixedTop, rehandlePageChange, lists } = table({
  fetchFun: log,
});

onMounted(() => {
  fetchData();
});
</script>
