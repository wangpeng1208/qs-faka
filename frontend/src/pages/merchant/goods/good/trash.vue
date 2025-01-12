<template>
  <t-card title="商品回收站" class="basic-container" :bordered="false">
    <div class="category-header c-flex">
      <div class="l">
        <t-space>
          <t-select v-model="searchValue.cate_id" placeholder="全部分类" type="search" clearable :options="categoryList"></t-select>

          <t-input v-model="searchValue.name" placeholder="请输入商品名" clearable>
            <template #suffix-icon>
              <search-icon />
            </template>
          </t-input>

          <t-button theme="default" variant="outline" @click="fetchData">查询</t-button>
        </t-space>
      </div>
      <div class="r c-flex">
        <t-button variant="base" :disabled="!selectedRowKeys.length" @click="handleSetupTrash()">
          <template #icon><rollback-icon /></template>
          批量恢复
        </t-button>
        <p v-if="!!selectedRowKeys.length" class="selected-count">已选{{ selectedRowKeys.length }}项</p>
      </div>
    </div>
    <t-table :data="list" :columns="columns" :row-key="rowKey" vertical-align="top" :hover="list.length > 0 ? true : false" table-layout="auto" :pagination="pagination" :loading="dataLoading" :header-affixed-top="headerAffixedTop" max-height="100%" @page-change="rehandlePageChange" @change="rehandleChange" @select-change="rehandleSelectChange">
      <template #name="{ row }">
        {{ row.name }}
        <t-space size="small" align="center" class="tag-demo light">
          <t-tag v-if="row.wholesale_discount == 1" title="支持批发优惠" theme="success" variant="light" size="small">惠</t-tag>
          <t-tag v-if="row.coupon_type == 1" title="支持优惠券" theme="primary" variant="light" size="small">券</t-tag>
          <t-tag v-if="row.take_card_type != 0" title="提卡必填或选填取卡密码" theme="warning" variant="light" size="small">取</t-tag>
          <t-tag v-if="row.visit_type == 1" title="商品购买页面需要访问密码" theme="danger" variant="light" size="small">密</t-tag>
        </t-space>
      </template>
      <template #create_at="{ row }">
        <span>{{ formatTime(row.create_at) }}</span>
      </template>
      <!-- delete_at -->
      <template #delete_at="{ row }">
        <span>{{ formatTime(row.delete_at) }}</span>
      </template>

      <template #operation="{ row }">
        <t-space>
          <t-link theme="primary" hover="color" @click="handleSetupTrash(row.id)">恢复</t-link>
          <t-link theme="primary" hover="color" @click="editRow(row)">修改</t-link>
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
  name: 'Goods',
};
</script>

<script setup lang="ts">
import { RollbackIcon, SearchIcon } from 'tdesign-icons-vue-next';
import { DialogPlugin, MessagePlugin, PrimaryTableCol, TableRowData } from 'tdesign-vue-next';
import { computed, reactive, ref } from 'vue';
import { useRouter } from 'vue-router';

import { listSimple } from '@/api/merchant/goods/category';
import { recover, trash } from '@/api/merchant/goods/good';
import Result from '@/components/result/index.vue';
import { prefix } from '@/config/global';
import { useSettingStore } from '@/store';
import { formatTime } from '@/utils/date';

const router = useRouter();
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
const store = useSettingStore();

const list = ref([]);
const pagination = ref({
  defaultPageSize: 20,
  total: 0,
  defaultCurrent: 1,
});

const dataLoading = ref(false);
const fetchData = async () => {
  dataLoading.value = true;

  const value = {
    ...searchValue,
    page: pagination.value.defaultCurrent,
    limit: pagination.value.defaultPageSize,
  };
  try {
    const { data } = await trash(value);
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
const searchValue = reactive({
  cate_id: '',
  name: '',
  type: '',
});
const categoryList = ref([]);
const fetchGoodsCategory = async () => {
  const { data } = await listSimple();
  categoryList.value = data.list;
};

fetchData();
fetchGoodsCategory();

const selectedRowKeys = ref<any>([]);
const rowKey = 'id';

const rehandleSelectChange = (val: number[]) => {
  selectedRowKeys.value = val;
};
const rehandlePageChange = (curr: any, pageInfo: any) => {
  pagination.value.defaultCurrent = curr.current;
  pagination.value.defaultPageSize = curr.pageSize;
  fetchData();
};
const rehandleChange = (changeParams: any, triggerAndData: any) => {};

const handleSetupTrash = (id = 0) => {
  if (id) {
    selectedRowKeys.value = [id];
  }
  const confirmDia = DialogPlugin({
    header: '提醒',
    body: `确定要恢复所选数据吗？`,
    confirmBtn: '确认',
    onConfirm: async ({ e }) => {
      confirmDia.hide();
      const res = await recover({
        ids: selectedRowKeys.value,
      });
      if (res.code === 1) {
        fetchData();
        MessagePlugin.success('恢复成功');
      } else {
        MessagePlugin.error(`恢复失败：${res.msg}`);
      }
    },
    onClose: ({ e, trigger }) => {
      confirmDia.hide();
    },
  });
};
const editRow = (row: any) => {
  const { id } = row;
  router.push(`/merchant/goods/edit?id=${id}`);
};
const headerAffixedTop = computed(() => ({
  offsetTop: store.isUseTabsRouter ? 48 : 0,
  container: `.${prefix}-layout`,
}));
</script>
