<template>
  <div v-if="siteStore.getSiteStatus == 0">站点已关闭</div>
  <div v-else>
    <default-acticle-info v-if="siteStore.getPcTemplate == 'default'" :id="id" :key="id" />
  </div>
</template>

<script setup lang="ts">
import { ref, watchEffect } from 'vue';
import { useRoute } from 'vue-router';

import { useSiteStore } from '@/store';

import DefaultActicleInfo from '../default/article/detail.vue';

const siteStore = useSiteStore();
const id = ref();
const route = useRoute();
watchEffect(() => {
  id.value = route.params.id;
});
</script>
