<template>
  <t-dialog v-model:visible="visible" :close-on-overlay-click="false" :destroy-on-close="true" :header="title" :on-confirm="onSubmit">
    <t-form ref="formRef" label-align="left" :data="formData" :rules="FORM_RULES" :label-width="80">
      <t-form-item label="名称" name="name">
        <t-input v-model="formData.name" clearable placeholder="请输入名称" />
      </t-form-item>
      <t-form-item label="logo大图" name="logo">
        <wp-upload theme="image" :initial="formData" name="logo" app="admin" :data="{ type: 'image' }" @update="handleUpdateImage" />
      </t-form-item>
      <t-form-item label="图标" name="ico">
        <wp-upload theme="image" :initial="formData" name="ico" app="admin" :data="{ type: 'image' }" @update="handleUpdateImage" />
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

import { add, detail, edit } from '@/api/admin/channel/pay_type';
import WpUpload from '@/components/upload/index.vue';

const DATA = {
  id: 0,
  name: '',
  logo: '',
  ico: '',
};
const formData = reactive({ ...DATA });

const handleUpdateImage = ({ name, url }: any) => {
  // @ts-ignore
  formData[name] = url;
};

const visible = ref(false);
const title = ref('添加支付方式');
const init = (id: number) => {
  if (id) {
    title.value = '编辑支付方式';
    getDetail(id);
  } else {
    title.value = '添加支付方式';
    for (const key in DATA) {
      // @ts-ignore
      formData[key] = DATA[key];
    }
  }
  visible.value = true;
};

const getDetail = async (id: number) => {
  const { data } = await detail({ id });
  for (const key in formData) {
    if (data[key] != null && data[key] !== undefined) {
      // @ts-ignore
      formData[key] = data[key];
    }
  }
};

defineExpose({
  init,
});


const FORM_RULES: Record<string, FormRule[]> = {
  name: [{ required: true, message: '名称必填', type: 'error' }],
  ico: [{ required: true, message: '图标必须上传', type: 'error' }],
};

const emit = defineEmits(['success']);
const formRef = ref();
const onSubmit = async () => {
  const result = await formRef.value.validate();
  if (typeof result !== 'object' && result) {
    let res;
    if (formData.id === 0) {
      res = await add(formData);
    } else {
      res = await edit(formData);
    }
    if (res.code === 1) {
      MessagePlugin.success(res.msg);
      visible.value = false;
      emit('success');
    } else {
      MessagePlugin.error(res.msg);
    }
  }
};
</script>

<style scoped></style>
