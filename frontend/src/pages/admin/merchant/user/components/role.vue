<template>
  <t-dialog v-model:visible="visible" :close-on-overlay-click="false" :destroy-on-close="true" :header="title" :on-confirm="onSubmit">
    <t-form ref="formRef" label-align="left" :data="formData" :rules="FORM_RULES" :label-width="80">
      <t-form-item label="选择角色" name="role_id">
        <t-select v-model="formData.role_id" :options="roleTypeOption" />
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

import { listsimple } from '@/api/admin/merchant/role';
import { role, setRole } from '@/api/admin/merchant/user';

const DATA = {
  user_id: 0,
  role_id: '',
};
const formData = reactive({ ...DATA });

const roleTypeOption = ref([]);
const formRef = ref();
const visible = ref(false);
const title = ref('分配商户角色');
const init = (id: number) => {
  getDetail(id);
  initRoleTypeOption();
  visible.value = true;
};
const initRoleTypeOption = async () => {
  const { data } = await listsimple();
  roleTypeOption.value = data;
};

const getDetail = async (id: number) => {
  const { data } = await role({ id });
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
  name: [{ required: true, message: '必填', type: 'error' }],
  title: [{ required: true, message: '必填', type: 'error' }],
};
const emit = defineEmits(['success']);
const onSubmit = async () => {
  const result = await formRef.value.validate();
  if (typeof result !== 'object' && result) {
    try {
      const res = await setRole(formData);
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
