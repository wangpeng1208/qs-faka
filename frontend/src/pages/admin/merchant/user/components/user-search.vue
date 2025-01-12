<template>
  <t-dialog v-model:visible="visible" :close-on-overlay-click="false" :destroy-on-close="true" header="选择上级用户" :close-on-esc-keydown="false" :footer="false">
    <t-table :data="lists" :columns="columns" row-key="id" :hover="lists.length > 0 ? true : false" :pagination="pagination" :header-affixed-top="headerAffixedTop" table-layout="auto" max-height="100%" @page-change="onPageChange">
      <template #status="{ row }">
        <t-tag v-if="row.status === 1" theme="success">启用</t-tag>
        <t-tag v-else theme="danger">禁用</t-tag>
      </template>

      <template #operate="{ row }">
        <t-link theme="primary" size="small" @click="check(row.id)">选择</t-link>
      </template>
    </t-table>
  </t-dialog>
</template>
<script lang="ts">
export default {
  name: 'UserSearch',
};
</script>
<script setup lang="ts">
import { PrimaryTableCol, TableRowData } from 'tdesign-vue-next';
import { computed, ref } from 'vue';

import { list } from '@/api/admin/merchant/user';
import { prefix } from '@/config/global';
import { useSettingStore } from '@/store';

const emit = defineEmits(['success']);
const check = (id: number) => {
  emit('success', id);
  visible.value = false;
};
const columns: PrimaryTableCol<TableRowData>[] = [
  {
    colKey: 'id',
    title: 'ID',
  },
  {
    colKey: 'username',
    title: '账号',
  },
  {
    colKey: 'operate',
    title: '选择',
  },
];
const pagination = ref({
  defaultPageSize: 20,
  total: 0,
  defaultCurrent: 1,
});
const lists = ref([]);
const userId = ref(0);
const fetchData = async () => {
  const { data } = await list({
    page: pagination.value.defaultCurrent,
    limit: pagination.value.defaultPageSize,
    noUser: userId.value,
  });
  lists.value = data.list;
  pagination.value = {
    ...pagination.value,
    total: data.total,
  };
};
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
const visible = ref(false);
const init = (id: number) => {
  userId.value = id;
  fetchData();
  visible.value = true;
};
defineExpose({
  init,
});
</script>
