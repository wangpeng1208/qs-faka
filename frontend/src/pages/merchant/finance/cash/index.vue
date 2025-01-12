<template>
  <t-card title="提现记录" class="basic-container" :bordered="false">
    <t-base-table :data="list" :columns="columns" :row-key="rowKey" vertical-align="middle" :hover="list.length > 0 ? true : false" :pagination="pagination" :loading="dataLoading" max-height="auto" @page-change="rehandlePageChange" @select-change="rehandleSelectChange">
      <template #status="{ row }">
        <t-tag v-if="row.status == 0" theme="default" variant="light"> 结算中 </t-tag>
        <t-tag v-if="row.status == 1" theme="default" variant="light"> 提现成功 </t-tag>
        <t-tag v-else-if="row.status == 2" theme="danger" variant="light"> 提现失败 </t-tag>
      </template>
      <template #auto_cash="{ row }">
        <span v-if="row.auto_cash == 1">自动结算</span>
        <span v-else>手动结算</span>
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
import { onMounted, reactive, ref } from 'vue';

import { index } from '@/api/merchant/finance/cash';
import Result from '@/components/result/index.vue';
import { formatTime } from '@/utils/date';

const columns: PrimaryTableCol<TableRowData>[] = [
  // {
  //   colKey: 'id',
  //   title: 'ID',
  //   width: '50px',
  // },
  {
    colKey: 'auto_cash',
    title: '提现方式',
    width: '100px',
  },
  {
    colKey: 'create_at',
    title: '发起提现时间',
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

const list = ref([]);
const pagination = ref({
  defaultPageSize: 20,
  total: 1,
  defaultCurrent: 1,
});

const dataLoading = ref(false);
const fetchData = async () => {
  dataLoading.value = true;

  const value = {
    ...searchValue,
    page: pagination.value.defaultCurrent,
    limit: pagination.value.defaultPageSize,
  };
  try {
    const { data } = await index(value);
    list.value = data.list;
    pagination.value = {
      ...pagination.value,
      total: data.total,
    };
  } catch (e) {
    console.log(e);
  } finally {
    dataLoading.value = false;
  }
};
const searchValue = reactive({
  time: [],
});

onMounted(() => {
  fetchData();
});

const selectedRowKeys = ref([]);

const rowKey = 'id';

const rehandleSelectChange = (val: number[]) => {
  selectedRowKeys.value = val;
};
const rehandlePageChange = (curr: any, pageInfo: any) => {
  pagination.value.defaultCurrent = curr.current;
  pagination.value.defaultPageSize = curr.pageSize;
  fetchData();
};
</script>

<style lang="less" scoped>
:deep(.t-table th) {
  padding: var(--td-comp-paddingTB-m) 0;
  &:first-child {
    padding-left: var(--td-comp-paddingTB-m);
  }
}
:deep(.t-table td) {
  padding: var(--td-comp-paddingTB-m) 0;
  &:first-child {
    padding-left: var(--td-comp-paddingTB-m);
  }
}
</style>
