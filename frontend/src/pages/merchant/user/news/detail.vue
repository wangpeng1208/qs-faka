<template>
  <t-card title="公告内容" class="basic-container" :bordered="false">
    <div class="secondary-notification">
      <div style="margin: 0 auto; text-align: center">{{ article?.title }}</div>
      <div style="margin: 0 auto; text-align: center">{{ formatTime(article?.create_at) }}</div>
      <div style="padding: 20px; line-height: 1.5" v-html="article?.content"></div>
    </div>
  </t-card>
</template>

<script lang="ts">
export default {
  name: 'DetailSecondary',
};
</script>

<script setup lang="ts">
import { ref, watchEffect } from 'vue';
import { useRoute } from 'vue-router';

import { detail, read } from '@/api/merchant/user/news';
import { formatTime } from '@/utils/date';

const id = ref();
const route = useRoute();

watchEffect(() => {
  id.value = route.params.id;
});

const article = ref();
const getDetail = async () => {
  const res = await detail({ id: id.value });
  if (res.data) {
    article.value = { ...res.data };
  }
};

const setRead = async (id: number) => {
  await read({ id });
};

getDetail();
setRead(id.value);
</script>

<style lang="less" scoped>
@import url('./index.less');
</style>
