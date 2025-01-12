<template>
  <t-card title="收款通道管理" class="basic-container" :bordered="false">
    <template #actions>
      <t-button v-perms="['adminapi/channel/collection/add']" theme="primary" @click="editRow()">添加通道</t-button>
    </template>
    <t-base-table ref="tableRef" row-key="id" :data="lists" :columns="columns" :hover="lists.length > 0 ? true : false" :header-affixed-top="headerAffixedTop" max-height="auto" table-layout="auto" :pagination="pagination" lazy-load @page-change="onPageChange">
      <template #paytype="{ row }">
        {{ findPayType(row.paytype) }}
      </template>
      <template #status="{ row }">
        <t-tag v-if="row.status === 1" variant="light" theme="success">启用</t-tag>
        <t-tag v-else variant="light" theme="danger">禁用</t-tag>
      </template>
      <!-- is_available 1手机2电脑0通用 -->
      <template #is_available="{ row }">
        <t-tag v-if="row.is_available === 1" variant="light" theme="success">手机</t-tag>
        <t-tag v-else-if="row.is_available === 2" variant="light" theme="success">电脑</t-tag>
        <t-tag v-else variant="light" theme="success">通用</t-tag>
      </template>
      <template #operate="{ row }">
        <t-space>
          <t-link v-perms="['adminapi/channel/collection/edit']" theme="primary" size="small" @click="editRow(row.id)">编辑</t-link>
          <t-link v-perms="['adminapi/channel/collectionAccount/list']" theme="primary" size="small" @click="accountRow(row.id)">账号管理</t-link>
          <t-link v-if="row.id != 1" v-perms="['adminapi/channel/collection/del']" theme="danger" size="small" @click="deleteRow(row.id)">删除</t-link>
        </t-space>
      </template>
    </t-base-table>
    <edit-popup ref="editRef" :pay-type-options="payTypeOptions" @success="fetchData" />
  </t-card>
</template>
<script setup lang="ts">
import { MessagePlugin } from 'tdesign-vue-next';
import { computed, ref } from 'vue';
import { useRouter } from 'vue-router';

import { del, list } from '@/api/admin/channel/collection';
import { baseUrl, payTypeSimple } from '@/api/admin/channel/pay_type';
import { prefix } from '@/config/global';
import { useSettingStore } from '@/store';

import { columns } from './constant';
import EditPopup from './edit.vue';

const isCustom = ref(0);

const router = useRouter();

const accountRow = (id = 0) => {
  router.push(`/admin/channel/collection/account?id=${id}`);
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
    is_custom: isCustom.value,
  });
  lists.value = data.list;
  pagination.value = {
    defaultPageSize: data.limit,
    total: data.total,
    defaultCurrent: data.page,
  };
  initPayTypeOptions();
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

const payTypeOptions = ref();
// 加载支付分类
const initPayTypeOptions = async () => {
  const { data } = await payTypeSimple();
  data.forEach((item: any, key: any) => {
    data[key].ico = baseUrl + item.ico;
  });
  // console.table(data);
  payTypeOptions.value = data;
};
// 按id查找支付分类名
const findPayType = (id: number) => {
  if (!payTypeOptions.value) return '';
  const item = payTypeOptions.value.find((item: any) => item.value === id);
  return item ? item.label : '';
};
</script>
