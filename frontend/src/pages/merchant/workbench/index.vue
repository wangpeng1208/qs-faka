<template>
  <div>
    <workbench-base class="row-container" />
    <step-base class="row-container" />
    <order-pannel class="row-container" />
    <order-list class="row-container" />
  </div>
</template>

<script lang="ts">
export default {
  name: 'UserBase',
};
</script>

<script setup lang="ts">
import OrderList from './components/OrderList.vue';
import OrderPannel from './components/OrderPannel.vue';
import StepBase from './components/Step.vue';
import WorkbenchBase from './components/WorkbenchBase.vue';
</script>
