<template>
  <t-card title="管理员管理" class="basic-container" :bordered="false">
    <t-base-table ref="tableRef" row-key="id" :data="lists" :columns="columns" :hover="lists?.length > 0 ? true : false" :header-affixed-top="headerAffixedTop" :pagination="pagination" lazy-load table-layout="auto" max-height="auto" :loading="dataLoading" @page-change="rehandlePageChange">
      <template #topContent>
        <t-button v-perms="['adminapi/permission/admin/add']" theme="primary" @click="editRow()">添加</t-button>
      </template>
      <template #avatar="{ row }">
        <wp-image :src="row.avatar" style="width: 60px; height: 60px" shape="circle" />
      </template>
      <template #operate="{ row }">
        <t-space>
          <t-link v-perms="['adminapi/permission/admin/edit']" theme="primary" hover="color" @click="editRow(row.id)">编辑</t-link>
          <t-link v-if="row.id !== 1" v-perms="['adminapi/permission/admin/del']" theme="danger" hover="color" @click="deleteRow(row.id)">删除</t-link>
        </t-space>
      </template>
    </t-base-table>
    <edit-popup ref="editRef" @success="fetchData" />
  </t-card>
</template>
<script setup lang="ts">
import { MessagePlugin } from 'tdesign-vue-next';
import { ref } from 'vue';

import { del, list } from '@/api/admin/permission/admin';
import { table } from '@/hooks/table';

import { columns } from './components/constant';
import EditPopup from './components/edit.vue';

const { pagination, fetchData, dataLoading, headerAffixedTop, rehandlePageChange, lists } = table({
  fetchFun: list,
});
fetchData();

// 编辑/添加
const editRef = ref<InstanceType<typeof EditPopup>>();
const editRow = (id = 0) => {
  editRef.value?.init(id);
};

// 删除
const deleteRow = async (id: number) => {
  const res = await del({ id });
  if (res.code === 1) {
    MessagePlugin.success(res.msg);
    fetchData();
  } else {
    MessagePlugin.error(res.msg);
  }
};
</script>
