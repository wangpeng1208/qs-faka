<template>
  <t-dialog v-model:visible="visible" :close-on-overlay-click="false" :destroy-on-close="true" :footer="false" :header="header" width="900px">
    <t-radio-group v-model="formData.rate_type" name="rate_type" :options="userRoleTypeOption" @change="rateTypeChange"></t-radio-group>
    <t-divider />
    <div v-if="formData.rate_type === 0">
      <t-alert>自行到“分配角色”里设置</t-alert>
    </div>
    <div v-if="formData.rate_type === 1">
      <t-alert> 模式：用户费率 为设置该用户在该通道的费率；通道费率 则遵循对应通道的费率 </t-alert>
      <t-table ref="tableRef" row-key="id" :data="lists" :columns="columns" :hover="lists.length > 0 ? true : false" :header-affixed-top="headerAffixedTop" :pagination="pagination" lazy-load table-layout="auto" max-height="100%" @page-change="onPageChange"> </t-table>
    </div>
  </t-dialog>
</template>

<script setup lang="ts">
import { InputNumber, MessagePlugin, PrimaryTableCol, Select, TableRowData } from 'tdesign-vue-next';
import { computed, reactive, ref } from 'vue';

import { editRate, rateList, setRateType } from '@/api/admin/merchant/user';
import { prefix } from '@/config/global';
import { useSettingStore } from '@/store';

const rateTypeChange = async () => {
  await setRateType({
    user_id: formData.user_id,
    type: formData.rate_type,
  });
};
const userRoleTypeOption = [
  { label: '使用角色分组', value: 0 },
  { label: '单独定义', value: 1 },
];

const STATUS_OPTIONS = [
  { label: '用户费率', value: 1 },
  { label: '通道费率', value: 0 },
];
const columns: PrimaryTableCol<TableRowData>[] = [
  {
    colKey: 'id',
    title: 'ID',
  },
  {
    colKey: 'title',
    title: '通道名称',
  },
  {
    colKey: 'show_name',
    title: '显示名称',
  },
  {
    colKey: 'is_custom',
    title: '通道类型',
    cell: (h, { row }) => (row.is_custom ? '用户通道' : '官方通道'),
  },
  {
    colKey: 'rate',
    title: '费率',
    edit: {
      //   keepEditMode: true,
      component: InputNumber,
      props: {
        // clearable: true,
        autofocus: true,
        placeholder: '请输入费率',
        tips: '单位：千分率',
        suffix: '‰',
        theme: 'normal',
        min: 0,
      },
      validateTrigger: 'change',
      abortEditOnEvent: ['onEnter'],
      // 编辑完成，退出编辑态后触发
      onEdited: (context) => {
        formData.rate = context.newRowData.rate;
        formData.channel_id = context.newRowData.id;
        formData.status = context.newRowData.status;
        eidt();
      },
      rules: [{ required: true, message: '不能为空' }],
      // 默认是否为编辑状态
      defaultEditable: false,
    },
  },
  {
    colKey: 'status',
    title: '模式',
    cell: (h, { row }) => STATUS_OPTIONS.find((t) => t.value === row.status)?.label,
    edit: {
      component: Select,
      props: {
        options: STATUS_OPTIONS,
      },
      onEdited: (context) => {
        formData.rate = context.newRowData.rate;
        formData.channel_id = context.newRowData.id;
        formData.status = context.newRowData.status;
        eidt();
      },
    },
  },
];

const formData = reactive({
  rate_type: 1,
  channel_id: 0,
  rate: 0,
  status: 0,
  user_id: 0,
});
const eidt = async () => {
  const res = await editRate({
    ...formData,
  });
  if (res.code === 1) {
    MessagePlugin.success('操作成功');
    fetchList();
  }
};

const visible = ref(false);

const header = ref();

const init = (row: any) => {
  formData.user_id = row.id;
  header.value = `${row.username} 用户费率设置`;
  fetchList();
  visible.value = true;
};

const pagination = ref({
  defaultPageSize: 20,
  total: 0,
  defaultCurrent: 1,
});
const lists = ref([]);
// 加载通道数据
const fetchList = async () => {
  const { data } = await rateList({
    id: formData.user_id,
  });
  lists.value = data.list;
  formData.rate_type = data.user.rate_type;
  pagination.value.total = data.total;
};

const onPageChange = (curr: any) => {
  pagination.value.defaultCurrent = curr.current;
  pagination.value.defaultPageSize = curr.pageSize;
  fetchList();
};

const store = useSettingStore();
const headerAffixedTop = computed(() => ({
  offsetTop: store.isUseTabsRouter ? 48 : 0,
  container: `.${prefix}-layout`,
}));
defineExpose({
  init,
});
</script>
