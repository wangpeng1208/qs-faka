<template>
  <t-card title="文章管理" class="basic-container" :bordered="false">
    <div class="category-header c-flex">
      <t-button v-perms="['adminapi/article/article/add']" theme="primary" @click="editRow()">添加</t-button>
    </div>
    <t-base-table row-key="id" :data="lists" :columns="columns" :hover="lists?.length > 0 ? true : false" :header-affixed-top="headerAffixedTop" max-height="auto" table-layout="auto" :pagination="pagination" :loading="dataLoading" @page-change="rehandlePageChange">
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
import { ref } from 'vue';

import { del, list } from '@/api/admin/article/article';
import { table } from '@/hooks/table';

import { columns } from './components/constant';
import EditPopup from './components/edit.vue';

const { pagination, fetchData, dataLoading, headerAffixedTop, rehandlePageChange, lists } = table({
  fetchFun: list,
});
fetchData();
const editRef = ref<InstanceType<typeof EditPopup>>();
const editRow = (row: { [key: string]: any } | null = null) => {
  editRef.value.init(row);
};
const deleteRow = async (id: number) => {
  const res = await del({
    id,
  });
  if (res.code === 1) {
    MessagePlugin.success(res.msg);
    fetchData();
  } else {
    MessagePlugin.error(res.msg);
  }
};
</script>
