<template>
  <t-card class="basic-container" :bordered="false">
    <template #title>
      <span style="padding-right: 20px">库存回收站</span>
      <t-button variant="base" :disabled="!selectedRowKeys.length" @click="handleSetupTrash"> 批量恢复 </t-button>
      <t-button variant="base" theme="danger" :disabled="!selectedRowKeys.length" @click="handleDelTrash('')"> 批量删除 </t-button>
      <t-button theme="danger" :disabled="!lists?.length" @click="deleteAll">清空回收站</t-button>
      <p v-if="!!selectedRowKeys.length" class="selected-count">已选{{ selectedRowKeys.length }}项</p>
    </template>
    <template #actions>
      <t-button variant="text" theme="default" @click="router.push('/merchant/goods/card')">
        <template #icon><t-icon name="rollback" /></template>
        返回
      </t-button>
    </template>
    <div class="category-header c-flex">
      <t-space>
        <t-select v-model="params.cate_id" placeholder="全部分类" type="search" clearable :options="categoryList"></t-select>
        <t-select v-model="params.goods_id" placeholder="全部商品" type="search" clearable :options="goodsList" :keys="{ value: 'id', label: 'name' }"></t-select>
        <t-button theme="primary" @click="searchData">查询</t-button>
      </t-space>
    </div>
    <t-table :data="lists" :columns="trashListColumns" row-key="id" :hover="lists?.length ? true : false" :pagination="pagination" :selected-row-keys="selectedRowKeys" :loading="dataLoading" :header-affixed-top="headerAffixedTop" table-layout="auto" max-height="auto" @page-change="rehandlePageChange" @select-change="rehandleSelectChange">
      <template #operation="{ row }">
        <t-space>
          <t-link size="small" variant="outline" theme="primary" @click="initDetail(row)">查看</t-link>
          <t-link size="small" variant="outline" theme="danger" @click="handleDelTrash(row)">删除</t-link>
        </t-space>
      </template>
      <template #empty>
        <result title="" tip="库存回收站为空" type="list"> </result>
      </template>
    </t-table>
    <card-detail ref="cardDetailRef" />
  </t-card>
</template>

<script lang="ts">
export default {
  name: 'CardTrash',
};
</script>

<script setup lang="ts">
import { DialogPlugin, MessagePlugin } from 'tdesign-vue-next';
import { onMounted, reactive, ref } from 'vue';
import { useRouter } from 'vue-router';

import { getGoodsCardTrashList, restore, trashBatchDel, trashBatchDelAll } from '@/api/merchant/goods/card';
import { listSimple as getGoodsCategory } from '@/api/merchant/goods/category';
import { goodList as getGoodsListIdName } from '@/api/merchant/goods/good';
import Result from '@/components/result/index.vue';
import { table } from '@/hooks/table';

import { trashListColumns } from './constant';
import CardDetail from './detail.vue';

const router = useRouter();

const params = reactive({
  cate_id: '',
  goods_id: '',
});
const { pagination, fetchData, dataLoading, headerAffixedTop, rehandlePageChange, lists, searchData } = table({
  fetchFun: getGoodsCardTrashList,
  params,
});

const categoryList = ref([]);
const fetchGoodsCategory = async () => {
  const { data } = await getGoodsCategory();
  categoryList.value = data.list;
};
const goodsList = ref([]);
const fetchGoodsList = async () => {
  const { data } = await getGoodsListIdName();
  goodsList.value = data;
};

const selectedRowKeys = ref([]);
const rehandleSelectChange = (val: number[]) => {
  selectedRowKeys.value = val;
};
// 批量删除
const handleDelTrash = async (res: any) => {
  // 如果id存在，就存到selectedRowKeys
  if (res) {
    rehandleSelectChange(res.id);
  }
  const confirmDia = DialogPlugin({
    header: '确认删除当前所选内容？',
    body: `删除后，所选信息将被清空，且无法恢复`,
    confirmBtn: '确认',
    onConfirm: async () => {
      confirmDia.hide();
      const data = {
        ids: selectedRowKeys.value,
      };
      try {
        await trashBatchDel(data);
        MessagePlugin.success('删除成功');
        // 清空 selectedRowKeys
        selectedRowKeys.value = [];
        fetchData();
      } catch (e) {
        console.log(e);
      }
    },
  });
};
// 恢复
const handleSetupTrash = (id: any) => {
  // 如果id存在，就存到selectedRowKeys
  if (id > 0) {
    rehandleSelectChange(id);
  }

  // 确定要批量恢复吗？
  const confirmDia = DialogPlugin({
    header: '提醒',
    body: `确定要恢复吗？`,
    confirmBtn: '确认',
    onConfirm: () => {
      confirmDia.hide();
      const data = {
        ids: selectedRowKeys.value,
      };
      restore(data)
        .then((res: any) => {
          if (res.code === 1) {
            MessagePlugin.success('恢复成功');
            fetchData();

            selectedRowKeys.value = [];
          } else {
            MessagePlugin.error(res.msg);
          }
        })
        .catch(() => {
          MessagePlugin.error('恢复失败');
        });
    },
    onClose: () => {
      confirmDia.hide();
    },
  });
};
// 清空删除
const deleteAll = () => {
  const confirmDia = DialogPlugin({
    header: '确认清空回收站？',
    body: `清空后，回收站将被清空，且无法恢复`,
    confirmBtn: '确认',
    onConfirm: async () => {
      await trashBatchDelAll();
      MessagePlugin.success('清空成功');
      confirmDia.hide();
      fetchData();
    },
  });
};

onMounted(() => {
  fetchData();
  fetchGoodsCategory();
  fetchGoodsList();
});

const cardDetailRef = ref(null);
const initDetail = async (row: any) => {
  cardDetailRef.value.init(row);
};
</script>

<style lang="less" scoped>
.selected-count {
  display: inline-block;
  margin-left: 8px;
  color: var(--td-text-color-secondary);
}
</style>
