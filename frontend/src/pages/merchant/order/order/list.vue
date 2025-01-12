<template>
  <t-card title="订单管理" class="basic-container" :bordered="false">
    <div class="category-header c-flex">
      <div class="l">
        <t-space>
          <t-select v-model="params.type" :clear="fetchData" placeholder="全部分类" clearable :options="TYPE"></t-select>
          <t-select v-model="params.status" :clear="fetchData" placeholder="全部状态" clearable :options="STATUS"></t-select>
          <t-input v-model="params.keywords" placeholder="请输入关键词" clearable>
            <template #suffix-icon>
              <search-icon />
            </template>
          </t-input>

          <t-button theme="default" variant="outline" @click="fetchData">查询</t-button>
        </t-space>
      </div>
    </div>
    <t-base-table size="small" :data="lists" :columns="COLUMNS" :row-key="rowKey" vertical-align="middle" :hover="list.length > 0 ? true : false" :pagination="pagination" :selected-row-keys="selectedRowKeys" :loading="dataLoading" :header-affixed-top="headerAffixedTop" max-height="100%" @page-change="rehandlePageChange" @change="rehandleChange" @select-change="rehandleSelectChange">
      <template #trade_no="{ row }">
        <t-space size="small" direction="vertical">
          <t-tooltip placement="top" content="点击复制">
            <t-link theme="primary" @click="copyText(row.trade_no)"> {{ row.trade_no }} </t-link>
          </t-tooltip>
        </t-space>
      </template>
      <template #take_card_password="{ row }">
        <t-tag v-if="row.take_card_password" shape="square" tip="点击复制" @click="copyText(row.take_card_password)">
          {{ row.take_card_password }}
        </t-tag>
      </template>
      <template #status="{ row }">
        <span>
          <t-tag v-if="row.status === 0" variant="light-outline" theme="danger"><close-circle-filled-icon />未付款</t-tag>
          <t-tag v-else-if="row.status === 1" variant="light-outline" theme="success"> <check-circle-filled-icon />已付款</t-tag>
          <t-tag v-else-if="row.status === 2" variant="light-outline" theme="danger"><info-circle-icon />已关闭</t-tag>
          <t-tag v-else-if="row.status === 3" variant="light-outline" theme="danger"> <error-circle-filled-icon />已退款</t-tag>
        </span>
      </template>
      <template #take_status_text="{ row }">
        <t-tag v-if="row.take_status_text == '未取'" variant="outline" theme="danger"> <check-circle-filled-icon />{{ row.take_status_text }}</t-tag>
        <t-tag v-else-if="row.take_status_text == '已取'" variant="outline" theme="success"> <check-circle-filled-icon />{{ row.take_status_text }}</t-tag>
      </template>
      <template #total_product_price="{ row }">
        <t-space size="small" direction="vertical">
          <span> 总价：{{ row.total_product_price }} </span>
          <span> 实付：{{ row.total_price }} </span>
        </t-space>
      </template>
      <template #paytype="{ row }">
        <t-tag variant="light-outline" theme="primary" size="small">{{ row.paytype }}</t-tag>
      </template>
      <template #create_at="{ row }">
        {{ formatTime(row.create_at) }}
      </template>
      <template #operation="{ row }">
        <span v-if="row.status == 1">
          <t-link hover="color" size="small" variant="outline" theme="primary" @click="goPage(row.id)">查看卡密</t-link>
          <span v-if="row.cards_count == 0">
            <t-link hover="color" size="small" variant="outline" theme="success">导出</t-link>
          </span>
        </span>
      </template>
      <template #empty>
        <result title="" tip="订单列表为空" type="list"> </result>
      </template>
    </t-base-table>
  </t-card>
</template>

<script lang="ts">
export default {
  name: 'OrderOrderList',
};
</script>

<script setup lang="ts">
import { CheckCircleFilledIcon, CloseCircleFilledIcon, ErrorCircleFilledIcon, InfoCircleIcon, SearchIcon } from 'tdesign-icons-vue-next';
import { computed, reactive, ref } from 'vue';
import { useRouter } from 'vue-router';

import { list } from '@/api/merchant/order/order';
import Result from '@/components/result/index.vue';
import { prefix } from '@/config/global';
import { useSettingStore } from '@/store';
import { copyText } from '@/utils/common';
import { formatTime } from '@/utils/date';

import { COLUMNS, STATUS, TYPE } from './constant';

const router = useRouter();
const params = reactive({
  status: '',
  keywords: '',
  type: '',
});
const { query } = router.currentRoute.value as any;
if (query.status) {
  params.status = query.status;
}
const store = useSettingStore();
const lists = ref([]);
const pagination = ref({
  defaultPageSize: 15,
  total: 0,
  defaultCurrent: 1,
});

const searchValue = ref('');
const dataLoading = ref(false);
const fetchData = async (val = {}) => {
  const value = {
    page: pagination.value.defaultCurrent,
    limit: pagination.value.defaultPageSize,
    name: searchValue.value,
    ...params,
    ...val,
  };
  dataLoading.value = true;
  try {
    const { data } = await list(value);
    lists.value = data.list;
    pagination.value = {
      ...pagination.value,
      total: data.total,
    };
  } catch (e) {
    console.log(e);
  } finally {
    dataLoading.value = false;
  }
};

fetchData();
const goPage = (id: number) => {
  router.push({
    name: 'merchantOrderOrderCard',
    query: {
      id,
    },
  });
};

const selectedRowKeys = ref([]);

const rowKey = 'index';

const rehandleSelectChange = (val: number[]) => {
  selectedRowKeys.value = val;
};
const rehandlePageChange = (curr: any, pageInfo: any) => {
  pagination.value.defaultCurrent = curr.current;
  pagination.value.defaultPageSize = curr.pageSize;
  fetchData();
};
const rehandleChange = (changeParams: any, triggerAndData: any) => {};

const headerAffixedTop = computed(() => ({
  offsetTop: store.isUseTabsRouter ? 48 : 0,
  container: `.${prefix}-layout`,
}));
</script>
