<template>
  <t-dialog v-model:visible="visible" :close-on-overlay-click="false" :destroy-on-close="true" :header="title" :on-confirm="onSubmit">
    <t-form ref="formRef" label-align="left" :data="formData" :rules="FORM_RULES" :label-width="80">
      <t-form-item label="接口名称" name="title">
        <t-input v-model="formData.title" clearable placeholder="请输入接口名称" />
      </t-form-item>
      <t-form-item label="代码接口" name="code" tips="请输入接口名称(英文标识)，必须是home/settlement里的文件名">
        <t-input v-model="formData.code" clearable placeholder="请输入接口名称(英文标识)" />
      </t-form-item>
      <t-form-item label="显示名称" name="show_name">
        <t-input v-model="formData.show_name" clearable placeholder="显示名称" />
      </t-form-item>
      <t-form-item label="账户字段" name="account_fields">
        <t-textarea v-model="formData.account_fields" clearable placeholder="用户添加渠道账户所需的字段，用“|”分割字段,用:分隔名称，如：应用号:appid|应用秘钥:appsecret" />
      </t-form-item>
      <t-form-item label="状态" name="status">
        <t-radio-group v-model="formData.status" :options="options" />
      </t-form-item>
    </t-form>
  </t-dialog>
</template>

<script lang="ts">
export default {
  name: 'AdminMenuEditPopup',
};
</script>

<script setup lang="ts">
import { FormRule, MessagePlugin } from 'tdesign-vue-next';
import { reactive, ref } from 'vue';

import { detail, edit } from '@/api/admin/channel/collection';

const options = [
  { label: '启用', value: 1 },
  { label: '禁用', value: 0 },
];

const DATA = {
  id: 0,
  title: '',
  code: '',
  show_name: '',
  account_fields: '',
  applyurl: '',
  status: 1,
  is_available: 1,
  sort: 0,
  lowrate: 0,
  type: 1,
  paytype: '',
};
const formData = reactive({ ...DATA });

const visible = ref(false);
const title = ref('添加打款渠道');
const init = (id: number) => {
  if (id) {
    title.value = '编辑打款渠道';
    getDetail(id);
  } else {
    title.value = '添加打款渠道';
    for (const key in DATA) {
      // @ts-ignore
      formData[key] = DATA[key];
    }
  }
  visible.value = true;
};

const getDetail = async (id: number) => {
  const { data } = await detail({ id });
  for (const key in formData) {
    if (data[key] != null && data[key] !== undefined) {
      // @ts-ignore
      formData[key] = data[key];
    }
  }
};

defineExpose({
  init,
});

const FORM_RULES: Record<string, FormRule[]> = {
  name: [{ required: true, message: '必填', type: 'error' }],
  title: [{ required: true, message: '必填', type: 'error' }],
};
const emit = defineEmits(['success']);

const formRef = ref();

const onSubmit = async () => {
  const result = await formRef.value.validate();
  if (typeof result !== 'object' && result) {
    try {
      const res = await edit(formData);
      if (res.code === 1) {
        MessagePlugin.success(res.msg);
        visible.value = false;
        emit('success');
      } else {
        MessagePlugin.error(res.msg);
      }
    } catch (e) {
      MessagePlugin.error(e.msg);
    }
  }
};
</script>
