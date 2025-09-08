<template>
  <t-card title="支付方式分类" class="basic-container" :bordered="false">
    <template #actions> 用于购卡页显示选择支付方式；此处和支付授权渠道有关联；为系统预设性，非必要请勿删除 </template>
    <div class="category-header c-flex">
      <t-button v-perms="['adminapi/channel/payType/add']" theme="primary" @click="editRow(0)">添加</t-button>
    </div>
    <t-base-table row-key="id" :data="lists" :columns="columns" :hover="lists?.length > 0 ? true : false" :header-affixed-top="headerAffixedTop" :pagination="pagination" max-height="auto" table-layout="auto" :loading="dataLoading" @page-change="rehandlePageChange">
      <template #logo="{ row }">
        <wp-image :src="row.logo" :style="{ width: '80px', height: '30px' }" />
      </template>
      <template #ico="{ row }">
        <wp-image :src="row.ico" shape="circle" :style="{ width: '30px', height: '30px' }" />
      </template>
      <template #operate="{ row }">
        <t-space>
          <t-link v-perms="['adminapi/channel/payType/edit']" theme="primary" size="small" @click="editRow(row.id)">编辑</t-link>
          <t-link v-perms="['adminapi/channel/payType/del']" theme="danger" size="small" @click="deleteRow(row.id)">删除</t-link>
        </t-space>
      </template>
    </t-base-table>
    <edit-popup ref="editRef" @success="fetchData" />
  </t-card>
</template>
<script setup lang="ts">
import { MessagePlugin } from 'tdesign-vue-next';
import { ref } from 'vue';

import { del, list } from '@/api/admin/channel/pay_type';
import { table } from '@/hooks/table';

import { columns } from './constant';
import EditPopup from './edit.vue';

const { pagination, fetchData, dataLoading, headerAffixedTop, rehandlePageChange, lists } = table({
  fetchFun: list,
});

fetchData();

const editRef = ref<InstanceType<typeof EditPopup>>();
const editRow = (id: number) => {
  editRef.value.init(id);
};
const deleteRow = async (id: number) => {
  const res = await del({ id });
  if (res.code === 1) {
    MessagePlugin.success(res.msg);
    fetchData();
  }
};
</script>
