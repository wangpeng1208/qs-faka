<template>
  <default-login v-if="pcTemplate == 'default'" />
</template>

<script setup lang="ts">
import { useSiteStore } from '@/store';

import DefaultLogin from '../default/login/index.vue';

const siteStore = useSiteStore();
const { pc_template: pcTemplate } = siteStore.config;
</script>
