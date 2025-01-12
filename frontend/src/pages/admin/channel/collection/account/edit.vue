<template>
  <t-dialog v-model:visible="visible" :close-on-overlay-click="false" :destroy-on-close="true" :header="title" :on-confirm="onSubmit">
    <t-form ref="formRef" label-align="left" :data="formData" :rules="FORM_RULES" :label-width="100">
      <t-form-item label="账号备注" name="name">
        <t-input v-model="formData.name" clearable placeholder="请输入账号备注" />
      </t-form-item>
      <t-form-item label="费率设置" name="rate_type">
        <t-radio-group v-model="formData.rate_type" :options="rateTypeOptins" />
      </t-form-item>
      <t-form-item v-if="formData.rate_type == 1" label="充值费率" name="lowrate">
        <t-input v-model="formData.lowrate" clearable placeholder="请输入费率" suffix="‰" />
      </t-form-item>
      <t-form-item v-for="(item, key) in paramsOptions" :key="key" :label="item.label" :name="item.name">
        <wp-upload v-if="item.label.includes('证书')" :initial="formData.params" app="admin" :name="item.name" theme="file-input" :placeholder="`请上传${item.label}`" :data="{ type: 'certificate' }" @update="handleUpdate" />
        <t-textarea v-else v-model="formData.params[item.name]" clearable :placeholder="`请输入${item.label}`" />
      </t-form-item>
      <t-form-item label="状态" name="status">
        <t-radio-group v-model="formData.status" :options="statusOptions" />
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

import { add, detail, edit, getFields } from '@/api/admin/channel/collectionAccount';
import WpUpload from '@/components/upload/index.vue';

import { rateTypeOptins, statusOptions } from './constant';

const handleUpdate = ({ name, url }: any) => {
  // @ts-ignore
  formData.params[name] = url;
};

const DATA = {
  id: 0,
  channel_id: 0,
  name: '',
  rate_type: 0,
  lowrate: 0,
  status: 1,
  params: {} as Record<string, string>,
};

const formData = reactive({ ...DATA });

const paramsOptions = ref();

const visible = ref(false);
const title = ref();
const init = async (channelId: number, id: number) => {
  title.value = id ? '编辑收款渠道账号' : '添加收款渠道账号';
  // 加载字段配置
  formData.channel_id = channelId;
  const { data } = await getFields({
    channel_id: formData.channel_id,
  });
  paramsOptions.value = data;
  paramsOptions.value.forEach((item: any) => {
    formData.params[item.name] = '';
  });
  // 数据渲染
  getDetail(channelId, id);
  // 窗口显示
  visible.value = true;
};

const getDetail = async (channelId: number, id: number) => {
  if (id) {
    const { data } = await detail({ id });
    for (const key in formData) {
      if (data[key] != null && data[key] !== undefined) {
        // @ts-ignore
        formData[key] = data[key];
      }
    }
  } else {
    for (const key in DATA) {
      // @ts-ignore
      formData[key] = DATA[key];
      // 特殊处理
      formData.channel_id = channelId;
    }
  }
};

defineExpose({
  init,
});

const FORM_RULES: Record<string, FormRule[]> = {
  name: [{ required: true, message: '账号备注必填', type: 'error' }],
};
const emit = defineEmits(['success']);

const formRef = ref();
const onSubmit = async () => {
  const result = await formRef.value.validate();
  if (typeof result !== 'object' && result) {
    try {
      const res = formData.id > 0 ? await edit(formData) : await add(formData);

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
