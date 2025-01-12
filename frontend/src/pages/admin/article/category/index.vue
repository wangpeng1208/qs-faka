<template>
  <t-card title="文章分类管理" class="basic-container" :bordered="false">
    <div class="category-header c-flex">
      <div class="l">
        <t-button v-perms="['adminapi/article/articleCategory/add']" theme="primary" @click="editRow()">添加</t-button>
      </div>
    </div>
    <t-base-table ref="tableRef" row-key="id" :data="lists" :columns="columns" :hover="lists.length > 0 ? true : false" :header-affixed-top="headerAffixedTop" max-height="auto" table-layout="auto" :pagination="pagination" lazy-load :loading="dataLoading" @page-change="rehandlePageChange">
      <template #status="{ row }">
        <t-tag v-if="row.status === 1" variant="light" theme="success">启用</t-tag>
        <t-tag v-else variant="light" theme="danger">禁用</t-tag>
      </template>
      <template #operate="{ row }">
        <t-space>
          <t-link v-perms="['adminapi/article/articleCategory/edit']" theme="primary" size="small" @click="editRow(row)">编辑</t-link>
          <t-link v-perms="['adminapi/article/articleCategory/del']" theme="danger" size="small" @click="deleteRow(row.id)">删除</t-link>
        </t-space>
      </template>
    </t-base-table>
    <edit-popup ref="editRef" @success="fetchData" />
  </t-card>
</template>
<script setup lang="ts">
import { MessagePlugin } from 'tdesign-vue-next';
import { ref } from 'vue';

import { del, list } from '@/api/admin/article/category';
import { table } from '@/hooks/table';

import { columns } from './components/constant';
import EditPopup from './components/edit.vue';

// 表格
const { pagination, fetchData, dataLoading, headerAffixedTop, rehandlePageChange, lists } = table({
  fetchFun: list,
});
fetchData();
// 编辑弹窗
const editRef = ref<InstanceType<typeof EditPopup>>();
const editRow = (row: { [key: string]: any } | null = null) => {
  editRef.value.init(row);
};
// 删除
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
