<template>
  <t-card title="支付方式分类" class="basic-container" :bordered="false">
    <template #actions> 用于购卡页显示选择支付方式；此处和支付授权渠道有关联；为系统预设性，非必要请勿删除 </template>
    <div class="category-header c-flex">
      <div class="l">
        <t-button v-perms="['adminapi/channel/payType/add']" theme="primary" @click="editRow(0)">添加</t-button>
      </div>
    </div>
    <t-base-table ref="tableRef" row-key="id" :data="lists" :columns="columns" :hover="lists.length > 0 ? true : false" :header-affixed-top="headerAffixedTop" :pagination="pagination" max-height="auto" table-layout="auto" lazy-load @page-change="onPageChange">
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
import { computed, ref } from 'vue';

import { del, list } from '@/api/admin/channel/pay_type';
import { prefix } from '@/config/global';
import { useSettingStore } from '@/store';

import { columns } from './constant';
import EditPopup from './edit.vue';

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
const editRow = (id: number) => {
  editRef.value.init(id);
};
const deleteRow = async (id: number) => {
  const res = await del({ id });
  if (res.code === 1) {
    MessagePlugin.success('删除成功');
    fetchData();
  }
};
</script>
