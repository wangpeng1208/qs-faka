<template>
  <t-card style="padding-top: 20px" class="basic-container" :bordered="false">
    <t-form ref="formRef" label-align="left" :data="formData" :rules="FORM_RULES" :label-width="150" style="width: 500px">
      <t-form-item label="隐私政策" name="privacy_policy_id" help="">
        <t-input v-model="formData.privacy_policy_id" clearable placeholder="请输入隐私政策URL地址" />
      </t-form-item>
      <t-form-item label="注册协议" name="register_agreement_id" help="">
        <t-input v-model="formData.register_agreement_id" clearable placeholder="请输入注册协议URL地址" />
      </t-form-item>
      <t-form-item label="商品发布条例" name="goods_release_id" help="">
        <t-input v-model="formData.goods_release_id" clearable placeholder="请输入商品发布条例URL地址" />
      </t-form-item>
      <t-form-item label="禁售目录" name="prohibited_catalog_id">
        <t-input v-model="formData.prohibited_catalog_id" clearable placeholder="请输入禁售目录URL地址" />
      </t-form-item>
      <t-form-item label="侵权举报" name="infringement_report_id">
        <t-input v-model="formData.infringement_report_id" clearable placeholder="请输入侵权举报URL地址" />
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
  name: 'WebAgreement',
};
</script>

<script setup lang="ts">
import { FormRule, MessagePlugin } from 'tdesign-vue-next';
import { reactive, ref } from 'vue';

import { editConfig, getConfig } from '@/api/admin/config/config';

const formData = reactive({
  privacy_policy_id: '',
  register_agreement_id: '',
  goods_release_id: '',
  prohibited_catalog_id: '',
  infringement_report_id: '',
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
  privacy_policy_id: [{ required: true, message: '请输入隐私政策' }],
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
