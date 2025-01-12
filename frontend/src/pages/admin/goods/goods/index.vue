<template>
  <t-card title="商品管理" class="basic-container" :bordered="false">
    <template #actions>
      <a href="javascript:void(0)" @click="showSearchFrom = !showSearchFrom">{{ searchText }}</a>
    </template>
    <div class="category-header c-flex">
      <div class="l">
        <row-search v-show="showSearchFrom" ref="searchFormRef" @success="fetchData" />
      </div>
    </div>
    <t-table :data="lists" :columns="columns" row-key="id" :expand-on-row-click="false" :hover="lists.length > 0 ? true : false" :pagination="pagination" :header-affixed-top="headerAffixedTop" table-layout="auto" max-height="100%" @page-change="onPageChange">
      <template #status="{ row }">
        <t-tag v-if="row.status === 1" theme="success">启用</t-tag>
        <t-tag v-else theme="danger">禁用</t-tag>
      </template>
      <template #freeze="{ row }">
        <t-link v-if="row.delete_at == null" v-perms="['adminapi/goods/goods/freeze']" theme="primary" size="small" @click="freezeRow(row.id)">
          {{ row.is_freeze === 1 ? '解冻' : '冻结' }}
        </t-link>
      </template>
      <template #operate="{ row }">
        <t-space>
          <t-link v-if="row.delete_at == null" v-perms="['adminapi/goods/goods/status']" theme="primary" size="small" @click="statusRow(row.id)">
            {{ row.status === 1 ? '下架' : '上架' }}
          </t-link>
          <t-link v-perms="['adminapi/goods/goods/del']" theme="danger" size="small" @click="deleteRow(row.id, 0)">
            {{ row.delete_at ? '恢复' : '放回收站' }}
          </t-link>
          <t-link v-perms="['adminapi/goods/goods/del']" theme="danger" size="small" @click="deleteRow(row.id, 1)"> 删除 </t-link>
        </t-space>
      </template>
    </t-table>
  </t-card>
</template>
<script setup lang="ts">
import { MessagePlugin } from 'tdesign-vue-next';
import { computed, ref } from 'vue';

import { del, freeze, list, status } from '@/api/admin/goods/goods';
import { prefix } from '@/config/global';
import { useSettingStore } from '@/store';

import { columns } from './constant';
import RowSearch from './search.vue';

// 搜索
const searchData = ref();
const showSearchFrom = ref(false);
const searchText = computed(() => (showSearchFrom.value ? '收起搜索' : '展开搜索'));
const pagination = ref({
  defaultPageSize: 20,
  total: 0,
  defaultCurrent: 1,
});

const lists = ref([]);
const fetchData = async (params = {}) => {
  searchData.value = { ...params };
  const { data } = await list({
    page: pagination.value.defaultCurrent,
    limit: pagination.value.defaultPageSize,
    ...searchData.value,
  });
  lists.value = data.list;
  pagination.value = {
    defaultPageSize: data.limit,
    total: data.total,
    defaultCurrent: data.page,
  };
};
fetchData();
const onPageChange = (curr: any) => {
  pagination.value.defaultCurrent = curr.current;
  pagination.value.defaultPageSize = curr.pageSize;
  fetchData(searchData.value);
};
const store = useSettingStore();
const headerAffixedTop = computed(() => ({
  offsetTop: store.isUseTabsRouter ? 48 : 0,
  container: `.${prefix}-layout`,
}));

const executeAction = async (action: Function, id: number, val?: number) => {
  const params = val !== undefined ? { id, val } : { id };
  const res = await action(params);
  if (res.code === 1) {
    MessagePlugin.success(res.msg);
    fetchData(searchData.value);
    return;
  }
  MessagePlugin.error(res.msg);
};

const deleteRow = (id: number, val = 0) => executeAction(del, id, val);
const freezeRow = (id: number) => executeAction(freeze, id);
const statusRow = (id: number) => executeAction(status, id);
</script>
