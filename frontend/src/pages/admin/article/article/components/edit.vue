<template>
  <t-dialog v-model:visible="visible" :close-on-overlay-click="false" :destroy-on-close="true" :header="title" :on-confirm="onSubmit" width="900px">
    <t-form ref="formRef" label-align="left" :data="formData" :rules="FORM_RULES" :label-width="80">
      <t-form-item label="文章栏目" name="cate_id">
        <t-select v-model:value="formData.cate_id" placeholder="请选择文章栏目" :options="categoryListOptions" clearable filterable />
      </t-form-item>
      <t-form-item label="文章标题" name="title">
        <t-input v-model="formData.title" clearable placeholder="请输入文章标题" />
      </t-form-item>
      <t-form-item label="添加时间" name="create_at">
        <t-date-picker v-model="formData.create_at" enable-time-picker allow-input clearable style="width: 500px" @change="handleChange" />
      </t-form-item>
      <t-form-item label="文章内容" name="content">
        <wp-editor v-model:model-value="formData.content" user-type="admin" height="300px" width="100%" mode="simple" />
      </t-form-item>
      <t-form-item label="状态" name="status">
        <t-radio-group v-model="formData.status" :options="statusOptions" />
      </t-form-item>
      <t-form-item label="置顶" name="top">
        <t-radio-group v-model="formData.top" :options="topOptions" />
      </t-form-item>
      <t-form-item label="系统调用" name="is_system">
        <t-radio-group v-model="formData.is_system" :options="topOptions" />
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
import { Dayjs } from 'dayjs';
import { DatePickerTriggerSource, DateValue, FormRule, MessagePlugin } from 'tdesign-vue-next';
import { ref } from 'vue';

import { add, edit } from '@/api/admin/article/article';
import { listSimple } from '@/api/admin/article/category';

import { statusOptions, topOptions } from './constant';

const categoryListOptions = ref([]);
const initMenuOptions = async () => {
  const { data } = await listSimple();
  categoryListOptions.value = data;
};
initMenuOptions();
const DATA = {
  id: 0,
  cate_id: null as number | null,
  title: '',
  content: '' as string,
  status: 1,
  top: 0,
  create_at: Date.now(),
  is_system: 0,
};
const formData = ref({ ...DATA });
const handleChange = (
  value: DateValue,
  context: {
    dayjsValue?: Dayjs;
    trigger?: DatePickerTriggerSource;
  },
) => {
  formData.value.create_at = context.dayjsValue?.valueOf() || 0;
};
const visible = ref(false);
const title = ref('添加文章');
const init = (row: any) => {
  // 创建 row 的深拷贝
  const rowCopy = JSON.parse(JSON.stringify(row));
  if (rowCopy?.id > 0) {
    title.value = '编辑文章';
    rowCopy.create_at *= 1000;
    formData.value = { ...rowCopy };
  } else {
    title.value = '添加文章';
    formData.value = { ...DATA };
    formData.value.create_at = Date.now();
  }
  visible.value = true;
};

defineExpose({
  init,
});

const FORM_RULES: Record<string, FormRule[]> = {
  cate_id: [{ required: true, message: '必填', type: 'error' }],
  content: [{ required: true, message: '必填', type: 'error' }],
  title: [{ required: true, message: '必填', type: 'error' }],
};
const emit = defineEmits(['success']);
const formRef = ref();
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
