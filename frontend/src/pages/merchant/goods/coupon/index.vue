<template>
  <t-card title="优惠券列表" class="basic-container" :bordered="false">
    <template #actions>
      <t-button variant="text" theme="default" @click="router.push({ name: 'merchantGoodsCouponTrash' })">
        <template #icon><t-icon name="delete" /></template>
        回收站
      </t-button>
    </template>
    <div class="category-header c-flex">
      <div class="l">
        <t-button @click="router.push({ name: 'merchantGoodsCouponAdd' })"> 添加 </t-button>

        <t-button variant="base" theme="default" :disabled="!selectedRowKeys.length" @click="batchDel"> 批量删除 </t-button>
        <p v-if="!!selectedRowKeys.length" class="selected-count">已选{{ selectedRowKeys.length }}项</p>
      </div>
      <div class="r c-flex"></div>
    </div>

    <t-table :data="lists" :columns="listsColumns" row-key="id" vertical-align="top" :hover="lists?.length ? true : false" :pagination="pagination" :selected-row-keys="selectedRowKeys" :loading="dataLoading" :header-affixed-top="headerAffixedTop" max-height="auto" table-layout="auto" @page-change="rehandlePageChange" @select-change="rehandleSelectChange">
      <template #code="{ row }">
        <span title="点击复制" @click="copyText(row.code)">
          <t-tag :theme="row.status === 1 ? 'success' : 'danger'" variant="outline"> {{ row.code }} </t-tag>
        </span>
      </template>
      <template #amount="{ row }">
        <span v-if="row.type === 1">{{ row.amount }}</span>
        <span v-if="row.type === 100">{{ row.amount }}%</span>
      </template>
      <template #min_banlance="{ row }">
        <span v-if="row.min_banlance">{{ row.min_banlance }}</span>
        <span v-else>-</span>
      </template>
      <template #empty>
        <result title="" tip="优惠券为空" type="list"> </result>
      </template>
    </t-table>
    <export-coupon ref="exportRef" />
  </t-card>
</template>

<script lang="ts">
export default {
  name: 'GoodsCoponIndex',
};
</script>

<script setup lang="ts">
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';

import { getGoodsCouponList } from '@/api/merchant/goods/coupon';
import Result from '@/components/result/index.vue';
import { table } from '@/hooks/table';
import { useBatchAction } from '@/hooks/useBatchAction';
import { copyText } from '@/utils/common';

import { listsColumns } from './components/constant';
import ExportCoupon from './components/ExportCoupon.vue';

const router = useRouter();
const { pagination, fetchData, dataLoading, headerAffixedTop, rehandlePageChange, lists } = table({
  fetchFun: getGoodsCouponList,
});

onMounted(() => {
  fetchData();
});

const selectedRowKeys = ref([]);

const rehandleSelectChange = (val: number[]) => {
  selectedRowKeys.value = val;
};

// 批量删除
const batchDel = () => {
  useBatchAction({
    title: '是否确认删除？',
    body: `未使用的优惠券会被删除至回收站，已使用或者已过期的优惠券会被直接删除！`,
    ids: selectedRowKeys.value,
    url: '/merchantapi/goods/coupon/batchDel',
    fetchList: () => {
      fetchData();
      selectedRowKeys.value = [];
    },
  });
};
</script>
<style lang="less" scoped>
.selected-count {
  display: inline-block;
  margin-left: 8px;
  color: var(--td-text-color-secondary);
}
</style>
