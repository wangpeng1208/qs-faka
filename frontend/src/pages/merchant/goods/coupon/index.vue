<template>
  <t-card title="优惠券列表" class="basic-container" :bordered="false">
    <div class="category-header c-flex">
      <div class="l">
        <t-button @click="router.push({ name: 'merchantGoodsCouponAdd' })"> 添加 </t-button>
        <t-button theme="danger" @click="router.push({ name: 'merchantGoodsCouponTrash' })"> 回收站 </t-button>
        <t-button variant="base" theme="default" :disabled="!selectedRowKeys.length" @click="batchDel"> 批量删除 </t-button>
        <p v-if="!!selectedRowKeys.length" class="selected-count">已选{{ selectedRowKeys.length }}项</p>
      </div>
      <div class="r c-flex"></div>
    </div>

    <t-table :data="list" :columns="listsColumns" row-key="id" vertical-align="top" :hover="list.length ? true : false" :pagination="pagination" :selected-row-keys="selectedRowKeys" :loading="dataLoading" :header-affixed-top="headerAffixedTop" max-height="auto" table-layout="auto" @page-change="rehandlePageChange" @select-change="rehandleSelectChange">
      <template #code="{ row }">
        <span title="点击复制" @click="copyText(row.code)">
          {{ row.code }}
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
      <template #expire_day="{ row }">
        {{ row.expire_day }}
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
import { DialogPlugin, MessagePlugin } from 'tdesign-vue-next';
import { computed, onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';

import { batchDelGoodsCoupon, getGoodsCouponList } from '@/api/merchant/goods/coupon';
import Result from '@/components/result/index.vue';
import { prefix } from '@/config/global';
import { useSettingStore } from '@/store';
import { copyText } from '@/utils/common';

import { listsColumns } from './components/constant';
import ExportCoupon from './components/ExportCoupon.vue';

const router = useRouter();
const store = useSettingStore();
const list = ref([]);
const pagination = ref({
  defaultPageSize: 20,
  total: 0,
  defaultCurrent: 1,
});

const dataLoading = ref(false);
const fetchData = async () => {
  const value = {
    page: pagination.value.defaultCurrent,
    limit: pagination.value.defaultPageSize,
  };
  dataLoading.value = true;
  try {
    const { data } = await getGoodsCouponList(value);
    list.value = data.list;
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

onMounted(() => {
  fetchData();
});

const selectedRowKeys = ref([]);

const rehandleSelectChange = (val: number[]) => {
  selectedRowKeys.value = val;
};
const rehandlePageChange = (curr: any, pageInfo: any) => {
  pagination.value.defaultCurrent = curr.current;
  pagination.value.defaultPageSize = curr.pageSize;
  fetchData();
};

const headerAffixedTop = computed(() => ({
  offsetTop: store.isUseTabsRouter ? 48 : 0,
  container: `.${prefix}-layout`,
}));

// 批量删除
const batchDel = async () => {
  const confirmDia = DialogPlugin({
    header: '是否确认删除？',
    body: `未使用的优惠券会被删除至回收站，已使用或者已过期的优惠券会被直接删除！`,
    confirmBtn: '确认',
    onConfirm: ({ e }) => {
      confirmDia.hide();
      const data = {
        ids: selectedRowKeys.value,
      };
      batchDelGoodsCoupon(data)
        .then((res) => {
          if (res.code === 1) {
            MessagePlugin.success(res.msg);
            fetchData();
            // 重置选中
            selectedRowKeys.value = [];
          } else {
            MessagePlugin.error(`删除失败：${res.msg}`);
          }
        })
        .catch((error) => {
          MessagePlugin.error('删除失败');
        });
    },
    onClose: ({ e, trigger }) => {
      confirmDia.hide();
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

:deep(.t-table th),
:deep(.t-table td) {
  position: relative;
  padding: var(--td-comp-paddingTB-m) 0;
}
</style>
