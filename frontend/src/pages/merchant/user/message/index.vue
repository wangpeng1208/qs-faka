<template>
  <t-card title="通知列表" :bordered="false">
    <t-base-table :data="lists" :columns="COLUMNS" row-key="id" vertical-align="top" :hover="lists?.length > 0 ? true : false" :pagination="pagination" table-layout="auto" :header-affixed-top="headerAffixedTop" max-height="100%" :loading="dataLoading" @page-change="rehandlePageChange">
      <template #topContent>
        <t-button v-perms="['merchantapi/user/message/readAll']" size="small" style="margin-bottom: 10px" @click="setReadAll()"> 标记全部已读 </t-button>
      </template>
      <template #status="{ row }">
        <t-tag :theme="row.status === 1 ? 'success' : 'warning'" size="small" variant="outline"> {{ row.status == 1 ? '已读' : '未读' }} </t-tag>
      </template>
      <template #create_at="{ row }">
        <span>{{ formatTime(row.create_at) }}</span>
      </template>
      <template #operation="{ row }">
        <t-link v-if="row.status === 0" v-perms="['merchantapi/user/message/read']" hover="color" theme="primary" @click="setRead(row.id)"> {{ row.status === 1 ? '标记已读' : '标记未读' }} </t-link>
        <t-link v-if="row.status === 1" v-perms="['merchantapi/user/message/del']" hover="color" theme="primary" @click="delRow(row.id)">删除</t-link>
      </template>
    </t-base-table>
  </t-card>
</template>

<script lang="ts">
export default {
  name: 'DetailSecondary',
};
</script>

<script setup lang="ts">
import { PrimaryTableCol, TableRowData } from 'tdesign-vue-next';

import { del, list, read, readAll } from '@/api/merchant/user/message';
import { table } from '@/hooks/table';
import { useMessageStore } from '@/store';
import { formatTime } from '@/utils/date';

const COLUMNS: PrimaryTableCol<TableRowData>[] = [
  {
    title: '通知内容',
    colKey: 'content',
  },
  {
    title: '状态',
    colKey: 'status',
  },
  {
    title: '通知时间',
    colKey: 'create_at',
  },
  {
    title: '操作',
    colKey: 'operation',
  },
];
const { pagination, fetchData, dataLoading, headerAffixedTop, rehandlePageChange, lists } = table({
  fetchFun: list,
});
fetchData();

const setRead = async (id: string) => {
  const res = await read({ id });
  if (res.code === 1) {
    fetchData();
    setStoreReadList();
  }
};

const setReadAll = async () => {
  const res = await readAll();
  if (res.code === 1) {
    fetchData();
    setStoreReadList();
  }
};
const delRow = async (id: string) => {
  const res = await del({ id });
  if (res.code === 1) {
    fetchData();
    setStoreReadList();
  }
};
const messageStore = useMessageStore();
const setStoreReadList = () => {
  messageStore.getMsgData();
};
</script>
