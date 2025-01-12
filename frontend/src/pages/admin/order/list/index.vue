<template>
  <t-card title="订单列表" class="basic-container" :bordered="false">
    <template #actions>
      <a href="javascript:void(0)" @click="showSearchFrom = !showSearchFrom">{{ searchText }}</a>
    </template>
    <div class="category-header c-flex">
      <row-search v-if="showSearchFrom" ref="searchFormRef" :pay-type-options="payTypeOptions" @success="searchFetchData" />
    </div>
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
        <t-button @click="clearData">清空无效</t-button>
      </div>
    </div>
    <t-table size="small" :data="lists" :columns="columns" row-key="id" vertical-align="middle" :hover="lists.length > 0 ? true : false" :pagination="pagination" :header-affixed-top="headerAffixedTop" table-layout="fixed" max-height="100%" @page-change="rehandlePageChange">
      <template #operate="{ row }">
        <t-space>
          <t-link theme="primary" @click="detailRow(row)">详情</t-link>
          <t-link v-perms="['adminapi/order/order/del']" theme="danger" @click="delRow(row)">删除</t-link>
        </t-space>
      </template>
      <template #empty>
        <!-- <result title="" tip="暂无相关数据 " type="list"> </result> -->
      </template>
    </t-table>
    <row-detail ref="detailRef" :pay-type-options="payTypeOptions" />
  </t-card>
</template>

<script setup lang="ts">
// todo 搜索和时间选择时关联异常；导出数据
import { MessagePlugin } from 'tdesign-vue-next';
import { computed, reactive, ref } from 'vue';

import { payTypeSimple } from '@/api/admin/channel/pay_type';
import { clear, del, list } from '@/api/admin/order/order';
import { baseUrl } from '@/api/base';
import { prefix } from '@/config/global';
import { useSettingStore } from '@/store';
import { downloadFile } from '@/utils/common';

import { columns } from './components/constant';
import RowDetail from './components/detail.vue';
import RowSearch from './components/search.vue';

const pagination = ref({
  defaultPageSize: 20,
  total: 0,
  defaultCurrent: 1,
});
const lists = ref([]);
// 搜索
const searchData = reactive<any>({});
const showSearchFrom = ref(false);
const searchText = computed(() => (showSearchFrom.value ? '收起搜索' : '展开搜索'));
const dateType = ref('');
// dateType变化
const dataTypeChange = (val: any) => {
  searchData.date_type = val;
  searchFetchData();
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
// 搜索
const searchFetchData = async (params = {}) => {
  // params 合并到 searchData
  Object.assign(searchData, params);
  pagination.value.defaultPageSize = 20;
  delete searchData.action;
  fetchData();
};
// 数据加载
const fetchData = async () => {
  const value = {
    page: pagination.value.defaultCurrent,
    limit: pagination.value.defaultPageSize,
    ...searchData,
  };
  const res = await list(value);
  if (searchData.action === 'dump') {
    if (res.code === 1) {
      MessagePlugin.success(res.msg);
      downloadFile(res.data.url);
    } else {
      MessagePlugin.error(res.msg);
    }
  } else {
    lists.value = res.data.list;
    pagination.value = {
      ...pagination.value,
      total: res.data.total,
    };
  }
};
fetchData();

const rehandlePageChange = (curr: any) => {
  pagination.value.defaultCurrent = curr.current;
  pagination.value.defaultPageSize = curr.pageSize;
  fetchData();
};
// 详情
const detailRef = ref();
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

const store = useSettingStore();
const headerAffixedTop = computed(() => ({
  offsetTop: store.isUseTabsRouter ? 48 : 0,
  container: `.${prefix}-layout`,
}));
</script>
