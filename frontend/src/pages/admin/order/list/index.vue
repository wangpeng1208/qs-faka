<template>
  <t-card title="订单列表" class="basic-container" :bordered="false">
    <row-search :pay-type-options="payTypeOptions" @success="searchFetchData" />
    <div class="category-header c-flex">
      <div class="l">
        <t-radio-group v-model="dateType" default-value="1" @change="dataTypeChange">
          <t-radio-button value="">全部</t-radio-button>
          <t-radio-button value="1">今日</t-radio-button>
          <t-radio-button value="2">昨日</t-radio-button>
          <t-radio-button value="3">本周</t-radio-button>
          <t-radio-button value="4">本月</t-radio-button>
          <t-radio-button value="5">本年</t-radio-button>
        </t-radio-group>
      </div>

      <div class="r c-flex">
        <t-button theme="warning" @click="clearData">清空无效</t-button>
      </div>
    </div>
    <t-table :data="lists" :columns="columns" row-key="id" vertical-align="middle" :hover="lists?.length > 0 ? true : false" :pagination="pagination" :header-affixed-top="headerAffixedTop" table-layout="fixed" max-height="100%" :loading="dataLoading" @page-change="rehandlePageChange">
      <template #operate="{ row }">
        <t-dropdown :options="getOperateOptions(row)" @click="handleOperateClick">
          <t-button theme="default" variant="text" size="small">
            操作
            <template #suffix>
              <t-icon name="chevron-down" />
            </template>
          </t-button>
        </t-dropdown>
      </template>
    </t-table>
    <row-detail ref="detailRef" :pay-type-options="payTypeOptions" />
  </t-card>
</template>

<script setup lang="ts">
import { MessagePlugin } from 'tdesign-vue-next';
import { reactive, ref } from 'vue';

import { payTypeSimple } from '@/api/admin/channel/pay_type';
import { clear, del, list } from '@/api/admin/order/order';
import { baseUrl } from '@/api/base';
import { table } from '@/hooks/table';

import { columns, createOperateDropdown, hadleFreeze, handleNotifyExport } from './components/constant';
import RowDetail from './components/detail.vue';
import RowSearch from './components/search.vue';

const params = reactive<any>({});
const { pagination, fetchData, dataLoading, headerAffixedTop, rehandlePageChange, lists, searchData } = table({
  fetchFun: list,
  params,
});
fetchData();
// 搜索
const searchFetchData = async (newParams = {}) => {
  Object.assign(params, newParams);
  searchData();
};

const dateType = ref('');
const dataTypeChange = (val: any) => {
  params.date_type = val;
  searchData();
};
const clearData = async () => {
  const res = await clear();
  if (res.code === 1) {
    MessagePlugin.success(res.msg);
    fetchData();
  } else {
    MessagePlugin.error(res.msg);
  }
};

// 详情
const detailRef = ref<InstanceType<typeof RowDetail>>();
const detailRow = (row: any) => {
  detailRef.value?.init(row);
};

const delRow = async (row: any) => {
  const res = await del({
    id: row.id,
  });
  if (res.code === 1) {
    MessagePlugin.success(res.msg);
    fetchData();
  } else {
    MessagePlugin.error(res.msg);
  }
};

const payTypeOptions = ref();
// 加载支付分类
const initPayTypeOptions = async () => {
  const { data } = await payTypeSimple();
  data.forEach((item: any, key: any) => {
    data[key].ico = baseUrl + item.ico;
  });
  payTypeOptions.value = data;
};
initPayTypeOptions();

// 操作下拉菜单
const getOperateOptions = (row: any) => {
  return createOperateDropdown(row, detailRow, delRow, handleNotifyExport, hadleFreeze);
};

const handleOperateClick = (data: any) => {
  if (data.value && typeof data.onClick === 'function') {
    data.onClick();
  }
};
</script>

<style scoped>
.merchant-info-cell {
  line-height: 1.4;
}

.buyer-info-cell {
  line-height: 1.4;
}

.status-info-cell {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.category-header {
  justify-content: space-between;
  align-items: center;
}

.category-header .l {
  flex: 1;
}

.category-header .r {
  gap: 8px;
}
</style>
