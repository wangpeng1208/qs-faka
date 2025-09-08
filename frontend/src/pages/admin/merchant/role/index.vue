<template>
  <t-card title="商户角色" class="basic-container" :bordered="false">
    <div class="category-header c-flex">
      <div class="l"><t-button v-perms="['adminapi/merchant/role/add']" theme="primary" @click="editRow()">添加</t-button></div>
    </div>
    <t-base-table ref="tableRef" row-key="id" :data="lists" :columns="columns" :hover="lists?.length > 0 ? true : false" :header-affixed-top="headerAffixedTop" :pagination="pagination" table-layout="auto" max-height="100%" :loading="dataLoading" @page-change="rehandlePageChange">
      <template #operate="{ row }">
        <t-space>
          <t-link v-perms="['adminapi/merchant/role/edit']" theme="primary" hover="color" @click="editRow(row.id)">编辑</t-link>
          <t-link v-perms="['adminMerchantRoleRule']" theme="primary" hover="color" @click="rateRow(row.id)">角色费率</t-link>
          <t-link v-if="row.id != 1" v-perms="['adminapi/merchant/role/del']" theme="danger" hover="color" @click="deleteRow(row.id)">删除</t-link>
        </t-space>
      </template>
    </t-base-table>
    <edit-popup ref="editRef" @success="fetchData" />
    <rate-popup ref="rateRef" @success="fetchData" />
  </t-card>
</template>
<script setup lang="ts">
import { MessagePlugin } from 'tdesign-vue-next';
import { ref } from 'vue';

import { del, list } from '@/api/admin/merchant/role';
import { table } from '@/hooks/table';

import { columns } from './components/constant';
import EditPopup from './components/edit.vue';
import ratePopup from './components/rate.vue';

const { pagination, fetchData, dataLoading, headerAffixedTop, rehandlePageChange, lists } = table({
  fetchFun: list,
});

fetchData();

// 编辑/添加
const editRef = ref<InstanceType<typeof EditPopup>>();
const editRow = (id = 0) => {
  editRef.value?.init(id);
};
const rateRef = ref<InstanceType<typeof ratePopup>>();
const rateRow = (id = 0) => {
  rateRef.value?.init(id);
};
// 删除
const deleteRow = async (id: number) => {
  const { data } = await del({ id });
  if (data.code === 1) {
    MessagePlugin.success(data.msg);
    fetchData();
  } else {
    MessagePlugin.error(data.msg);
  }
};
</script>
