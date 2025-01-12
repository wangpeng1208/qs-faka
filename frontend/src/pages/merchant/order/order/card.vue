<template>
  <t-card title="查看卡密" class="basic-container" :bordered="false">
    <t-space direction="vertical">
      <span v-for="(item, key) in cardList" :key="key"> {{ item.number }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ item.secret }} </span>
    </t-space>
  </t-card>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useRouter } from 'vue-router';

import { card } from '@/api/merchant/order/order';

const cardList = ref([]);
const fetchData = async () => {
  const router = useRouter();

  const { id } = router.currentRoute.value.query;
  const { data } = await card({
    id,
  });

  cardList.value = data.card;
};

fetchData();
</script>
