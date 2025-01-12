<template>
  <t-card title="收益统计" class="basic-container" :bordered="false">
    <div class="category-header c-flex">
      <div class="l c-flex">
        <t-space>
          <t-tag variant="light" theme="success" size="large">总收入{{ formatMoney(charts.total_price) }}</t-tag>
          <t-tag variant="light" theme="success" size="large">总成本{{ formatMoney(charts.total_cost_price) }}</t-tag>
          <t-tag variant="light" theme="success" size="large">总利润{{ formatMoney(charts.total_profit) }}</t-tag>
        </t-space>
      </div>
      <div class="r c-flex">
        <t-space>
          <t-select v-model="searchValue.goods_id" placeholder="全部商品" type="search" clearable :options="goodsListOptions" :keys="{ value: 'id', label: 'name' }" />
          <t-button theme="default" variant="outline" @click="fetchData">查询</t-button>
        </t-space>
      </div>
    </div>

    <t-base-table :data="list" :columns="COLUMNS" :row-key="rowKey" vertical-align="top" :hover="list.length > 0 ? true : false" :pagination="pagination" :selected-row-keys="selectedRowKeys" :loading="dataLoading" table-layout="auto" max-height="auto" :header-affixed-top="headerAffixedTop" @page-change="rehandlePageChange" @change="rehandleChange" @select-change="rehandleSelectChange">
      <template #status="{ row }">
        <t-tag v-if="row.status === 0" variant="light" theme="danger">未付款</t-tag>
        <t-tag v-else-if="row.status === 1" variant="light" theme="success">已付款</t-tag>
      </template>
      <template #task_status="{ row }">
        <t-tag v-if="row.task_status !== '已取'" variant="light" theme="danger">未取</t-tag>
        <t-tag v-else-if="row.task_status === '已取'" variant="light" theme="success">已取</t-tag>
      </template>
      <template #create_at="{ row }">
        <span>{{ formatTime(row.create_at) }}</span>
      </template>
      <template #empty>
        <result title="" tip="相关数据为空" type="list"> </result>
      </template>
    </t-base-table>
  </t-card>
</template>

<script lang="ts">
export default {
  name: 'FinanceMoney',
};
</script>

<script setup lang="ts">
import { computed, onMounted, reactive, ref } from 'vue';

import { getChartsMoney } from '@/api/merchant/charts/charts';
import { listSimple } from '@/api/merchant/goods/category';
import { goodList } from '@/api/merchant/goods/good';
import Result from '@/components/result/index.vue';
import { prefix } from '@/config/global';
import { COLUMNS } from '@/constant/charts/money/constant';
import { useSettingStore } from '@/store';
import { formatMoney } from '@/utils/common';
import { formatTime } from '@/utils/date';

const store = useSettingStore();

const searchValue = reactive({
  cate_id: '',
  goods_id: '',
});

const rowKey = 'id';
const pagination = ref({
  defaultPageSize: 10,
  total: 0,
  defaultCurrent: 1,
});
// 列表数据
const list = ref([]);
const charts = reactive({
  total_price: 0,
  total_cost_price: 0,
  total_profit: 0,
});
const dataLoading = ref(false);
const fetchData = async () => {
  dataLoading.value = true;
  const value = {
    page: pagination.value.defaultCurrent,
    limit: pagination.value.defaultPageSize,
    ...searchValue,
  };
  try {
    const { data } = await getChartsMoney(value);
    list.value = data.list;
    charts.total_cost_price = data.charts.total_cost_price;
    charts.total_price = data.charts.total_price;
    charts.total_profit = data.charts.total_profit;
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

const categoryList = ref([]);
const fetchGoodsCategory = async () => {
  const { data } = await listSimple();
  categoryList.value = data.list;
};
const goodsListOptions = ref([]);
const fetchGoodsList = async () => {
  const { data } = await goodList();
  goodsListOptions.value = data;
};

onMounted(() => {
  fetchData();
  fetchGoodsCategory();
  fetchGoodsList();
});

const selectedRowKeys = ref([]);
// 勾选selectedRowKeys变化
const rehandleSelectChange = (val: number[]) => {
  selectedRowKeys.value = val;
};

const rehandlePageChange = (curr: any, pageInfo: any) => {
  pagination.value.defaultCurrent = curr.current;
  pagination.value.defaultPageSize = curr.pageSize;
  fetchData();
};
const rehandleChange = (changeParams: any, triggerAndData: any) => {};

const headerAffixedTop = computed(() => ({
  offsetTop: store.isUseTabsRouter ? 48 : 0,
  container: `.${prefix}-layout`,
}));
</script>

<style lang="less" scoped>
.c-flex {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.category-header {
  color: var(--td-text-color-secondary);
  padding-bottom: var(--td-comp-paddingTB-m);
  .l {
    float: left;
  }
  .r {
    float: right;
  }
}
</style>
