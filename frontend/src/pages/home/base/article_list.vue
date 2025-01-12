<template>
  <default-acticlelist v-if="siteStore.getPcTemplate == 'default'" />
</template>
<script setup lang="ts">
import { useSiteStore } from '@/store';

import DefaultActiclelist from '../default/article/list.vue';

const siteStore = useSiteStore();
</script>
