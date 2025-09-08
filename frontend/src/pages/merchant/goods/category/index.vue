<template>
  <t-card title="商品分类" class="basic-container" :bordered="false">
    <t-table :data="lists" drag-sort="row-handler" :columns="COLUMNS" row-key="id" vertical-align="middle" :hover="lists?.length > 0 ? true : false" :selected-row-keys="selectedRowKeys" :loading="dataLoading" lazy-load :header-affixed-top="headerAffixedTop" max-height="90%" :pagination="pagination" @drag-sort="onDragSort" @page-change="rehandlePageChange" @select-change="rehandleSelectChange">
      <template #topContent>
        <t-button v-perms="['merchantapi/goods/category/add']" style="margin-bottom: 15px" @click="addRow()"> 添加 </t-button>
      </template>
      <template #goods_count="{ row }">
        <t-space>
          <t-link theme="primary" @click="router.push(`/merchant/goods/index?cate_id=${row.id}`)"> {{ row.goods_count }} </t-link>
        </t-space>
      </template>
      <template #status="{ row }">
        <t-switch v-model="row.status" :custom-value="[1, 0]" @click="onChangeStatus(row)" />
      </template>
      <template #is_show="{ row }">
        <t-switch v-model="row.is_show" :custom-value="[1, 0]" @click="onChangeShow(row)" />
      </template>

      <template #operation="{ row }">
        <t-space>
          <t-link v-perms="['merchantapi/goods/category']" theme="primary" hover="color" @click="showCategoryLink(row)">链接</t-link>
          <t-link v-perms="['merchantapi/goods/card']" theme="primary" hover="color" @click="router.push(`/merchant/goods/card?cate_id=${row.id}`)">库存</t-link>
          <t-link v-perms="['merchantapi/goods/category/edit']" theme="primary" hover="color" @click="editRow(row)">编辑</t-link>
          <t-link v-perms="['merchantapi/goods/category/del']" theme="danger" hover="color" @click="delRow(row)">删除</t-link>
        </t-space>
      </template>
      <template #empty>
        <result title="" tip="商品分类为空" type="list"> </result>
      </template>
    </t-table>

    <link-popup ref="linkRef" />
    <edit-popup ref="editRef" @success="fetchData" />
  </t-card>
</template>

<script lang="ts">
export default {
  name: 'GoodsCategory',
};
</script>

<script setup lang="ts">
import { NotifyPlugin } from 'tdesign-vue-next';
import { nextTick, ref } from 'vue';
import { useRouter } from 'vue-router';

import { list, status } from '@/api/merchant/goods/category';
import Result from '@/components/result/index.vue';
import { table } from '@/hooks/table';
import { useBatchAction } from '@/hooks/useBatchAction';

import { COLUMNS } from './components/constant';
import EditPopup from './components/edit.vue';
import LinkPopup from './components/link.vue';

const router = useRouter();
const { pagination, fetchData, dataLoading, headerAffixedTop, rehandlePageChange, lists } = table({
  fetchFun: list,
  params: {
    name: '',
    status: '',
  },
});

fetchData();

const selectedRowKeys = ref([]);
const rehandleSelectChange = (val: number[]) => {
  selectedRowKeys.value = val;
};

// 链接弹窗
const linkRef = ref<InstanceType<typeof LinkPopup>>();
const showCategoryLink = async (row: any) => {
  await nextTick();
  linkRef.value?.featchCategoryLink(row.id);
  linkRef.value?.getTemplate();
  linkRef.value?.getUserTemplate(row.id);
};
// 编辑添加弹窗
const editRef = ref<InstanceType<typeof EditPopup>>();
const editRow = async (row: any) => {
  await nextTick();
  editRef.value?.open('edit');
  editRef.value?.getDetail(row);
};

const addRow = async () => {
  await nextTick();
  editRef.value?.open('add');
};

const delRow = async (row: any) => {
  useBatchAction({
    title: '提醒',
    body: `是否确认删除？`,
    ids: row.id,
    url: '/merchantapi/goods/category/del',
    fetchList: () => {
      fetchData();
      selectedRowKeys.value = [];
    },
  });
};

const changeRow = async (data: any) => {
  const result = await status(data);
  if (result.code === 1) {
    fetchData();
    NotifyPlugin.success({ title: '提醒', content: result.msg });
  } else {
    NotifyPlugin.error({ title: '提醒', content: result.msg });
  }
};

const onChangeStatus = async (row: any) => {
  const { id, status } = row;
  const data = {
    id,
    field: 'status',
    value: status,
  };
  changeRow(data);
};
const onChangeShow = async (row: any) => {
  const data = {
    id: row.id,
    field: 'is_show',
    value: row.is_show,
  };
  changeRow(data);
};
const onDragSort = (params: any) => {
  if (params.currentIndex - params.targetIndex > 0) {
    // 上移
    const data = {
      id: params.current.id,
      field: 'sort',
      value: params.target.sort + 1,
    };
    changeRow(data);
  } else {
    // 下移
    const data = {
      id: params.current.id,
      field: 'sort',
      value: params.target.sort - 1,
    };
    changeRow(data);
  }
};
</script>
