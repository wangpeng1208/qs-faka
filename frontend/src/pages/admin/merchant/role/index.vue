<template>
  <t-card title="商户角色管理" class="basic-container" :bordered="false">
    <div class="category-header c-flex">
      <div class="l"><t-button v-perms="['adminapi/merchant/role/add']" theme="primary" @click="editRow()">添加</t-button></div>
    </div>
    <t-base-table ref="tableRef" row-key="id" :data="lists" :columns="columns" :hover="lists.length > 0 ? true : false" :header-affixed-top="headerAffixedTop" :pagination="pagination" lazy-load table-layout="auto" max-height="100%" @page-change="onPageChange">
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
import { computed, ref } from 'vue';

import { del, list } from '@/api/admin/merchant/role';
import { prefix } from '@/config/global';
import { useSettingStore } from '@/store';

import { columns } from './components/constant';
import EditPopup from './components/edit.vue';
import ratePopup from './components/rate.vue';

const pagination = ref({
  defaultPageSize: 20,
  total: 0,
  defaultCurrent: 1,
});
const lists = ref([]);
// 避免丢失searchData·重要
const searchData = ref();
const fetchData = async (params = {}) => {
  searchData.value = params;
  const { data } = await list({
    page: pagination.value.defaultCurrent,
    limit: pagination.value.defaultPageSize,
    ...params,
  });
  lists.value = data.list;
  pagination.value.total = data.total;
};
fetchData();

const onPageChange = (curr: any) => {
  pagination.value.defaultCurrent = curr.current;
  pagination.value.defaultPageSize = curr.pageSize;
  // 翻页参数应传入搜索数据
  fetchData(searchData);
};

const store = useSettingStore();
const headerAffixedTop = computed(() => ({
  offsetTop: store.isUseTabsRouter ? 48 : 0,
  container: `.${prefix}-layout`,
}));
// 编辑/添加
const editRef = ref();
const editRow = (id = 0) => {
  editRef.value?.init(id);
};
const rateRef = ref();
const rateRow = (id = 0) => {
  rateRef.value?.init(id);
};
// 删除
const deleteRow = async (id: number) => {
  const { data } = await del({ id });
  if (data.code === 1) {
    MessagePlugin.success('删除成功');
    fetchData();
  }
};
</script>
