<template>
  <t-card title="付款方式" :bordered="false" class="basic-container">
    <t-base-table :columns="columns" row-key="id" :data="lists" class="basic-table">
      <template #title="{ row }">
        <t-space size="small">
          <t-image :src="baseUrl + row.ico" fit="cover" :style="{ width: '21px', height: '21px' }" />
          <span>{{ row.show_name }}</span>
        </t-space>
      </template>
      <template #rate="{ row }">
        <t-space>
          <span>{{ row.rate * 100 }}%</span>
        </t-space>
      </template>
      <template #status="{ row }">
        <!-- 状态变更 -->
        <t-switch v-model="row.status" :custom-value="[1, 0]" disabled />
      </template>
    </t-base-table>
  </t-card>
</template>
<script lang="ts">
export default {
  name: 'Payment',
};
</script>
<script setup lang="ts">
import { ref } from 'vue';

import { baseUrl } from '@/api/base';
import { list } from '@/api/merchant/user/payment';

const columns = [
  {
    width: 200,
    colKey: 'title',
    title: '通道名称',
    ellipsis: true,
    cell: 'title',
  },
  {
    width: 120,
    colKey: 'type_text',
    title: '场景',
  },
  {
    width: 120,
    colKey: 'rate',
    title: '平台收取',
  },
  {
    width: 120,
    colKey: 'status',
    title: '当前状态',
  },
];
const lists = ref();
// 获取商户收款渠道列表
const fetchData = async () => {
  const { data } = await list();
  lists.value = data;
};
fetchData();
</script>