<template>
  <t-card title="商品回收站" class="basic-container" :bordered="false">
    <div class="category-header c-flex">
      <div class="l">
        <t-button variant="base" :disabled="!selectedRowKeys.length" @click="handleSetupTrash()">
          <template #icon><rollback-icon /></template>
          批量恢复
        </t-button>
        <p v-if="!!selectedRowKeys.length" class="selected-count">已选{{ selectedRowKeys.length }}项</p>
      </div>
      <div class="r c-flex">
        <t-space>
          <t-select v-model="params.cate_id" placeholder="全部分类" type="search" clearable :options="categoryList"></t-select>

          <t-input v-model="params.name" placeholder="请输入商品名" clearable>
            <template #suffix-icon>
              <search-icon />
            </template>
          </t-input>
          <t-button theme="primary" @click="searchData">查询</t-button>
        </t-space>
      </div>
    </div>
    <t-table :data="lists" :columns="columns" row-key="id" vertical-align="top" :hover="lists?.length > 0 ? true : false" table-layout="auto" :pagination="pagination" :loading="dataLoading" :header-affixed-top="headerAffixedTop" max-height="100%" @page-change="rehandlePageChange" @select-change="rehandleSelectChange">
      <template #name="{ row }">
        {{ row.name }}
        <t-space size="small" align="center" class="tag-demo light">
          <t-tag v-if="row.wholesale_discount === 1" title="支持批发优惠" theme="success" variant="light" size="small">惠</t-tag>
          <t-tag v-if="row.coupon_type === 1" title="支持优惠券" theme="primary" variant="light" size="small">券</t-tag>
          <t-tag v-if="row.take_card_type !== 0" title="提卡必填或选填取卡密码" theme="warning" variant="light" size="small">取</t-tag>
          <t-tag v-if="row.visit_type === 1" title="商品购买页面需要访问密码" theme="danger" variant="light" size="small">密</t-tag>
        </t-space>
      </template>
      <template #create_at="{ row }">
        <span>{{ formatTime(row.create_at) }}</span>
      </template>
      <template #delete_at="{ row }">
        <span>{{ formatTime(row.delete_at) }}</span>
      </template>
      <template #operation="{ row }">
        <t-space>
          <t-link theme="primary" hover="color" @click="handleSetupTrash(row.id)">恢复</t-link>
        </t-space>
      </template>
      <template #empty>
        <result title="" tip="商品回收站为空" type="list"> </result>
      </template>
    </t-table>
  </t-card>
</template>

<script lang="ts">
export default {
  name: 'GoodsTrash',
};
</script>

<script setup lang="ts">
import { RollbackIcon, SearchIcon } from 'tdesign-icons-vue-next';
import { PrimaryTableCol, TableRowData } from 'tdesign-vue-next';
import { reactive, ref } from 'vue';

import { listSimple } from '@/api/merchant/goods/category';
import { trash } from '@/api/merchant/goods/good';
import Result from '@/components/result/index.vue';
import { table } from '@/hooks/table';
import { useBatchAction } from '@/hooks/useBatchAction';
import { formatTime } from '@/utils/date';

const categoryList = ref([]);
const selectedRowKeys = ref<any>([]);
const params = reactive({
  cate_id: null,
  name: '',
});
const { pagination, fetchData, dataLoading, headerAffixedTop, rehandlePageChange, lists, searchData } = table({
  fetchFun: trash,
  params,
});

const columns: PrimaryTableCol<TableRowData>[] = [
  {
    colKey: 'id',
    type: 'multiple',
  },
  {
    colKey: 'name',
    title: '商品名称',
    ellipsis: true,
    cell: 'name',
  },
  {
    colKey: 'cate_name',
    title: '商品分类',
  },
  {
    colKey: 'price',
    title: '价格',
  },
  {
    colKey: 'create_at',
    title: '创建时间',
  },
  {
    colKey: 'delete_at',
    title: '删除时间',
  },

  {
    colKey: 'operation',
    title: '操作',
    cell: 'operation',
    fixed: 'right',
  },
];

const fetchGoodsCategory = async () => {
  const { data } = await listSimple();
  categoryList.value = data.list;
};

fetchData();
fetchGoodsCategory();

const rehandleSelectChange = (val: number[]) => {
  selectedRowKeys.value = val;
};

const handleSetupTrash = (id = 0) => {
  if (id) {
    selectedRowKeys.value = [id];
  }
  useBatchAction({
    title: '提醒',
    body: `确定要恢复所选数据吗？`,
    ids: selectedRowKeys.value,
    url: '/merchantapi/goods/good/recover',
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
