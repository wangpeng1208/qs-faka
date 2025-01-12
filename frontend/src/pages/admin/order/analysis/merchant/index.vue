<template>
  <t-card title="商户支付分析" class="basic-container" :bordered="false">
    <template #actions>
      <a href="javascript:void(0)" @click="showSearchFrom = !showSearchFrom">{{ searchText }}</a>
    </template>
    <div class="category-header c-flex">
      <row-search v-show="showSearchFrom" ref="searchFormRef" @success="fetchData" />
    </div>
    <t-base-table :data="lists" :columns="columns" row-key="id" vertical-align="middle" :hover="lists.length > 0 ? true : false" :pagination="pagination" :header-affixed-top="headerAffixedTop" table-layout="auto" max-height="100%" @page-change="rehandlePageChange">
      <template #empty>
        <!-- <result title="" tip="暂无相关数据 " type="list"> </result> -->
      </template>
    </t-base-table>

    <rank-card style="margin-bottom: 20px" />
  </t-card>
</template>

<script setup lang="ts">
import { computed, reactive, ref } from 'vue';

import { merchant } from '@/api/admin/order/analysis';
import { prefix } from '@/config/global';
import RankCard from '@/pages/admin/workbench/components/RankCard.vue';
import { useSettingStore } from '@/store';
import { downloadFile } from '@/utils/common';

import { columns } from './components/constant';
import RowSearch from './components/row-search.vue';

const pagination = ref({
  defaultPageSize: 20,
  total: 0,
  defaultCurrent: 1,
});
const lists = ref([]);
// 搜索
const searchData = reactive<any>({});
const showSearchFrom = ref(true);
const searchText = computed(() => (showSearchFrom.value ? '收起搜索' : '展开搜索'));

// 数据加载
const fetchData = async (params = {}) => {
  // params 合并到 searchData
  Object.assign(searchData, params);
  if (searchData.action === 'export') {
    const value = {
      ...searchData,
    };
    const res = await merchant(value);
    downloadFile(res.data.url);
  } else {
    const value = {
      page: pagination.value.defaultCurrent,
      limit: pagination.value.defaultPageSize,
      ...searchData,
    };
    const { data } = await merchant(value);

    lists.value = data.list;
    pagination.value = {
      ...pagination.value,
      total: data.total,
    };
  }
};
fetchData();

const rehandlePageChange = (curr: any) => {
  pagination.value.defaultCurrent = curr.current;
  pagination.value.defaultPageSize = curr.pageSize;
  fetchData();
};

const store = useSettingStore();
const headerAffixedTop = computed(() => ({
  offsetTop: store.isUseTabsRouter ? 48 : 0,
  container: `.${prefix}-layout`,
}));
</script>
