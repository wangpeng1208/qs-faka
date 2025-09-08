<template>
  <t-card title="累计消费" class="basic-container" :bordered="false">
    <div class="category-header c-flex">
      <t-space>
        <t-input v-model="params.keywords" placeholder="请输入联系方式" clearable>
          <template #suffix-icon>
            <search-icon />
          </template>
        </t-input>
        <t-button theme="primary" @click="fetchSearchData">查询</t-button>
      </t-space>
    </div>
    <t-base-table :data="lists" :columns="COLUMNS" row-key="id" vertical-align="top" :hover="lists?.length > 0 ? true : false" :pagination="pagination" :loading="dataLoading" table-layout="auto" max-height="auto" :header-affixed-top="headerAffixedTop" @page-change="rehandlePageChange">
      <template #empty>
        <result title="" tip="相关数据为空" type="list"> </result>
      </template>
    </t-base-table>
  </t-card>
</template>

<script lang="ts">
export default {
  name: 'ChartChartlist',
};
</script>
<script setup lang="ts">
import { SearchIcon } from 'tdesign-icons-vue-next';
import { reactive } from 'vue';

import { getChartsMoneyTotal } from '@/api/merchant/charts/charts';
import Result from '@/components/result/index.vue';
import { COLUMNS } from '@/constant/charts/ranklist/constant';
import { table } from '@/hooks/table';

const params = reactive<any>({});
const { pagination, fetchData, dataLoading, headerAffixedTop, rehandlePageChange, lists, searchData } = table({
  fetchFun: getChartsMoneyTotal,
  params,
});
fetchData();

const fetchSearchData = () => {
  params.type = 'contact';
  params.contact = params.keywords.trim();
  searchData();
};
</script>
