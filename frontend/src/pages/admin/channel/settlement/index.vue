<template>
  <t-card title="结算通道" class="basic-container" :bordered="false">
    <t-alert>用于结算给商户打款|自动轮询通道下的账号</t-alert>
    <t-base-table row-key="id" :data="lists" :columns="columns" :hover="lists?.length > 0 ? true : false" :header-affixed-top="headerAffixedTop" max-height="auto" table-layout="auto" :pagination="pagination" :loading="dataLoading" @page-change="rehandlePageChange">
      <template #status="{ row }">
        <t-tag variant="light" :theme="row.status === 1 ? 'success' : 'danger'">{{ row.status === 1 ? '启用' : '禁用' }}</t-tag>
      </template>
      <template #operate="{ row }">
        <t-space>
          <t-link v-perms="['adminapi/channel/collection/edit']" theme="primary" size="small" @click="editRow(row.id)">编辑</t-link>
          <t-link v-perms="['adminapi/channel/collectionAccount/list']" theme="primary" size="small" @click="accountRow(row.id)">账号管理</t-link>
          <t-link v-perms="['adminapi/channel/collection/del']" theme="danger" size="small" @click="deleteRow(row.id)">删除</t-link>
        </t-space>
      </template>
    </t-base-table>
  </t-card>
  <edit-popup ref="editRef" @success="fetchData" />
</template>
<script setup lang="ts">
import { MessagePlugin } from 'tdesign-vue-next';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

import { del, list } from '@/api/admin/channel/collection';
import { table } from '@/hooks/table';

import { columns } from './constant';
import EditPopup from './edit.vue';

const router = useRouter();

const { pagination, fetchData, dataLoading, headerAffixedTop, rehandlePageChange, lists } = table({
  fetchFun: list,
  params: {
    type: 2,
  },
});

fetchData();

const accountRow = (id = 0) => {
  router.push(`/admin/channel/settlement/account?id=${id}`);
};

const editRef = ref<InstanceType<typeof EditPopup>>();

const editRow = (id = 0) => {
  editRef.value.init(id);
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
