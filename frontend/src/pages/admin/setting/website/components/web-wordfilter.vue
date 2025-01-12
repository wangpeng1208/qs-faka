<template>
  <t-card style="padding-top: 20px" class="basic-container" :bordered="false">
    <t-form ref="formRef" label-align="left" :data="formData" :rules="FORM_RULES" :label-width="150" style="width: 800px">
      <t-form-item label="状态开关" name="site_wordfilter_status" tips="">
        <t-radio-group
          v-model="formData.site_wordfilter_status"
          :options="[
            { label: '启用', value: 1 },
            { label: '关闭', value: 0 },
          ]"
        />
      </t-form-item>
      <t-form-item label="敏感词" name="site_wordfilter_danger">
        <t-textarea
          v-model="formData.site_wordfilter_danger"
          clearable
          placeholder="请输入要禁用的敏感词"
          tips="使用“|”分隔"
          :autosize="{
            minRows: 5,
            maxRows: 10,
          }"
        />
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
  site_wordfilter_status: '',
  site_wordfilter_danger: '',
});

// 获取

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

const FORM_RULES: Record<string, FormRule[]> = {};
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
