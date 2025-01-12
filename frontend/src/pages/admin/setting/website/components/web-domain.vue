<template>
  <t-card style="padding-top: 20px" class="basic-container" :bordered="false">
    <t-form ref="formRef" label-align="left" :data="formData" :rules="FORM_RULES" :label-width="150" style="width: 500px">
      <t-form-item label="网站域名" name="site_domain" tips="">
        <t-input v-model="formData.site_domain" clearable placeholder="请输入网站域名" tips="用于资源链接和支付回调的地址生成补全" />
      </t-form-item>
      <t-form-item label="链接域名" name="site_shop_domain" tips="短链接将会通过此处填写的域名生成对应的短链接。">
        <t-input v-model="formData.site_shop_domain" clearable placeholder="请输入链接域名" />
      </t-form-item>
      <t-form-item label="短网址功能" name="site_domain_short">
        <t-select
          v-model="formData.site_domain_short"
          :options="[
            // { label: '自己短网址', value: 'Mysite' },
            { label: '缩我短网址', value: 'Suo' },
            { label: '缩链短网址', value: 'Suolink' },
          ]"
          clearable
          placeholder="请选择短网址功能"
        />
      </t-form-item>
      <t-form-item v-if="formData.site_domain_short == 'Site'" label="短网址域名" name="sina_app_key">
        <t-input v-model="formData.site_shortlink_domain" clearable placeholder="请输入短网址域名" />
      </t-form-item>
      <t-form-item v-if="formData.site_domain_short == 'Suo'" label="缩我短网址配置（KEY）" name="suo_app_key">
        <t-input v-model="formData.suo_app_key" clearable placeholder="请输入缩我key" />
        <template #tips> 缩我短网址申请网址：<t-link href="https://suowo.cn/" target="_blank">https://suowo.cn/ </t-link> </template>
      </t-form-item>

      <t-form-item v-if="formData.site_domain_short == 'Suolink'" label="缩链短网址配置（KEY）" name="suolink_app_key">
        <t-input v-model="formData.suolink_app_key" clearable placeholder="请输入缩我key" />
        <template #tips> 缩链短网址申请网址：<t-link href="https://suolink.cn/" target="_blank">https://suolink.cn/ </t-link> </template>
      </t-form-item>
      <!-- suolink_app_domain -->
      <t-form-item v-if="formData.site_domain_short == 'Suolink'" label="缩链短网址配置（域名）" name="suolink_app_domain">
        <t-input v-model="formData.suolink_app_domain" clearable placeholder="请输入缩链短网址域名" />
        <template #tips> 用于缩链短网址的独立域名 </template>
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
  site_domain_short: '',
  suo_app_key: '',
  site_shortlink_domain: '',
  suolink_app_key: '',
  suolink_app_domain: '',
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
</script>
