<template>
  <t-drawer v-model:visible="visible" size="100%" :close-on-overlay-click="false" :destroy-on-close="true" header="发送消息" :on-confirm="onSubmit">
    <t-alert theme="info">系统消息仅可纯文本，标题请尽量简短</t-alert>
    <t-divider></t-divider>
    <t-form ref="formRef" label-align="left" :data="formData" :rules="FORM_RULES" :label-width="80">
      <t-form-item label="消息类型" name="type">
        <t-radio-group v-model="formData.type" :options="options" />
      </t-form-item>
      <t-form-item label="标题" name="title">
        <t-input v-model="formData.title" clearable placeholder="请输入标题" />
      </t-form-item>
      <t-form-item label="内容" name="content">
        <wp-editor v-model="formData.content" height="500px" width="100%" mode="simple" user-type="admin" />
      </t-form-item>
    </t-form>
  </t-drawer>
</template>

<script lang="ts">
export default {
  name: 'MessagePopup',
};
</script>

<script setup lang="ts">
import { FormRule, MessagePlugin } from 'tdesign-vue-next';
import { reactive, ref } from 'vue';

import { message } from '@/api/admin/merchant/user';

const options = [
  { label: '系统消息', value: 'site' },
  { label: '电子邮件', value: 'email' },
];

const DATA = {
  user_id: 0,
  type: 'site',
  title: '',
  content: '',
};
const formData = reactive({ ...DATA });

const visible = ref(false);
const init = (id: number) => {
  formData.user_id = id;
  visible.value = true;
};

defineExpose({
  init,
});


const FORM_RULES: Record<string, FormRule[]> = {
  type: [{ required: true, message: '必填', type: 'error' }],
  content: [{ required: true, message: '必填', type: 'error' }],
  title: [{ required: true, message: '必填', type: 'error' }],
};
const formRef = ref<any>(null);
const onSubmit = async () => {
  const result = await formRef.value.validate();
  if (typeof result !== 'object' && result) {
    try {
      const res = await message(formData);
      if (res.code === 1) {
        MessagePlugin.success('发送成功');
        visible.value = false;
      } else {
        MessagePlugin.error(res.msg);
      }
    } catch (e) {
      MessagePlugin.error(e.msg);
    }
  }
};
</script>

<style scoped>
:deep(.t-form__controls-content) {
  display: block;
}
</style>
