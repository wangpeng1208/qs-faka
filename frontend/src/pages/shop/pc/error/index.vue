<template>
  <result :tip="tip.error" type="404">
    <t-button @click="() => $router.push('/')">返回首页</t-button>
  </result>
</template>

<script lang="ts">
export default {
  name: 'Result404',
};
</script>

<script setup lang="ts">
import { toRefs } from 'vue';

import Result from '@/components/result/index.vue';

const props = defineProps<{
  tip: any;
}>();

const { tip } = toRefs(props);

// 标题
const setTitle = (title: string) => {
  document.title = title;
};

setTitle(`${tip.value.error}`);
</script>
