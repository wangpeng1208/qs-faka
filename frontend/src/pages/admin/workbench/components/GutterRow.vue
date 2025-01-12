<!-- GutterRow.vue -->
<template>
  <t-row
    :gutter="[
      { xs: 8, sm: 16, md: 24, lg: 32, xl: 32, xxl: 32 },
      { xs: 8, sm: 16, md: 24, lg: 32, xl: 32, xxl: 32 },
    ]"
  >
    <t-col v-for="(column, index) in columns" :key="index" :span="column?.span">
      <component :is="column.component" />
    </t-col>
  </t-row>
</template>

<script setup lang="ts">
import { DefineComponent, defineProps } from 'vue';

defineProps({
  columns: {
    type: Array as () => Array<{ span: number; component: DefineComponent<{}, {}, any> }>,
    required: true,
  },
});
</script>
