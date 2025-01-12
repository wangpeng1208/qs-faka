<template>
  <t-dialog v-model:visible="visible" :close-on-overlay-click="false" :destroy-on-close="true" :header="title" :on-confirm="onSubmit">
    <t-form ref="formRef" label-align="left" :data="formData" :rules="FORM_RULES" :label-width="80">
      <!-- <t-form-item label="角色" name="role">
        <t-tree-select v-model="formData.role" placeholder="请选择上级管理员" :data="roleOptions" multiple clearable filterable check-strictly :min-collapsed-num="2" />
      </t-form-item> -->
      <t-form-item label="用户名" name="username">
        <t-input v-model="formData.username" clearable placeholder="请输入管理员用户名" />
      </t-form-item>
      <t-form-item label="昵称" name="nickname">
        <t-input v-model="formData.nickname" clearable placeholder="请输入昵称" />
      </t-form-item>
      <t-form-item label="密码" name="password">
        <t-input v-model="formData.password" clearable placeholder="留空则不更改" />
      </t-form-item>
      <t-form-item label="头像" name="avatar">
        <wp-upload theme="image" app="admin" :initial="formData" name="avatar" :data="{ type: 'image' }" @update="handleUpdateImage" />
      </t-form-item>
      <t-form-item label="邮箱" name="email">
        <t-input v-model="formData.email" clearable placeholder="请输入邮箱" />
      </t-form-item>
      <t-form-item label="手机" name="mobile">
        <t-input-number v-model="formData.mobile" clearable placeholder="请输入手机" :style="{ width: '500px' }" theme="column" :min="0" />
      </t-form-item>
    </t-form>
  </t-dialog>
</template>

<script lang="ts">
export default {
  name: 'AdminEditPopup',
};
</script>

<script setup lang="ts">
import { FormRule, MessagePlugin } from 'tdesign-vue-next';
import { reactive, ref } from 'vue';

import { detail, edit } from '@/api/admin/permission/admin';
import { listSimpleTree } from '@/api/admin/permission/role';
import WpUpload from '@/components/upload/index.vue';

const DATA = {
  // role: '',
  username: '',
  nickname: '',
  password: '',
  avatar: '',
  email: '',
  mobile: '',
  id: '',
};

const formData = reactive({ ...DATA });

const handleUpdateImage = ({ name, url }: any) => {
  // @ts-ignore
  formData[name] = url;
};

const roleOptions = ref([]);

const initRoleOptions = async () => {
  const { data } = await listSimpleTree();
  roleOptions.value = data.list;
};
const visible = ref(false);
const title = ref('添加管理员');
const init = (id: number) => {
  if (id) {
    title.value = '编辑管理员';
    getDetail(id);
  } else {
    title.value = '添加管理员';
    for (const key in DATA) {
      // @ts-ignore
      formData[key] = DATA[key];
    }
  }

  initRoleOptions();
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

const formRef = ref(null);


const FORM_RULES: Record<string, FormRule[]> = {
  role: [{ required: true, message: '必填', type: 'error' }],
  username: [{ required: true, message: '必填', type: 'error' }],
};
const emit = defineEmits(['success']);
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
