<template>
  <div>
    <workbench-base class="row-container" />
    <step-base class="row-container" />
    <order-pannel class="row-container" />
    <order-list class="row-container" />
    <!-- <middle-chart class="row-container" /> -->
  </div>
</template>

<script lang="ts">
export default {
  name: 'UserBase',
};
</script>

<script setup lang="ts">
// import MiddleChart from './components/MiddleChart.vue';
import OrderList from './components/OrderList.vue';
import OrderPannel from './components/OrderPannel.vue';
import StepBase from './components/Step.vue';
import WorkbenchBase from './components/WorkbenchBase.vue';
</script>

<style scoped>
/* .row-container:not(:last-child) {
  margin-bottom: 16px;
} */
</style>
