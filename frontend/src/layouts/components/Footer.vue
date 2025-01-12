<template>
  <div v-if="footer === 'merchant'" :class="prefix + '-footer'">{{ siteInfoCopyright }}</div>
  <div v-else :class="prefix + '-footer'">
    Copyright © 2024 骑士发卡 强力驱动
    <!-- 本请勿删除版权信息 -->
    <!-- 本请勿删除版权信息 -->
    <!-- 本请勿删除版权信息 -->
    <t-link theme="primary" hover="color" style="margin-left: 10px" href="http://www.qqss.net" target="_blank">www.qqss.net</t-link>
  </div>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue';

import { prefix } from '@/config/global';
import { useSiteStore } from '@/store';

const siteStore = useSiteStore();
const siteInfoCopyright = computed(() => siteStore.config.site_info_copyright);

const footer = ref('');
const app = window.location.pathname.split('/')[1];
switch (app) {
  case 'admin':
    footer.value = 'admin';
    break;
  case 'merchant':
    footer.value = 'merchant';
    break;
  default:
}
</script>

<style lang="less" scoped>
.@{starter-prefix}-footer {
  color: var(--td-text-color-placeholder);
  line-height: 20px;
  text-align: center;
}
</style>
