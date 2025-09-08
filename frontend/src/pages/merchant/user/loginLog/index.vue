<template>
  <t-card title="登陆日志" :bordered="false">
    <t-base-table :data="lists" :columns="COLUMNS" row-key="id" vertical-align="top" :hover="lists?.length > 0 ? true : false" :pagination="pagination" table-layout="auto" :header-affixed-top="headerAffixedTop" max-height="100%" :loading="dataLoading" @page-change="rehandlePageChange" />
  </t-card>
</template>
<script lang="ts">
export default {
  name: 'UserLogLogin',
};
</script>

<script setup lang="ts">
import { loginLog } from '@/api/merchant/user/user';
import { table } from '@/hooks/table';

import { COLUMNS } from './constant';

const { pagination, fetchData, dataLoading, headerAffixedTop, rehandlePageChange, lists } = table({
  fetchFun: loginLog,
});

fetchData();
</script>
