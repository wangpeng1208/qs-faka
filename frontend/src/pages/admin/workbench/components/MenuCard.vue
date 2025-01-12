<template>
  <t-card title="用户快捷菜单" hover-shadow>
    <template #actions>
      <t-link hover="color" @click="action">{{ actionTxt }}</t-link>
    </template>

    <t-space align="center" break-line>
      <t-button v-for="(item, index) in userMenu" :key="index" @click="goPage(item.name)">
        <template v-if="item.icon" #icon><t-icon :name="item.icon" /></template>
        {{ item.title }}
        <template v-if="showRemoveIcon" #suffix>
          <delete-icon @click="remove(item.id)" />
        </template>
      </t-button>
      <!-- 添加菜单 -->
      <t-button variant="dashed" @click="add">
        <template #icon><add-icon /></template>
        添加
      </t-button>
    </t-space>
    <add-menu ref="addMenuRef" @refresh="refresh" />
  </t-card>
</template>
<script setup lang="ts">
import { AddIcon, DeleteIcon } from 'tdesign-icons-vue-next';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

import { deleteAdminUserShortcutMenu, getAdminUserShortcutMenu } from '@/api/admin/user';

import AddMenu from './AddMenu.vue';

// 用户自定义快捷菜单
const userMenu = ref([]);

const getUserShortcutMenu = async () => {
  const res = await getAdminUserShortcutMenu();
  if (res.code) {
    userMenu.value = res.data;
  }
};
getUserShortcutMenu();

const refresh = () => {
  getUserShortcutMenu();
  showRemoveIcon.value = false;
};

const router = useRouter();
const goPage = (name: string) => {
  if (showRemoveIcon.value) return;
  router.push({
    name,
  });
};
const addMenuRef = ref();
const add = () => {
  addMenuRef.value.init();
};
const showRemoveIcon = ref(false);
const actionTxt = ref('操作');
const action = () => {
  actionTxt.value = showRemoveIcon.value ? '操作' : '完成';
  showRemoveIcon.value = !showRemoveIcon.value;
};
const remove = async (id: number) => {
  const res = await deleteAdminUserShortcutMenu({
    menu_id: id,
  });
  if (res.code) {
    getUserShortcutMenu();
  }
};
</script>
