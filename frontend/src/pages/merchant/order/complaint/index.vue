<template>
  <t-card title="投诉管理" class="basic-container" :bordered="false">
    <div class="category-header c-flex">
      <!-- <div class="l c-flex">
        <t-tag variant="light" theme="success" size="large">未处理投诉数</t-tag>
      </div> -->
      <div class="r c-flex">
        <t-space>
          <t-select v-model="params.status" placeholder="全部状态" type="search" clearable :options="STATUSLIST"></t-select>
          <t-select v-model="params.type" placeholder="全部类型" type="search" clearable :options="TYPELIST"></t-select>
          <t-button theme="default" variant="outline" @click="fetchData">查询</t-button>
        </t-space>
      </div>
    </div>
    <t-base-table :data="lists" :columns="COLUMNS" :row-key="rowKey" vertical-align="top" :hover="list.length > 0 ? true : false" :pagination="pagination" :header-affixed-top="headerAffixedTop" max-height="auto" @page-change="rehandlePageChange">
      <template #money="{ row }">
        <t-tag v-if="row.money < 0" theme="danger">{{ row.money }}</t-tag>
        <t-tag v-else theme="success">{{ row.money }}</t-tag>
      </template>
      <template #status="{ row }">
        <t-tag v-if="row.status === 0" variant="light" theme="danger">未处理</t-tag>
        <t-tag v-else-if="row.status === 1" variant="light" theme="success">已处理</t-tag>
        <t-tag v-else-if="row.status === -1" variant="light" theme="success">已撤销</t-tag>
      </template>
      <template #empty>
        <result title="" tip="暂无投诉" type="list"> </result>
      </template>
      <template #action="{ row }">
        <t-link theme="primary" @click="detailRow(row.id)">详情</t-link>
      </template>
    </t-base-table>
  </t-card>
</template>
<script lang="ts">
export default {
  name: 'ComplaintIndex',
};
</script>

<script setup lang="ts">
import { computed, onMounted, reactive, ref } from 'vue';
import { useRouter } from 'vue-router';

import { list } from '@/api/merchant/order/complaint';
import Result from '@/components/result/index.vue';
import { prefix } from '@/config/global';
import { useSettingStore } from '@/store';

import { COLUMNS, STATUSLIST, TYPELIST } from './components/constant';

const store = useSettingStore();

const lists = ref([]);
const pagination = ref({
  defaultPageSize: 20,
  total: 0,
  defaultCurrent: 1,
});
const params = reactive({
  status: '',
  type: '',
});
const dataLoading = ref(false);
const fetchData = async () => {
  dataLoading.value = true;
  const value = {
    page: pagination.value.defaultCurrent,
    limit: pagination.value.defaultPageSize,
    ...params,
  };
  try {
    const { data } = await list(value);
    lists.value = data.list;
    // 如果为空 则清空 pagination
    if (data.list.length === 0) {
      pagination.value = null;
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

const rowKey = 'id';

const rehandlePageChange = (curr: any, pageInfo: any) => {
  pagination.value.defaultCurrent = curr.current;
  pagination.value.defaultPageSize = curr.pageSize;
  fetchData();
};

const headerAffixedTop = computed(() => ({
  offsetTop: store.isUseTabsRouter ? 48 : 0,
  container: `.${prefix}-layout`,
}));
const router = useRouter();
const detailRow = (id: number) => {
  router.push({
    name: 'merchantComplaintDetail',
    query: {
      id,
    },
  });
};
onMounted(() => {
  fetchData();
});
</script>

<style lang="less" scoped></style>
