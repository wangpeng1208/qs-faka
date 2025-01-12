<template>
  <merchant-header v-if="settingStore.showHeader && app === 'merchant'" :show-logo="settingStore.showHeaderLogo" :theme="settingStore.displayMode" :layout="settingStore.layout" :is-fixed="settingStore.isHeaderFixed" :menu="headerMenu" :is-compact="settingStore.isSidebarCompact" />
  <admin-header v-if="settingStore.showHeader && app === 'admin'" :show-logo="settingStore.showHeaderLogo" :layout="settingStore.layout" :is-fixed="settingStore.isHeaderFixed" :menu="headerMenu" :is-compact="settingStore.isSidebarCompact" />
</template>

<script setup lang="ts">
import { storeToRefs } from 'pinia';
import { computed } from 'vue';

import { usePermissionStore, useSettingStore } from '@/store';

import AdminHeader from './admin/Header.vue';
import MerchantHeader from './merchant/Header.vue';

const permissionStore = usePermissionStore();
const settingStore = useSettingStore();
const { asyncRoutes, app } = storeToRefs(permissionStore);
const headerMenu = computed(() => {
  if (settingStore.layout === 'mix') {
    if (settingStore.splitMenu) {
      return asyncRoutes.value.map((menu) => ({
        ...menu,
        children: [],
      }));
    }
    return [];
  }
  return asyncRoutes.value;
});
</script>
