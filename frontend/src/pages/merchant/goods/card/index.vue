<template>
  <t-card class="basic-container" :bordered="false">
    <template #title>
      <span style="padding-right: 20px">库存列表</span>
      <t-button theme="primary" @click="router.push('/merchant/goods/card/add')">
        <template #icon><t-icon name="add" /></template>
        添加库存
      </t-button>
      <t-button theme="danger" @click="batchclearGoodsCards"> 全部清空 </t-button>
      <t-button theme="default" :disabled="!selectedRowKeys.length" @click="batchDel"> 批量删除 </t-button>
      <p v-if="!!selectedRowKeys.length" class="selected-count">已选{{ selectedRowKeys.length }}项</p>
    </template>
    <template #actions>
      <t-button variant="text" theme="default" @click="router.push('/merchant/goods/card/trash')">
        <template #icon><t-icon name="delete" /></template>
        回收站
      </t-button>
    </template>
    <div class="category-header">
      <t-space>
        <t-select v-model="params.cate_id" placeholder="全部分类" clearable :options="goodCateListOptions" />
        <t-select v-model="params.goods_id" placeholder="全部商品" clearable :options="goodListOptions" :keys="{ value: 'id', label: 'name' }" />
        <t-select v-model="params.status" placeholder="全部状态" clearable :options="statusList" />
        <t-input v-model="params.number" placeholder="请输入关键词" clearable>
          <template #suffix-icon>
            <search-icon />
          </template>
        </t-input>

        <t-button theme="primary" @click="searchData">查询</t-button>
      </t-space>
    </div>
    <t-table :data="lists" :columns="listsColumns" row-key="id" :pagination="pagination" :selected-row-keys="selectedRowKeys" :loading="dataLoading" :header-affixed-top="headerAffixedTop" max-height="auto" table-layout="auto" @page-change="rehandlePageChange" @select-change="rehandleSelectChange">
      <template #status="{ row }">
        <t-tag v-if="row.status === 2" variant="light" theme="success">已售</t-tag>
        <t-tag v-else variant="light" theme="danger">未售</t-tag>
      </template>
      <template #operation="{ row }">
        <t-space>
          <t-link theme="primary" hover="color" @click="setRowFrist(row)"> <span v-if="row.is_first === 1" style="color: rgb(8, 43, 139)"> 取消优先 </span> <span v-else> 优先销售 </span></t-link>
          <t-link theme="primary" hover="color" @click="initDetail(row)">查看</t-link>
          <t-link theme="danger" hover="color" @click="delRow(row)">删除</t-link>
        </t-space>
      </template>
      <template #empty>
        <result title="" tip="库存为空" type="list"> </result>
      </template>
    </t-table>

    <card-detail ref="cardDetailRef" />
  </t-card>
</template>

<script lang="ts">
export default {
  name: 'CardIndex',
};
</script>

<script setup lang="ts">
import { SearchIcon } from 'tdesign-icons-vue-next';
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';

import { first, list } from '@/api/merchant/goods/card';
import { listSimple } from '@/api/merchant/goods/category';
import { goodList } from '@/api/merchant/goods/good';
import Result from '@/components/result/index.vue';
import { table } from '@/hooks/table';
import { useBatchAction } from '@/hooks/useBatchAction';

import { listsColumns, statusList } from './constant';
import CardDetail from './detail.vue';

// 加载默认配置options
const goodCateListOptions = ref();
const goodListOptions = ref();
const initOptions = async () => {
  goodCateListOptions.value = (await listSimple()).data.list ?? [];
  goodListOptions.value = (await goodList()).data ?? [];
};
initOptions();

const router = useRouter();

const params = reactive({
  cate_id: '',
  goods_id: '',
  number: '',
  status: '',
});
const { pagination, fetchData, dataLoading, headerAffixedTop, rehandlePageChange, lists, searchData } = table({
  fetchFun: list,
  params,
});
fetchData();

const { query } = router.currentRoute.value as any;
Object.keys(query).forEach((key) => {
  if ((params as any)[key] !== undefined) {
    (params as any)[key] = Number(query[key]);
  }
});

const selectedRowKeys = ref<number[]>([]);

const rehandleSelectChange = (val: number[]) => {
  selectedRowKeys.value = val;
};

const cardDetailRef = ref(null);
const initDetail = async (row: any) => {
  cardDetailRef.value.init(row);
};
const delRow = (row: any) => {
  useBatchAction({
    title: '提醒',
    body: `是否确认删除？`,
    ids: row.id,
    url: '/merchantapi/goods/card/del',
    fetchList: () => {
      fetchData();
      selectedRowKeys.value = [];
    },
  });
};
const setRowFrist = (row: any) => {
  // eslint-disable-next-line camelcase
  const { id, is_first } = row;
  const data = {
    id,
    // eslint-disable-next-line camelcase
    status: is_first === 1 ? 0 : 1,
  };
  first(data).then((res) => {
    if (res.code === 1) {
      fetchData();
    }
  });
};

// 批量删除
const batchDel = () => {
  useBatchAction({
    title: '提醒',
    body: `是否确认删除？点击确认后删除的卡密将被放置回收站`,
    ids: selectedRowKeys.value,
    url: '/merchantapi/goods/card/del',
    fetchList: () => {
      fetchData();
      selectedRowKeys.value = [];
    },
  });
};
const batchclearGoodsCards = () => {
  useBatchAction({
    title: '提醒',
    body: `确定要清空卡密库存吗？点击确认后，卡密库存将被移至回收站！`,
    ids: selectedRowKeys.value,
    url: '/merchantapi/goods/card/clearGoodsCards',
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
