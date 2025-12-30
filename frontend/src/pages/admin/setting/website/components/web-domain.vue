<template>
  <t-card style="padding-top: 20px" class="basic-container" :bordered="false">
    <t-form ref="formRef" label-align="left" :data="formData" :rules="FORM_RULES" :label-width="150">
      <t-form-item label="网站域名" name="site_domain" tips="用于资源链接和支付回调的地址生成补全">
        <t-input v-model="formData.site_domain" clearable placeholder="请输入网站域名" />
      </t-form-item>
      <t-form-item label="链接域名" name="site_shop_domain" tips="短链接将会通过此处填写的域名生成对应的短链接。">
        <t-input v-model="formData.site_shop_domain" clearable placeholder="请输入链接域名" />
      </t-form-item>
      <t-form-item label="万能短网址配置" name="site_shortlink_other_option">
        <t-textarea
          v-model="formData.site_shortlink_other_option"
          clearable
          placeholder="请输入短网址配置"
          :autosize="{
            minRows: 5,
            maxRows: 10,
          }"
        />
        <template #tips> (Json格式)。留空则表示不启用。测试用例：{ "api": "http://api.3wt.cn/api.htm", "from": "url", "method": "get", "params": { "format": "json", "key": "6209ae6d41fb7cd01413eb4d45@ebe9e520aa886c17517c5aad213d730e", "domain": "21" } }</template>
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
<script lang="ts">
export default {
  name: 'WebDomain',
};
</script>
<script setup lang="ts">
import { FormRule, MessagePlugin } from 'tdesign-vue-next';
import { reactive, ref } from 'vue';

import { editConfig, getConfig } from '@/api/admin/config/config';

const formData = reactive({
  site_domain: '',
  site_shop_domain: '',
  site_shortlink_other_option: '',
});

// 获取配置
const fetchConfig = async () => {
  const res = await getConfig({
    field: Object.keys(formData),
  });
  if (res.code === 1) {
    for (const key in res.data) {
      let value = res.data[key];
      // 对象配置在表单中需要以字符串展示
      if (key === 'site_shortlink_other_option' && value && typeof value === 'object') {
        try {
          value = JSON.stringify(value, null, 2);
        } catch {
          // ignore stringify error, fallback to toString
          value = String(value);
        }
      }
      // @ts-expect-error - 11
      formData[key] = value;
    }
    return;
  }
  MessagePlugin.error(res.msg);
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
      MessagePlugin.success(res.msg);
    } else {
      MessagePlugin.error(res.msg);
    }
  }
};
</script>
