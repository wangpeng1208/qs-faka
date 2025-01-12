<template>
  <div v-if="siteStore.getSiteStatus == 0">站点已关闭</div>
  <div v-else>
    <default-about v-if="pc_template == 'default'" />
  </div>
</template>

<script setup lang="ts">
import { useSiteStore } from '@/store';

import DefaultAbout from '../default/about/index.vue';

const siteStore = useSiteStore();
// eslint-disable-next-line camelcase
const { pc_template } = siteStore.config;
</script>
