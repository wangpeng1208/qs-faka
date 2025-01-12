<template>
  <t-drawer v-model:visible="visible" size-draggable size="80%" header="商铺详情" @close="close" @confirm="close">
    <ul>
      <li>店铺名称：{{ shopDetail?.shop_name }}</li>
      <li>用户名：{{ shopDetail?.username }}</li>
      <li>创建时间：{{ formatTime(shopDetail?.create_at) }}</li>
    </ul>
  </t-drawer>
</template>
<script setup lang="ts">
import { ref } from 'vue';

import { formatTime } from '@/utils/date';

const visible = ref(false);
const shopDetail = ref();
const init = (row: { [key: string]: any } | null = null) => {
  visible.value = true;
  shopDetail.value = row;
};
defineExpose({
  init,
});
const emit = defineEmits(['success']);
const close = () => {
  visible.value = false;
  emit('success');
};
</script>
