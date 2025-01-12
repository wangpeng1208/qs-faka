<template>
  <t-dialog v-model:visible="visible" :close-on-overlay-click="false" :destroy-on-close="true" :header="title" :on-confirm="onSubmit">
    <t-form ref="formRef" label-align="left" :data="formData" :rules="FORM_RULES" :label-width="80">
      <t-form-item label="账号备注" name="name">
        <t-input v-model="formData.name" clearable placeholder="请输入账号备注" />
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
  name: 'AdminChannelCollectionAcctionEditPopup',
};
</script>

<script setup lang="ts">
import { FormRule, MessagePlugin } from 'tdesign-vue-next';
import { reactive, ref } from 'vue';

import { detail, edit, getFields } from '@/api/admin/channel/collectionAccount';

const handleUpdate = ({ name, url }: any) => {
  // @ts-ignore
  formData.params[name] = url;
};
const statusOptions = [
  { label: '启用', value: 1 },
  { label: '禁用', value: 0 },
];

const DATA = {
  id: 0,
  channel_id: 0,
  name: '',
  status: 1,
  params: {} as Record<string, string>,
};

const formData = reactive({ ...DATA });

const paramsOptions = ref();

const visible = ref(false);
const title = ref();
const init = async (channelId: number, id: number) => {
  title.value = id ? '编辑结算渠道账号' : '添加结算渠道账号';
  // 加载字段配置
  formData.channel_id = channelId;
  const { data } = await getFields({
    channel_id: formData.channel_id,
  });
  paramsOptions.value = data;
  // 向formData.params 里推 paramsOptions数组里的name，值默认为空
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
      const res = await edit(formData);
      if (res.code === 1) {
        MessagePlugin.success('操作成功');
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
