<template>
  <!-- 无人扶我青云志，我自踏雪至云巅 -->
  <gutter-row
    :columns="[
      { span: 6, component: SystemCard },
      { span: 6, component: MenuCard },
      { span: 12, component: BasicCard },
      { span: 12, component: OrderStatis },
      // { span: 12, component: OrderChannel },
      // { span: 12, component: RankCard },
    ]"
  />
</template>

<script setup lang="ts">
import BasicCard from './components/BasicCard.vue';
import GutterRow from './components/GutterRow.vue';
import MenuCard from './components/MenuCard.vue';
// import OrderChannel from './components/OrderChannel.vue';
import OrderStatis from './components/OrderStatis.vue';
// import RankCard from './components/RankCard.vue';
import SystemCard from './components/SystemCard.vue';
</script>
