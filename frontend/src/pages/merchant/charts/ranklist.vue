<template>
  <t-card title="累计消费" class="basic-container" :bordered="false">
    <div class="category-header c-flex">
      <t-space>
        <t-input v-model="searchData.keywords" placeholder="请输入联系方式" clearable>
          <template #suffix-icon>
            <search-icon />
          </template>
        </t-input>
        <t-button theme="default" variant="outline" @click="fetchData">查询</t-button>
      </t-space>
    </div>
    <t-base-table :data="list" :columns="COLUMNS" :row-key="rowKey" vertical-align="top" :hover="list.length > 0 ? true : false" :pagination="pagination" :selected-row-keys="selectedRowKeys" :loading="dataLoading" table-layout="auto" max-height="auto" :header-affixed-top="headerAffixedTop" @page-change="rehandlePageChange" @change="rehandleChange" @select-change="rehandleSelectChange">
      <template #status="{ row }">
        <t-tag v-if="row.status === 0" variant="light" theme="danger">未付款</t-tag>
        <t-tag v-else-if="row.status === 1" variant="light" theme="success">已付款</t-tag>
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
  name: 'ChartChartlist',
};
</script>

<script setup lang="ts">
import { SearchIcon } from 'tdesign-icons-vue-next';
import { MessagePlugin } from 'tdesign-vue-next';
import { computed, onMounted, reactive, ref } from 'vue';

import { getChartsMoneyTotal } from '@/api/merchant/charts/charts';
import Result from '@/components/result/index.vue';
import { prefix } from '@/config/global';
import { COLUMNS } from '@/constant/charts/ranklist/constant';
import { useSettingStore } from '@/store';
import { downloadFile } from '@/utils/common';
import { formatTime } from '@/utils/date';

const store = useSettingStore();

const searchData = reactive<any>({});

// 唯一标识一行数据
const rowKey = 'id';
// 分页
const pagination = ref({
  defaultPageSize: 10,
  total: 0,
  defaultCurrent: 1,
});
// 列表数据
const list = ref([]);
const charts = ref([]);
const dataLoading = ref(false);
const fetchData = async () => {
  dataLoading.value = true;
  if (searchData.action === 'export') {
    const value = {
      ...searchData,
    };
    const res = await getChartsMoneyTotal(value);
    if (res.code === 1) {
      downloadFile(res.data.url);
    } else {
      MessagePlugin.error(res.msg);
    }
    dataLoading.value = false;
  } else {
    const value = {
      page: pagination.value.defaultCurrent,
      limit: pagination.value.defaultPageSize,
      ...searchData,
    };
    try {
      const { data } = await getChartsMoneyTotal(value);
      list.value = data.list;
      charts.value = data.charts;
      pagination.value = {
        ...pagination.value,
        total: data.total,
      };
    } catch (e) {
      console.log(e);
    } finally {
      dataLoading.value = false;
    }
  }
};

onMounted(() => {
  fetchData();
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
