<template>
  <t-card title="邮箱配置" class="basic-container" :bordered="false">
    <t-form ref="formRef" label-align="left" :data="formData" :rules="FORM_RULES" :label-width="150">
      <t-form-item label="发件人" name="email_name">
        <t-input v-model="formData.email_name" clearable placeholder="请输入发件人" />
      </t-form-item>
      <t-form-item label="SMTP服务器" name="email_smtp">
        <t-input v-model="formData.email_smtp" clearable placeholder="请输入SMTP服务器" />
      </t-form-item>
      <t-form-item label="SMTP端口" name="email_port">
        <t-input v-model="formData.email_port" clearable placeholder="请输入邮箱SMTP服务器端口" />
      </t-form-item>
      <t-form-item label="邮箱账号" name="email_user">
        <t-input v-model="formData.email_user" clearable placeholder="请输入邮箱账号" />
      </t-form-item>
      <t-form-item label="邮箱密码" name="email_pass">
        <t-input v-model="formData.email_pass" clearable placeholder="请输入邮箱密码" type="password" />
      </t-form-item>
      <t-form-item v-if="showTestAddress" label="测试邮箱" name="address">
        <t-input v-model="address" clearable placeholder="请输入测试邮箱" />
      </t-form-item>
      <t-form-item>
        <t-space size="small">
          <t-button theme="primary" @click="submit">提交</t-button>
          <t-button theme="primary" @click="handleSend">发信测试</t-button>
          <t-button theme="default" variant="base" type="reset">重置</t-button>
        </t-space>
      </t-form-item>
    </t-form>
  </t-card>
</template>

<script lang="ts">
export default {
  name: 'WebEmail',
};
</script>

<script setup lang="ts">
import { FormRule, MessagePlugin } from 'tdesign-vue-next';
import { reactive, ref } from 'vue';

import { editConfig, emailTest, getConfig } from '@/api/admin/config/config';

const formData = reactive({
  email_name: '',
  email_smtp: '',
  email_port: '',
  email_user: '',
  email_pass: '',
});

// 获取邮箱配置

const fetchEmailConfig = async () => {
  const { data } = await getConfig({
    field: Object.keys(formData),
  });
  for (const key in data) {
    // @ts-ignore
    formData[key] = data[key];
  }
};
fetchEmailConfig();

const formRef = ref();
const submit = async () => {
  const result = await formRef.value.validate();
  if (typeof result !== 'object' && result) {
    const res = await editConfig({
      data: formData,
    });
    if (res.code === 1) {
      MessagePlugin.success('操作成功');
    } else {
      MessagePlugin.error(res.msg);
    }
  }
};
const FORM_RULES: Record<string, FormRule[]> = {
  email_name: [{ required: true, message: '请输入发件人' }],
  email_smtp: [{ required: true, message: '请输入SMTP服务器' }],
  email_port: [{ required: true, message: '请输入邮箱SMTP服务器端口' }],
  email_user: [{ required: true, message: '请输入邮箱账号' }],
  email_pass: [{ required: true, message: '请输入邮箱密码' }],
};

const address = ref('');
const showTestAddress = ref(false);
const handleSend = async () => {
  showTestAddress.value = true;
  // 发信测试 打开弹出框 发送邮件
  if (!address.value) {
    MessagePlugin.error('请输入测试邮箱');
    return;
  }
  const { msg } = await emailTest({
    address: address.value,
  });
  MessagePlugin.success(msg);
};
</script>
