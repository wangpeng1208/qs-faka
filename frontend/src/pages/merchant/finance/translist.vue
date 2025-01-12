<template>
  <t-card title="流水记录" class="basic-container" :bordered="false">
    <t-alert>
      <!-- <template #icon> <flag-icon /> </template> -->
      只保留显示最近30天的流水日志
    </t-alert>
    <t-base-table :data="list" :columns="COLUMNS" row-key="id" vertical-align="middle" :hover="list.length > 0 ? true : false" table-layout="auto" max-height="auto" :pagination="pagination" :header-affixed-top="headerAffixedTop" :loading="dataLoading" @page-change="rehandlePageChange">
      <template #create_at="{ row }">
        <span>{{ formatTime(row.create_at) }}</span>
      </template>
      <template #money="{ row }">
        <t-tag v-if="row.money < 0" theme="danger" variant="light">{{ row.money }}</t-tag>
        <t-tag v-else theme="success" variant="light">{{ row.money }}</t-tag>
      </template>
      <template #empty>
        <result title="" tip="流水为空" type="list"> </result>
      </template>
    </t-base-table>
  </t-card>
</template>
<script lang="ts">
export default {
  name: 'FinanceTranslist',
};
</script>

<script setup lang="ts">
import { computed, onMounted, ref } from 'vue';

import { log } from '@/api/merchant/finance/money';
import Result from '@/components/result/index.vue';
import { prefix } from '@/config/global';
import { COLUMNS } from '@/constant/user/money_log/constant';
import { useSettingStore } from '@/store';
import { formatTime } from '@/utils/date';

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
  const params = {
    page: pagination.value.defaultCurrent,
    limit: pagination.value.defaultPageSize,
  };

  const { data } = await log(params);
  list.value = data.list;
  pagination.value = {
    ...pagination.value,
    total: data.total,
  };

  dataLoading.value = false;
};

onMounted(() => {
  fetchData();
});

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
