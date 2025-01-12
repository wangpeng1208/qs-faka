<template>
  <t-card title="通知列表" :bordered="false">
    <t-base-table :data="lists" :columns="COLUMNS" row-key="id" vertical-align="top" :hover="list.length > 0 ? true : false" :pagination="pagination" table-layout="auto" :header-affixed-top="headerAffixedTop" max-height="100%" :loading="dataLoading" @page-change="rehandlePageChange">
      <template #topContent>
        <t-button v-perms="['merchantapi/user/message/readAll']" size="small" style="margin-bottom: 10px" @click="setReadAll()"> 标记全部已读 </t-button>
      </template>
      <template #status="{ row }">
        <t-tag v-if="row.status" theme="success" size="small" variant="outline"> 已读 </t-tag>
        <t-tag v-else theme="warning" size="small" variant="outline"> 未读 </t-tag>
      </template>
      <template #create_at="{ row }">
        <span>{{ formatTime(row.create_at) }}</span>
      </template>
      <template #operation="{ row }">
        <t-link v-if="row.status === 0" v-perms="['merchantapi/user/message/read']" hover="color" theme="primary" @click="setRead(row.id)">标记已读</t-link>
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
import { computed, ref } from 'vue';

import { del, list, read, readAll } from '@/api/merchant/user/message';
import { prefix } from '@/config/global';
import { useMessageStore, useSettingStore } from '@/store';
import { formatTime } from '@/utils/date';

const store = useSettingStore();

const COLUMNS = [
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
    key: 'create_at',
  },
  {
    title: '操作',
    colKey: 'operation',
  },
];
const lists = ref([]);
const pagination = ref({
  defaultPageSize: 20,
  total: 0,
  defaultCurrent: 1,
});
const dataLoading = ref(false);
const fetchData = async () => {
  dataLoading.value = true;
  const params = {
    page: pagination.value.defaultCurrent,
    limit: pagination.value.defaultPageSize,
  };
  try {
    const { data } = await list({ ...params });
    lists.value = data.list;
    pagination.value = {
      ...pagination.value,
      total: data.count,
    };
  } catch (e) {
    console.log(e);
  } finally {
    dataLoading.value = false;
  }
};

fetchData();

const rehandlePageChange = (curr: any, pageInfo: any) => {
  pagination.value.defaultCurrent = curr.current;
  pagination.value.defaultPageSize = curr.pageSize;
  fetchData();
};

const headerAffixedTop = computed(() => ({
  offsetTop: store.isUseTabsRouter ? 48 : 0,
  container: `.${prefix}-layout`,
}));

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

<style lang="less" scoped>
@import url('./index.less');
</style>
