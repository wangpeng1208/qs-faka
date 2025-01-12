<template>
  <t-dialog v-model:visible="visible" :destroy-on-close="true" :header="title" :on-confirm="onSubmit">
    <t-form ref="formRef" label-align="left" :data="formData" :rules="FORM_RULES" :label-width="60">
      <t-form-item label="名称" name="name">
        <t-input v-model="formData.name" clearable placeholder="请输入分类名" />
      </t-form-item>
      <t-form-item label="别名" name="alias" tips="英文别名，方便前台调用">
        <t-input v-model="formData.alias" clearable />
      </t-form-item>
      <t-form-item label="状态" name="status">
        <t-radio-group v-model="formData.status" :options="statusOptions" />
      </t-form-item>
      <t-form-item label="类型" name="type">
        <t-radio-group v-model="formData.type" :options="typeOptions" />
      </t-form-item>
      <t-form-item label="备注" name="remark" tips="简短的文字备注，方便自己记忆">
        <t-input v-model="formData.remark" clearable />
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
import { ref } from 'vue';

import { add, edit } from '@/api/admin/article/category';

import { statusOptions, typeOptions } from './constant';

const DATA = {
  id: 0,
  name: '',
  alias: '',
  remark: '',
  status: 1,
  top: 0,
  type: 1,
  create_at: Date.now(),
};
const formData = ref({ ...DATA });

const formRef = ref();
const visible = ref(false);
const title = ref('');
const init = (row: any) => {
  title.value = row?.id > 0 ? '编辑分类' : '添加分类';
  formData.value = row?.id > 0 ? { ...row } : { ...DATA };

  visible.value = true;
};

defineExpose({
  init,
});


const FORM_RULES: Record<string, FormRule[]> = {
  name: [{ required: true, message: '必填', type: 'error' }],
  alias: [{ required: true, message: '必填', type: 'error' }],
};
const emit = defineEmits(['success']);
const onSubmit = async () => {
  const result = await formRef.value.validate();
  if (typeof result !== 'object' && result) {
    const res = formData.value.id === 0 ? await add(formData.value) : await edit(formData.value);

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
