<template>
  <t-card title="注册设置" class="basic-container" :bordered="false">
    <t-form ref="formRef" label-align="left" :data="formData" :rules="FORM_RULES" :label-width="180">
      <t-form-item label="开启会员注册" name="site_register_status" tips="">
        <!-- radio -->
        <t-radio-group v-model="formData.site_register_status" :options="options" />
      </t-form-item>
      <t-form-item label="审核机制" name="site_register_check" tips="开启注册审核：自动审核-注册账号后可以直接登录">
        <t-radio-group
          v-model="formData.site_register_verify"
          :options="[
            { label: '自动审核', value: 1 },
            { label: '手动审核', value: 2 },
          ]"
        />
      </t-form-item>
      <t-form-item label="次数限制" name="ip_register_limit" tips="一天内同个IP地址限制注册次数, 0表示不限制">
        <t-input-number v-model="formData.ip_register_limit" theme="normal" min="0" clearable placeholder="请输入一天内同个IP地址限制注册次数" suffix="次" />
      </t-form-item>
      <t-form-item label="用户名称必填" name="site_register_need_username" tips="勾选否，则手机号或者邮箱必须勾选一个(将作为用户名)，否则注册无法进行">
        <t-radio-group v-model="formData.site_register_need_username" :options="options" />
      </t-form-item>

      <t-divider>手机号</t-divider>
      <t-form-item label="手机号码必填" name="site_register_need_mobile" tips="">
        <t-radio-group v-model="formData.site_register_need_mobile" :options="options" />
      </t-form-item>
      <t-form-item v-if="formData.site_register_need_mobile" label="验证手机号码" name="site_register_need_mobile_check" tips="是否验证 手机短信验证码">
        <t-radio-group v-model="formData.site_register_need_mobile_check" :options="options" />
      </t-form-item>
      <!-- 注册短信 发送频率限制 -->
      <t-form-item label="短信发送频率" name="site_register_smscode_max_time" tips="注册短信 发送频率限制, 0表示不限制;单位是秒，建议设置为60秒">
        <t-input-number v-model="formData.site_register_smscode_max_time" theme="normal" min="0" clearable placeholder="请输入注册短信 发送频率限制" suffix="秒" />
      </t-form-item>
      <!-- 短信验证码输错次数限制 -->
      <t-form-item label="输错次数限制" name="sms_error_limit" tips="短信验证码输错次数限制, 0表示不限制">
        <t-input-number v-model="formData.sms_error_limit" theme="normal" min="0" clearable placeholder="请输入短信验证码输错次数限制" suffix="次" />
      </t-form-item>
      <!-- 短信验证码输错次数超限禁用时间（分钟） -->
      <t-form-item label="输错次数超限禁用时间" name="sms_error_time" tips="短信验证码输错次数超限禁用时间（分钟）, 0表示不限制">
        <t-input-number v-model="formData.sms_error_time" theme="normal" min="0" clearable placeholder="请输入短信验证码输错次数超限禁用时间（分钟）" suffix="分钟" />
      </t-form-item>

      <t-divider>邮箱</t-divider>
      <t-form-item label="邮箱地址必填" name="site_register_need_email" tips="">
        <t-radio-group v-model="formData.site_register_need_email" :options="options" />
      </t-form-item>
      <t-form-item label="开启邮件验证" name="site_register_need_email_check" tips="是否验证 邮箱">
        <t-radio-group v-model="formData.site_register_need_email_check" :options="options" />
      </t-form-item>
      <t-form-item label="验证码超时时间" name="site_register_smscode_expire_time" tips="验证码超时时间, 0表示不限制">
        <t-input-number v-model="formData.site_register_smscode_expire_time" theme="normal" min="0" clearable placeholder="请输入验证码超时时间" suffix="秒" />
      </t-form-item>

      <t-form-item>
        <t-space size="small">
          <t-button theme="primary" @click="submit">提交</t-button>
          <t-button theme="default" variant="base" type="reset">重置</t-button>
        </t-space>
      </t-form-item>
    </t-form>
  </t-card>
</template>

<script setup lang="ts">
import { FormRule, MessagePlugin } from 'tdesign-vue-next';
import { reactive, ref } from 'vue';

import { editConfig, getConfig } from '@/api/admin/config/config';

const formData = reactive({
  site_register_status: 0,
  site_register_need_username: 0,
  site_register_need_mobile: 0,
  site_register_need_mobile_check: 0,
  site_register_need_email: 0,
  site_register_need_email_check: 0,
  site_register_smscode_max_count: 0,
  site_register_smscode_max_time: 0,
  sms_error_limit: 0,
  sms_error_time: 0,
  site_register_smscode_expire_time: 0,
  ip_register_limit: 0,
  site_register_verify: 1,
});

// 获取邮箱配置

const fetchConfig = async () => {
  const { data } = await getConfig({
    field: Object.keys(formData),
  });
  for (const key in data) {
    // @ts-ignore
    formData[key] = data[key];
  }
};
fetchConfig();

const FORM_RULES: Record<string, FormRule[]> = {
  site_domain: [{ required: true, message: '请输入主站域名' }],
};
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
// 开启 关闭 options
const options = [
  { label: '开启', value: 1 },
  { label: '关闭', value: 0 },
];
</script>
