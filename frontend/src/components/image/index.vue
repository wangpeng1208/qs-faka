<template>
  <div v-if="srcWithPrefix">
    <t-image-viewer :images="[srcWithPrefix]">
      <template #trigger="{ open }">
        <t-image v-bind="$attrs" :src="srcWithPrefix" :error="renderCustomIcon" @click="open" />
      </template>
    </t-image-viewer>
  </div>
</template>

<script lang="ts">
export default {
  name: 'WpImageComponent',
};
</script>
<script setup lang="ts">
import { ImageErrorIcon } from 'tdesign-icons-vue-next';
import { computed, h } from 'vue';

import { baseUrl } from '@/api/base';

const props = defineProps({
  src: {
    type: String,
  },
  errorSize: {
    type: String,
    default: '16',
  },
});

const srcWithPrefix = computed(() => {
  if (!props.src) {
    return ''; // 替换为你的默认图片 URL
  }
  return props.src.startsWith('http') ? props.src : baseUrl + props.src;
});

const renderCustomIcon = () => h(ImageErrorIcon, { size: props.errorSize });
</script>
