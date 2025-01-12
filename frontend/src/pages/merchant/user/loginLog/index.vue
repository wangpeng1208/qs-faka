<template>
  <t-card title="登陆日志" :bordered="false">
    <t-alert>只保留显示最近30天的登录日志</t-alert>

    <t-base-table :data="list" :columns="COLUMNS" row-key="id" vertical-align="top" :hover="list.length > 0 ? true : false" :pagination="pagination" table-layout="auto" :header-affixed-top="headerAffixedTop" max-height="100%" :loading="dataLoading" @page-change="rehandlePageChange" />
  </t-card>
</template>
<script lang="ts">
export default {
  name: 'UserLogLogin',
};
</script>

<script setup lang="ts">
import { computed, ref } from 'vue';

import { loginLog } from '@/api/merchant/user/user';
import { prefix } from '@/config/global';
import { useSettingStore } from '@/store';

import { COLUMNS } from './constant';

const store = useSettingStore();

const list = ref([]);
const pagination = ref({
  defaultPageSize: 20,
  total: 0,
  defaultCurrent: 1,
});
const dataLoading = ref(false);
const fetchData = async () => {
  dataLoading.value = true;
  const value = {
    page: pagination.value.defaultCurrent,
    limit: pagination.value.defaultPageSize,
  };
  try {
    const { data } = await loginLog(value);
    list.value = data.list;
    // 如果为空 则清空 pagination
    if (data.list.length === 0) {
      // pagination.value = false;
    } else {
      pagination.value = {
        ...pagination.value,
        total: data.total,
      };
    }
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
</script>

<style lang="less" scoped>
.header-tag {
  width: 100%;
}
</style>
