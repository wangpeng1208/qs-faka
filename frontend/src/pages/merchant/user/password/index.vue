<template>
  <t-card title="重置密码" :bordered="false">
    <t-form ref="form" :data="formData" :rules="FORM_RULES" label-align="left" :label-width="160" @submit="onSubmit">
      <t-form-item label="输入旧密码" name="password">
        <t-input v-model="formData.password" placeholder="请输入旧密码" />
      </t-form-item>
      <t-form-item label="输入新密码" name="new_password">
        <t-input v-model="formData.new_password" placeholder="输入新密码,9个字符以上" />
      </t-form-item>
      <t-form-item label="确认新密码" name="new_password">
        <t-input v-model="formData.new_password2" placeholder="请输入确认新密码" />
      </t-form-item>
      <t-form-item>
        <t-button theme="primary" class="form-submit-confirm" type="submit"> 保存 </t-button>
      </t-form-item>
    </t-form>
  </t-card>
</template>
<script lang="ts">
export default {
  name: 'UserPassword',
};
</script>
<script setup lang="ts">
import { FormRule, MessagePlugin } from 'tdesign-vue-next';
import { reactive, ref } from 'vue';

import { resetPassword } from '@/api/merchant/user/user';

const form = ref(null);
const formData = reactive({
  password: '',
  new_password: '',
  new_password2: '',
});

const FORM_RULES: Record<string, FormRule[]> = {
  password: [{ required: true, message: '请输入旧密码', type: 'error' }],
  new_password: [{ required: true, message: '请输入新密码', type: 'error' }],
  new_password2: [{ required: true, message: '请重复输入新密码', type: 'error' }],
};
const onSubmit = async () => {
  const result = await form.value.validate();
  if (typeof result !== 'object' && result) {
    if (formData.new_password !== formData.new_password2) {
      MessagePlugin.error('两次输入的密码不一致');
      return;
    }
    const res = await resetPassword(formData);
    if (res.code === 1) {
      MessagePlugin.success(res.msg);
      // form.value.resetFields();
    } else {
      MessagePlugin.error(res.msg);
    }
  }
};
</script>
