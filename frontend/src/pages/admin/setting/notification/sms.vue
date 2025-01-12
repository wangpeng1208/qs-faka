<template>
  <t-card title="短信配置" class="basic-container" :bordered="false">
    <t-table size="small" :data="lists" :columns="columns" row-key="id" vertical-align="middle" :loading="dataLoading" :pagination="pagination" :header-affixed-top="headerAffixedTop" table-layout="fixed" max-height="100%" @page-change="rehandlePageChange">
      <template #operate="{ row }">
        <t-link theme="primary" @click="detailRow(row.value)">设置</t-link>
      </template>
    </t-table>
    <t-dialog v-model:visible="visible" header="编辑短信配置" :on-confirm="onSubmit">
      <t-form>
        <t-form-item label="状态">
          <t-radio-group
            v-model="postData.status"
            :options="[
              { label: '开启', value: 1 },
              { label: '关闭', value: 0 },
            ]"
          />
        </t-form-item>
        <t-form-item v-for="(item, index) in fieldOptions" :key="index" :label="item.label">
          <t-input v-model="postData[item.value]" clearable placeholder="请输入模板名称" />
        </t-form-item>
        <t-form-item label="短信价格">
          <t-input v-model="postData.price" clearable placeholder="短信价格" />
        </t-form-item>
      </t-form>
    </t-dialog>

    <!-- <t-alert theme="success" variant="outline" style="margin-bottom: 10px">因可配置的短信类型过多，其余 短信平台配置新增请到源码中自行配置(/app/admin/controller/system/Sms.php List方法)</t-alert> -->
  </t-card>
</template>

<script lang="ts">
export default {
  name: 'SystemSmsList',
};
</script>

<script setup lang="ts">
import { MessagePlugin, PrimaryTableCol, TableRowData, Tag } from 'tdesign-vue-next';
import { reactive, ref } from 'vue';

import { getSmsConfig, list, setSmsConfig, smsConfig } from '@/api/admin/system/sms';
import { table } from '@/hooks/table';

const columns: PrimaryTableCol<TableRowData>[] = [
  {
    title: '短信平台',
    colKey: 'label',
  },
  {
    title: '短信标识',
    colKey: 'value',
  },
  {
    title: '状态',
    colKey: 'status',
    cell: (h, { row }) => {
      return h(
        Tag,
        {
          size: 'small',
          variant: 'outline',
          theme: row.status === 1 ? 'success' : 'danger',
        },
        () => {
          return row.status === 1 ? '开启' : '关闭';
        },
      );
    },
  },
  {
    title: '操作',
    colKey: 'operate',
    width: 100,
    fixed: 'right',
  },
];

const { pagination, fetchData, dataLoading, headerAffixedTop, rehandlePageChange, lists } = table({
  fetchFun: list,
});
fetchData();

const postData = reactive({} as Record<string, string>);

const fieldOptions = ref();
const getFieldOptions = async (type: String) => {
  const res = await smsConfig({ type });
  if (res.code === 1) {
    // 字段信息
    fieldOptions.value = { ...res.data };
    // 字段值信息
    const optionsValue = await getSmsConfig({ type });
    Object.assign(postData, { ...optionsValue.data });
  } else {
    MessagePlugin.error(`${res.msg}`);
  }
};
const smsType = ref();
const visible = ref(false);
const detailRow = (type: String) => {
  Object.keys(postData).forEach((key) => {
    delete postData[key];
  });
  visible.value = true;
  smsType.value = type;
  getFieldOptions(type);
};
const onSubmit = async () => {
  const res = await setSmsConfig({
    type: smsType.value,
    data: {
      ...postData,
    },
  });
  if (res.code === 1) {
    MessagePlugin.success(`${res.msg}`);
    visible.value = false;
  } else {
    MessagePlugin.error(`${res.msg}`);
  }
};
</script>
