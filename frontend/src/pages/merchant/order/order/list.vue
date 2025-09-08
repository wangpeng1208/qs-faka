<template>
  <t-card title="订单管理" class="basic-container" :bordered="false">
    <div class="category-header c-flex">
      <div class="l">
        <t-space>
          <t-select v-model="params.status" :clear="fetchData" placeholder="全部状态" clearable :options="STATUS"></t-select>
          <t-select v-model="params.type" :clear="fetchData" placeholder="搜索类型" clearable :options="TYPE"></t-select>
          <t-input v-model="params.keywords" placeholder="请输入关键词" clearable>
            <template #suffix-icon>
              <t-icon name="search" />
            </template>
          </t-input>

          <t-button theme="primary" @click="fetchData">查询</t-button>
        </t-space>
      </div>
    </div>
    <t-base-table size="small" :data="lists" :columns="COLUMNS" row-key="id" vertical-align="middle" :hover="lists?.length > 0 ? true : false" :pagination="pagination" :loading="dataLoading" :header-affixed-top="headerAffixedTop" max-height="100%" @page-change="rehandlePageChange">
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
          <t-tag v-if="row.status === 0" variant="light-outline" theme="danger">未付款</t-tag>
          <t-tag v-else-if="row.status === 1" variant="light-outline" theme="success"> 已付款</t-tag>
          <t-tag v-else-if="row.status === 2" variant="light-outline" theme="danger">已关闭</t-tag>
          <t-tag v-else-if="row.status === 3" variant="light-outline" theme="danger"> 已退款</t-tag>
        </span>
      </template>
      <template #take_status_text="{ row }">
        <t-tag v-if="row.take_status_text == '未取'" variant="outline" theme="danger"> {{ row.take_status_text }}</t-tag>
        <t-tag v-else-if="row.take_status_text == '已取'" variant="outline" theme="success"> {{ row.take_status_text }}</t-tag>
      </template>
      <template #total_product_price="{ row }">
        <t-space size="small" direction="vertical">
          <span> 总价：{{ row.total_product_price }} </span>
          <span> 实付：{{ row.total_price }} </span>
        </t-space>
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
import { reactive } from 'vue';
import { useRouter } from 'vue-router';

import { list } from '@/api/merchant/order/order';
import Result from '@/components/result/index.vue';
import { table } from '@/hooks/table';
import { copyText } from '@/utils/common';
import { formatTime } from '@/utils/date';

import { COLUMNS, STATUS, TYPE } from './constant';

const router = useRouter();
const params = reactive({
  status: '',
  keywords: '',
  type: '',
});
const { pagination, fetchData, dataLoading, headerAffixedTop, rehandlePageChange, lists, searchData } = table({
  fetchFun: list,
  params,
});

const goPage = (id: number) => {
  router.push({
    name: 'merchantOrderOrderCard',
    query: {
      id,
    },
  });
};

searchData();
</script>
