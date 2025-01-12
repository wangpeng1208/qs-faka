<template>
  <t-card title="商铺管理" class="basic-container" :bordered="false">
    <t-base-table ref="tableRef" row-key="id" :data="lists" :columns="columns" :hover="lists.length > 0 ? true : false" :header-affixed-top="headerAffixedTop" max-height="auto" table-layout="auto" :pagination="pagination" lazy-load @page-change="onPageChange">
      <template #operate="{ row }">
        <t-space>
          <t-link theme="primary" size="small" @click="deatilRow(row)">详情</t-link>
        </t-space>
      </template>
    </t-base-table>
    <row-detail ref="detailRef" @success="fetchData" />
  </t-card>
</template>
<script setup lang="ts">
import { PrimaryTableCol, TableRowData, Tag } from 'tdesign-vue-next';
import { computed, ref } from 'vue';

import { list } from '@/api/admin/merchant/shop';
import { prefix } from '@/config/global';
import { useSettingStore } from '@/store';
import { formatTime } from '@/utils/date';

import RowDetail from './detail.vue';

const columns: PrimaryTableCol<TableRowData>[] = [
  {
    colKey: 'id',
    title: 'ID',
  },
  {
    colKey: 'username',
    title: '用户名',
  },
  {
    colKey: 'shop_name',
    title: '商铺名',
  },
  {
    colKey: 'shop_verify',
    title: '审核状态',
    cell: (h, { row }) => {
      return h(
        Tag,
        {
          variant: 'light',
          theme: row.shop_verify === 1 ? 'primary' : 'danger',
        },
        () => {
          switch (row.shop_verify) {
            case 0:
              return '已拒绝';
            case 1:
              return '已审核';
            case -1:
              return '审核中';
            default:
              return '未知';
          }
        },
      );
    },
  },
  {
    colKey: 'shop_freeze',
    title: '冻结状态',
    cell: (h, { row }) => {
      return h(
        Tag,
        {
          variant: 'light',
          theme: row.shop_freeze === 1 ? 'danger' : 'primary',
        },
        () => {
          return row.shop_freeze === 1 ? '冻结' : '正常';
        },
      );
    },
  },
  {
    colKey: 'create_at',
    title: '添加时间',
    cell: (h, { row }) => {
      return formatTime(row.create_at);
    },
  },
  {
    colKey: 'merchant_end_time',
    title: '到期时间',
    cell: (h, { row }) => {
      return formatTime(row.merchant_end_time);
    },
  },
  {
    colKey: 'operate',
    title: '操作',
    fixed: 'right',
  },
];

const pagination = ref({
  defaultPageSize: 20,
  total: 0,
  defaultCurrent: 1,
});
const lists = ref([]);
const fetchData = async () => {
  const { data } = await list({
    page: pagination.value.defaultCurrent,
    limit: pagination.value.defaultPageSize,
  });
  lists.value = data.list;
  pagination.value = {
    defaultPageSize: data.limit,
    total: data.total,
    defaultCurrent: data.page,
  };
};
fetchData();
const onPageChange = (curr: any) => {
  pagination.value.defaultCurrent = curr.current;
  pagination.value.defaultPageSize = curr.pageSize;
  fetchData();
};
const store = useSettingStore();
const headerAffixedTop = computed(() => ({
  offsetTop: store.isUseTabsRouter ? 48 : 0,
  container: `.${prefix}-layout`,
}));

const detailRef = ref();
const deatilRow = (row: { [key: string]: any } | null = null) => {
  detailRef.value.init(row);
};
</script>
