<template>
  <t-card title="账号管理" class="basic-container" :bordered="false">
    <div class="category-header c-flex">
      <t-button v-perms="['adminapi/channel/collectionAccount/add']" theme="primary" @click="editRow(id)">添加</t-button>
    </div>
    <t-base-table row-key="id" :data="lists" :columns="columns" :hover="lists?.length > 0 ? true : false" :header-affixed-top="headerAffixedTop" max-height="auto" table-layout="auto" :pagination="pagination" :loading="dataLoading" @page-change="rehandlePageChange">
      <template #status="{ row }">
        <t-tag variant="light" :theme="row.status === 1 ? 'success' : 'danger'">{{ row.status === 1 ? '启用' : '禁用' }}</t-tag>
      </template>
      <template #operate="{ row }">
        <t-space>
          <t-link v-perms="['adminapi/channel/collectionAccount/edit']" theme="primary" size="small" @click="editRow(id, row.id)">编辑</t-link>
          <t-link v-perms="['adminapi/channel/collectionAccount/del']" theme="danger" size="small" @click="deleteRow(row.id)">删除</t-link>
        </t-space>
      </template>
    </t-base-table>
    <edit-popup ref="editRef" @success="fetchData" />
  </t-card>
</template>
<script setup lang="ts">
import { MessagePlugin } from 'tdesign-vue-next';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

import { del, list } from '@/api/admin/channel/collectionAccount';
import { table } from '@/hooks/table';

import { columns } from './constant';
import EditPopup from './edit.vue';

const router = useRouter();

const id = +router.currentRoute.value.query.id;
const { pagination, fetchData, dataLoading, headerAffixedTop, rehandlePageChange, lists } = table({
  fetchFun: list,
  params: {
    id,
  },
});

fetchData();

const editRef = ref<InstanceType<typeof EditPopup>>();
const editRow = (channelId = 0, id = 0) => {
  editRef.value.init(channelId, id);
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
