<template>
  <t-card title="结算通道管理" class="basic-container" :bordered="false">
    <t-alert>用于结算给商户打款|自动轮询通道下的账号</t-alert>
    <t-base-table ref="tableRef" row-key="id" :data="lists" :columns="columns" :hover="lists.length > 0 ? true : false" :header-affixed-top="headerAffixedTop" max-height="auto" table-layout="auto" :pagination="pagination" lazy-load @page-change="onPageChange">
      <!-- status -->
      <template #status="{ row }">
        <t-tag v-if="row.status === 1" theme="success">启用</t-tag>
        <t-tag v-else theme="danger">禁用</t-tag>
      </template>
      <template #operate="{ row }">
        <t-space>
          <t-link v-perms="['adminapi/channel/collection/edit']" theme="primary" size="small" @click="editRow(row.id)">编辑</t-link>
          <t-link v-perms="['adminapi/channel/collectionAccount/list']" theme="primary" size="small" @click="accountRow(row.id)">账号管理</t-link>
          <t-link v-if="row.id != 1" v-perms="['adminapi/channel/collection/del']" theme="danger" size="small" @click="deleteRow(row.id)">删除</t-link>
        </t-space>
      </template>
    </t-base-table>
  </t-card>
  <edit-popup ref="editRef" @success="fetchData" />
</template>
<script setup lang="ts">
import { MessagePlugin } from 'tdesign-vue-next';
import { computed, ref } from 'vue';
import { useRouter } from 'vue-router';

import { del, list } from '@/api/admin/channel/collection';
import { prefix } from '@/config/global';
import { useSettingStore } from '@/store';

import { columns } from './constant';
import EditPopup from './edit.vue';

const router = useRouter();

const accountRow = (id = 0) => {
  router.push(`/admin/channel/settlement/account?id=${id}`);
};

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
    type: 2,
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
  fetchData();
};
const store = useSettingStore();
const headerAffixedTop = computed(() => ({
  offsetTop: store.isUseTabsRouter ? 48 : 0,
  container: `.${prefix}-layout`,
}));
const editRef = ref();
const editRow = (id = 0) => {
  editRef.value.init(id);
};
const deleteRow = async (id: number) => {
  const res = await del({
    id,
  });
  if (res.code === 1) {
    MessagePlugin.success('删除成功');
    fetchData();
  }
};
</script>
