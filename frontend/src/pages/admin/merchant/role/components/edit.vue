<template>
  <t-dialog v-model:visible="visible" :close-on-overlay-click="false" :destroy-on-close="true" :header="title" :on-confirm="onSubmit">
    <t-form ref="formRef" label-align="left" :data="formData" :rules="FORM_RULES" :label-width="80">
      <t-form-item label="角色名" name="name">
        <t-input v-model="formData.name" clearable placeholder="请输入角色名" />
      </t-form-item>
      <t-form-item label="备注" name="remark">
        <t-input v-model="formData.remark" clearable placeholder="请输入备注" />
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

import { add, detail, edit } from '@/api/admin/merchant/role';

const DATA = {
  name: '',
  remark: '',
  id: 0,
};
const formData = reactive({ ...DATA });
const visible = ref(false);
const title = ref();
const init = (id: number) => {
  title.value = id ? '编辑角色' : '添加角色';
  if (id) {
    getDetail(id);
  } else {
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
      if (key === 'role') {
        // todo 多选，避免子选择完后 父级被动选择，或者父级选择后，子级被动选择。实现部门管理的效果
        // @ts-ignore
        formData[key] = data[key].map((item: any) => item.id);
      } else {
        // @ts-ignore
        formData[key] = data[key];
      }
    }
  }
};

defineExpose({
  init,
});

const formRef = ref();

const FORM_RULES: Record<string, FormRule[]> = {
  name: [{ required: true, message: '必填', type: 'error' }],
};
const emit = defineEmits(['success']);
const onSubmit = async () => {
  const result = await formRef.value.validate();
  if (typeof result !== 'object' && result) {
    try {
      const res = formData.id > 0 ? await edit(formData) : await add(formData);
      if (res.code !== 1) {
        MessagePlugin.error(res.msg);
        return;
      }
      MessagePlugin.success('操作成功');
      visible.value = false;
      emit('success');
    } catch (e) {
      MessagePlugin.error(e.msg);
    }
  }
};
</script>
