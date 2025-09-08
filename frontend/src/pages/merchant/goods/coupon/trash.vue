<template>
  <t-card title="优惠券回收站" class="basic-container" :bordered="false">
    <template #actions>
      <t-button variant="text" theme="default" @click="router.push('/merchant/goods/coupon')">
        <template #icon><t-icon name="rollback" /></template>
        返回
      </t-button>
    </template>
    <div class="category-header c-flex">
      <div class="l">
        <t-button variant="base" :disabled="!selectedRowKeys.length" @click="handleSetupTrash"> 批量恢复 </t-button>
        <t-button variant="base" theme="danger" @click="handleDelTrash"> 清空回收站 </t-button>
        <p v-if="!!selectedRowKeys.length" class="selected-count">已选{{ selectedRowKeys.length }}项</p>
      </div>
      <div class="r c-flex">
        <t-space>
          <t-select v-model="params.cate_id" placeholder="全部分类" type="search" clearable :options="categoryList"></t-select>
          <t-select v-model="params.status" placeholder="全部状态" type="search" clearable :options="statusList"></t-select>
          <t-button theme="primary" @click="searchData">查询</t-button>
        </t-space>
      </div>
    </div>

    <t-table :data="lists" :columns="trashListsColumns" row-key="id" vertical-align="top" :hover="lists?.length > 0 ? true : false" :pagination="pagination" :loading="dataLoading" :header-affixed-top="headerAffixedTop" table-layout="auto" max-height="100%" @page-change="rehandlePageChange" @select-change="rehandleSelectChange">
      <template #operation="{ row }">
        <t-button size="small" variant="outline" shape="round" theme="success" @click="handleSetupTrash([row.id])">恢复</t-button>
      </template>
      <template #empty>
        <result title="" tip="优惠券回收站为空" type="list"> </result>
      </template>
    </t-table>
  </t-card>
</template>

<script lang="ts">
export default {
  name: 'GoodsCouponTrash',
};
</script>

<script setup lang="ts">
import { DialogPlugin, MessagePlugin } from 'tdesign-vue-next';
import { onMounted, reactive, ref } from 'vue';
import { useRouter } from 'vue-router';

import { listSimple } from '@/api/merchant/goods/category';
import { batchRecoverGoodsCoupon, emptyGoodsCouponTrash, getGoodsCouponTrashList } from '@/api/merchant/goods/coupon';
import Result from '@/components/result/index.vue';
import { table } from '@/hooks/table';

import { statusList, trashListsColumns } from './components/constant';

const { pagination, fetchData, dataLoading, headerAffixedTop, rehandlePageChange, lists, searchData } = table({
  fetchFun: getGoodsCouponTrashList,
});
const router = useRouter();

const params = reactive({
  cate_id: '',
  status: '',
});

const categoryList = ref([]);
const fetchGoodsCategory = async () => {
  const { data } = await listSimple();
  categoryList.value = data.list;
};

onMounted(() => {
  fetchData();
  fetchGoodsCategory();
});

const selectedRowKeys = ref([]);
const rehandleSelectChange = (val: number[]) => {
  selectedRowKeys.value = val;
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
      batchRecoverGoodsCoupon(data)
        .then((res) => {
          if (res.code === 1) {
            MessagePlugin.success(res.msg);
            selectedRowKeys.value = [];
            fetchData();
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
const handleDelTrash = (id: any) => {
  if (id > 0) {
    rehandleSelectChange(id);
  }
  const confirmDia = DialogPlugin({
    header: '提醒',
    body: `确定要清空吗？清空后将无法恢复`,
    confirmBtn: '确认',
    onConfirm: ({ e }) => {
      confirmDia.hide();
      const data = {
        id: selectedRowKeys.value,
      };
      emptyGoodsCouponTrash(data)
        .then((res) => {
          if (res.code === 1) {
            MessagePlugin.success(res.msg);
            selectedRowKeys.value = [];
            fetchData();
          } else {
            MessagePlugin.error(res.msg);
          }
        })
        .catch(() => {
          MessagePlugin.error('操作失败');
        });
    },
    onClose: () => {
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
</style>
