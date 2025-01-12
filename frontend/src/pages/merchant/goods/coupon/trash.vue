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
          <t-button theme="default" variant="outline" @click="fetchData">查询</t-button>
        </t-space>
      </div>
    </div>

    <t-table :data="list" :columns="trashListsColumns" :row-key="rowKey" vertical-align="top" :hover="list.length > 0 ? true : false" :pagination="pagination" :loading="dataLoading" :header-affixed-top="headerAffixedTop" table-layout="auto" max-height="100%" @page-change="rehandlePageChange" @select-change="rehandleSelectChange">
      <template #operation="{ row }">
        <t-button size="small" variant="outline" shape="round" theme="success" @click="handleSetupTrash([row.id])">恢复</t-button>
        <!-- <t-button size="small" variant="outline" shape="round" theme="danger" @click="handleDelTrash(row.id)">删除</t-button> -->
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
import { computed, onMounted, reactive, ref } from 'vue';
import { useRouter } from 'vue-router';

import { listSimple } from '@/api/merchant/goods/category';
import { batchRecoverGoodsCoupon, emptyGoodsCouponTrash, getGoodsCouponTrashList } from '@/api/merchant/goods/coupon';
import Result from '@/components/result/index.vue';
import { prefix } from '@/config/global';
import { useSettingStore } from '@/store';

import { statusList, trashListsColumns } from './components/constant';

const router = useRouter();
const store = useSettingStore();

const rowKey = 'id';
const list = ref([]);
const pagination = ref({
  defaultPageSize: 15,
  total: 0,
  defaultCurrent: 1,
});
const params = reactive({
  cate_id: '',
  status: '',
});
const dataLoading = ref(false);
const fetchData = async () => {
  dataLoading.value = true;
  const value = {
    ...params,
    page: pagination.value.defaultCurrent,
    limit: pagination.value.defaultPageSize,
  };
  try {
    const { data } = await getGoodsCouponTrashList(value);
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

const categoryList = ref([]);
const fetchGoodsCategory = async () => {
  const { data } = await listSimple();
  categoryList.value = data.list;
};

onMounted(() => {
  fetchData();
  fetchGoodsCategory();
});

const rehandlePageChange = (curr: any, pageInfo: any) => {
  pagination.value.defaultCurrent = curr.current;
  pagination.value.defaultPageSize = curr.pageSize;
  fetchData();
};

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
    onConfirm: ({ e }) => {
      confirmDia.hide();
      const data = {
        ids: selectedRowKeys.value,
      };
      batchRecoverGoodsCoupon(data)
        .then((res) => {
          if (res.code === 1) {
            MessagePlugin.success('恢复成功');
            selectedRowKeys.value = [];
            fetchData();
          } else {
            MessagePlugin.error(`恢复失败：${res.msg}`);
          }
        })
        .catch((error) => {
          MessagePlugin.error('恢复失败');
        });
    },
    onClose: ({ e, trigger }) => {
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
            MessagePlugin.success('操作成功');
            selectedRowKeys.value = [];
            fetchData();
          } else {
            MessagePlugin.error(`操作失败：${res.msg}`);
          }
        })
        .catch((error) => {
          MessagePlugin.error('操作失败');
        });
    },
    onClose: ({ e, trigger }) => {
      confirmDia.hide();
    },
  });
};

const headerAffixedTop = computed(() => ({
  offsetTop: store.isUseTabsRouter ? 48 : 0,
  container: `.${prefix}-layout`,
}));
</script>

<style lang="less" scoped>
.selected-count {
  display: inline-block;
  margin-left: 8px;
  color: var(--td-text-color-secondary);
}
</style>
