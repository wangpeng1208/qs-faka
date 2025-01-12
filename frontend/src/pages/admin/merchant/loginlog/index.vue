<template>
  <t-card title="登录日志" class="basic-container" :bordered="false">
    <template #actions>
      <a href="javascript:void(0)" @click="showSearchFrom = !showSearchFrom">{{ searchText }}</a>
    </template>
    <div class="category-header c-flex">
      <row-search v-show="showSearchFrom" ref="searchFormRef" @success="fetchSearchData" />
    </div>
    <t-table :data="lists" :columns="columns" row-key="id" :hover="lists.length > 0 ? true : false" :pagination="pagination" :header-affixed-top="headerAffixedTop" table-layout="auto" max-height="100%" @page-change="onPageChange" />
  </t-card>
</template>
<script setup lang="ts">
import { computed, reactive, ref } from 'vue';

import { loginlog } from '@/api/admin/merchant/user';
import { prefix } from '@/config/global';
import { useSettingStore } from '@/store';

import { columns } from './components/constant';
import RowSearch from './components/search.vue';

const showSearchFrom = ref(false);
const searchText = computed(() => (showSearchFrom.value ? '收起搜索' : '展开搜索'));
const pagination = ref({
  defaultPageSize: 20,
  total: 0,
  defaultCurrent: 1,
});

// 搜索
const params = reactive<any>({});
const fetchSearchData = (newParams: any) => {
  Object.assign(params, newParams);
  pagination.value.defaultCurrent = 1;
  fetchData();
};

const lists = ref([]);
const fetchData = async () => {
  const { data } = await loginlog({
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
