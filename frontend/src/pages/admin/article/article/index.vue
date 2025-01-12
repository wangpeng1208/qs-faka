<template>
  <t-card title="文章管理" class="basic-container" :bordered="false">
    <div class="category-header c-flex">
      <div class="l">
        <t-button v-perms="['adminapi/article/article/add']" theme="primary" @click="editRow()">添加</t-button>
      </div>
    </div>
    <t-base-table ref="tableRef" row-key="id" :data="lists" :columns="columns" :hover="lists.length > 0 ? true : false" :header-affixed-top="headerAffixedTop" max-height="auto" table-layout="auto" :pagination="pagination" lazy-load :loading="loading" @page-change="onPageChange">
      <template #operate="{ row }">
        <t-space>
          <t-link v-perms="['adminapi/article/article/edit']" theme="primary" size="small" @click="editRow(row)">编辑</t-link>
          <t-link v-perms="['adminapi/article/article/del']" theme="danger" size="small" @click="deleteRow(row.id)">删除</t-link>
        </t-space>
      </template>
    </t-base-table>
    <edit-popup ref="editRef" @success="fetchData" />
  </t-card>
</template>
<script setup lang="ts">
import { MessagePlugin } from 'tdesign-vue-next';
import { computed, ref } from 'vue';

import { del, list } from '@/api/admin/article/article';
import { prefix } from '@/config/global';
import { useSettingStore } from '@/store';

import { columns } from './components/constant';
import EditPopup from './components/edit.vue';

const pagination = ref({
  defaultPageSize: 20,
  total: 0,
  defaultCurrent: 1,
});
const lists = ref([]);
const loading = ref(true);
const fetchData = async () => {
  const { data } = await list({
    page: pagination.value.defaultCurrent,
    limit: pagination.value.defaultPageSize,
  });
  lists.value = data.list;
  loading.value = false;
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
  fetchData();
};
const store = useSettingStore();
const headerAffixedTop = computed(() => ({
  offsetTop: store.isUseTabsRouter ? 48 : 0,
  container: `.${prefix}-layout`,
}));
const editRef = ref();
const editRow = (row: { [key: string]: any } | null = null) => {
  editRef.value.init(row);
};
const deleteRow = async (id: number) => {
  const res = await del({
    id,
  });
  if (res.code === 1) {
    MessagePlugin.success('删除成功');
    fetchData();
  } else {
    MessagePlugin.error(res.msg);
  }
};
</script>
