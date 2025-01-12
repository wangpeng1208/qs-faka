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
      <!-- is_custom -->
      <template #is_custom="{ row }">
        <span v-if="row.is_custom == 0">平台</span>
        <span v-else>自定义</span>
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
  {
    width: 120,
    colKey: 'is_custom',
    title: '通道',
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
<style lang="less" scoped>
.buy-tag {
  width: 100%;
  padding: var(--td-comp-paddingTB-l) var(--td-comp-paddingTB-s);
}

.basic-table {
  border: 8px solid var(--td-brand-color-1);
  display: inline-block;
  width: 100%;
  margin-top: var(--td-comp-paddingTB-l);
  min-width: 700px;
}
:deep(.t-card--bordered) {
  border: 8px solid var(--td-brand-color-1);
}

.money {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 20px;
  padding: 0 20px;
  .money-item {
    display: flex;
    align-items: center;
    .money-title {
      margin-right: 10px;
    }
  }
}
</style>
