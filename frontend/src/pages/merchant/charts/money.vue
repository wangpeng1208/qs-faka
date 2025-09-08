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
          <t-select v-model="params.goods_id" placeholder="全部商品" type="search" clearable :options="goodsListOptions" :keys="{ value: 'id', label: 'name' }" />
          <t-button theme="primary" @click="searchData">查询</t-button>
        </t-space>
      </div>
    </div>

    <t-base-table :data="lists" :columns="COLUMNS" row-key="id" vertical-align="top" :hover="lists?.length > 0 ? true : false" :pagination="pagination" :loading="dataLoading" table-layout="auto" max-height="auto" :header-affixed-top="headerAffixedTop" @page-change="rehandlePageChange">
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
import { onMounted, reactive, ref } from 'vue';

import { getChartsMoney, getChartsRankList } from '@/api/merchant/charts/charts';
import { listSimple } from '@/api/merchant/goods/category';
import { goodList } from '@/api/merchant/goods/good';
import Result from '@/components/result/index.vue';
import { COLUMNS } from '@/constant/charts/money/constant';
import { table } from '@/hooks/table';
import { formatMoney } from '@/utils/common';
import { formatTime } from '@/utils/date';

const params = reactive<any>({});
const { pagination, fetchData, dataLoading, headerAffixedTop, rehandlePageChange, lists, searchData } = table({
  fetchFun: getChartsMoney,
  params,
});

// 列表数据
const charts = reactive({
  total_price: 0,
  total_cost_price: 0,
  total_profit: 0,
});

const fetchChartsRankList = async () => {
  const { data } = await getChartsRankList();
  Object.assign(charts, data);
};
fetchChartsRankList();

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
