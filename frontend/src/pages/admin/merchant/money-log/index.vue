<template>
  <t-card title="资金日志" class="basic-container" :bordered="false">
    <template #actions>
      <a href="javascript:void(0)" @click="showSearchFrom = !showSearchFrom">{{ searchText }}</a>
    </template>
    <div class="category-header c-flex">
      <div class="l">
        <row-search v-show="showSearchFrom" ref="searchFormRef" @success="fetchSearchData" />
      </div>
    </div>
    <t-table :data="lists" :columns="columns" row-key="id" :hover="lists.length > 0 ? true : false" :pagination="pagination" :header-affixed-top="headerAffixedTop" table-layout="auto" max-height="100%" @page-change="onPageChange">
      <template #money="{ row }">
        <span :style="{ color: row.money > 0 ? '#52c41a' : '#f5222d' }">{{ row.money }}</span>
      </template>
    </t-table>
  </t-card>
</template>
<script setup lang="ts">
import { computed, reactive, ref } from 'vue';

import { list } from '@/api/admin/merchant/money-log';
import { prefix } from '@/config/global';
import { useSettingStore } from '@/store';

import { columns } from './components/constant';
import RowSearch from './components/search.vue';

// 搜索
const params = reactive<any>({});
const fetchSearchData = (newParams: any) => {
  Object.assign(params, newParams);
  fetchData();
};
const showSearchFrom = ref(false);
const searchText = computed(() => (showSearchFrom.value ? '收起搜索' : '展开搜索'));
const pagination = ref({
  defaultPageSize: 20,
  total: 0,
  defaultCurrent: 1,
});

const lists = ref([]);
const fetchData = async () => {
  const { data } = await list({
    page: pagination.value.defaultCurrent,
    limit: pagination.value.defaultPageSize,
    ...params,
  });
  lists.value = data.list;
  pagination.value = {
    ...pagination.value,
    total: data.total,
  };
};
fetchData();
const onPageChange = (curr: any) => {
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
