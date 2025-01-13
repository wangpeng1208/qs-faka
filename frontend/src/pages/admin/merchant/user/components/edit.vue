<template>
  <t-dialog v-model:visible="visible" :close-on-overlay-click="false" :destroy-on-close="true" :header="title" :on-confirm="onSubmit">
    <t-form ref="formRef" label-align="left" :data="formData" :rules="FORM_RULES" :label-width="80">
      <t-form-item label="结算周期" name="settlement_type">
        <t-radio-group v-model="formData.settlement_type" :options="settlementTypeOption" />
      </t-form-item>
      <t-form-item label="用户名" name="username">
        <t-input v-model="formData.username" clearable placeholder="请输入用户名" />
      </t-form-item>
      <t-form-item label="邮箱" name="email">
        <t-input v-model="formData.email" clearable placeholder="请输入邮箱" />
      </t-form-item>
      <t-form-item label="手机号" name="mobile">
        <t-input v-model="formData.mobile" clearable placeholder="请输入手机号" />
      </t-form-item>
      <t-form-item label="QQ" name="qq">
        <t-input v-model="formData.qq" clearable placeholder="请输入qq" />
      </t-form-item>
      <t-form-item label="状态" name="status">
        <t-radio-group v-model="formData.status" :options="options" />
      </t-form-item>
      <t-form-item label="登录密码" name="password" help="留空则不更新">
        <t-input v-model="formData.password" clearable placeholder="请输入密码" />
      </t-form-item>
    </t-form>
  </t-dialog>
</template>

<script lang="ts">
export default {
  name: 'EditPopup',
};
</script>

<script setup lang="ts">
import { FormRule, MessagePlugin } from 'tdesign-vue-next';
import { reactive, ref } from 'vue';

import { add, detail, edit } from '@/api/admin/merchant/user';

const options = [
  { label: '启用', value: 1 },
  { label: '禁用', value: 0 },
];
const settlementTypeOption = [
  { label: 'T+0', value: 0 },
  { label: 'T+1', value: 1 },
];
const DATA = {
  id: 0,
  lowrate: '',
  settlement_type: 1,
  username: '',
  email: '',
  mobile: '',
  qq: '',
  shop_name: '',
  status: 1,
  password: '',
};
const formData = reactive({ ...DATA });

const formRef = ref();
const visible = ref(false);
const title = ref('添加');
const init = (id: number) => {
  title.value = id ? '编辑' : '添加';
  if (id) {
    getDetail(id);
  } else {
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
const onSubmit = async () => {
  const result = await formRef.value.validate();
  if (typeof result !== 'object' && result) {
    let res;
    if (formData.id === 0) {
      res = await add(formData);
    } else {
      res = await edit(formData);
    }
    if (res.code === 1) {
      MessagePlugin.success(res.msg);
      visible.value = false;
      emit('success');
    } else {
      MessagePlugin.error(res.msg);
    }
  }
};
</script>
