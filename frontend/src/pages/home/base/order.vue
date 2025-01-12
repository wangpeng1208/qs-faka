<template>
  <default-order v-if="siteStore.getPcTemplate == 'default'" />
</template>

<script setup lang="ts">
import { useSiteStore } from '@/store';

import DefaultOrder from '../default/order/index.vue';

const siteStore = useSiteStore();
</script>
