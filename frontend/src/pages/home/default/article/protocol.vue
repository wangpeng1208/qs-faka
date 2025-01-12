<template>
  <div>todo {{ src }}</div>
</template>
<script setup lang="ts">
import { ref } from 'vue';

const src = ref('123');
</script>
