<template>
  <t-dialog v-model:visible="visible" :close-on-overlay-click="false" :destroy-on-close="true" :header="title" :footer="false">
    <t-space align="center" break-line>
      <t-tag v-for="(item, index) in allMenu" :key="index" :theme="userMenu.some((userItem) => userItem.id === item.id) ? 'default' : 'primary'" @click="add(item.id)"> {{ item.title }} </t-tag>
    </t-space>
  </t-dialog>
</template>
<script setup lang="ts">
// import { MessagePlugin } from 'tdesign-vue-next';
import { ref } from 'vue';

import { addAdminUserShortcutMenu, getAdminAllMenu, getAdminUserShortcutMenu } from '@/api/admin/user';

// 所有菜单
const allMenu = ref([]);
const getAllMenu = async () => {
  const res = await getAdminAllMenu();
  if (res.code) {
    allMenu.value = res.data;
  }
};
getAllMenu();

const userMenu = ref([]);
const getUserShortcutMenu = async () => {
  const res = await getAdminUserShortcutMenu();
  if (res.code && res.data !== undefined) {
    userMenu.value = res.data;
  }
};
getUserShortcutMenu();
const visible = ref(false);
const title = ref('添加菜单');
const emit = defineEmits(['refresh']);
const add = async (id: number) => {
  if (userMenu.value.length > 0) {
    if (userMenu.value.some((item) => item.menu_id === id)) {
      return;
    }
  }
  const res = await addAdminUserShortcutMenu({
    menu_id: id,
  });
  if (res.code) {
    // MessagePlugin.success('添加成功');
    // 刷新用户自定义快捷菜单
    getUserShortcutMenu();
    // 通知父组件刷新
    emit('refresh');
  }
};
const init = () => {
  visible.value = true;
};

defineExpose({
  init,
});
</script>
