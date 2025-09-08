<template>
  <t-dialog v-model:visible="visible" :close-on-overlay-click="false" :destroy-on-close="true" :footer="false" header="角色费率" width="900px">
    <t-alert>优先级：用户费率》角色费率》通道费率。此处可将通道费率自定义提升到角色费率</t-alert>
    <t-table row-key="id" :data="lists" :columns="columns" :hover="lists?.length > 0 ? true : false" :header-affixed-top="headerAffixedTop" :pagination="pagination" lazy-load table-layout="auto" max-height="100%" :loading="dataLoading" @page-change="rehandlePageChange"> </t-table>
  </t-dialog>
</template>

<script setup lang="ts">
import { assign } from 'lodash-es';
import { InputNumber, MessagePlugin, PrimaryTableCol, Select, TableRowData } from 'tdesign-vue-next';
import { reactive, ref } from 'vue';

import { editRate, rateList } from '@/api/admin/merchant/role';
import { table } from '@/hooks/table';

const STATUS_OPTIONS = [
  { label: '角色费率', value: 1 },
  { label: '通道费率', value: 0 },
];

const params = reactive({
  channel_id: 0,
  rate: 0,
  status: 0,
  role_id: 0,
});
const { pagination, fetchData, dataLoading, headerAffixedTop, rehandlePageChange, lists, searchData } = table({
  fetchFun: rateList,
  params,
});

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
        params.rate = context.newRowData.rate;
        params.channel_id = context.newRowData.id;
        params.status = context.newRowData.status;
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
        // clearable: true,
        options: STATUS_OPTIONS,
      },
      onEdited: (context) => {
        params.rate = context.newRowData.rate;
        params.channel_id = context.newRowData.id;
        params.status = context.newRowData.status;
        eidt();
      },
    },
  },
];

const eidt = async () => {
  const res = await editRate({
    ...params,
  });
  if (res.code === 1) {
    MessagePlugin.success(res.msg);
    fetchData();
  } else {
    MessagePlugin.error(res.msg);
  }
};

const visible = ref(false);

const init = (id: number) => {
  assign(params, { id, role_id: id });
  console.log(params);
  searchData();
  visible.value = true;
};

defineExpose({
  init,
});
</script>
