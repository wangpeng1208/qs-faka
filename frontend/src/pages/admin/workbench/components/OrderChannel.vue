<template>
  <t-card title="总收款渠道" hover-shadow>
    <v-charts class="chart" :option="orderChannelOption()" autoresize />
  </t-card>
</template>
<script setup lang="ts">
import { ref } from 'vue';
import vCharts from 'vue-echarts';

import { channelCollectionOrderPriceSum } from '@/api/admin/workbench';

const orderData = ref([]);

const orderChannelOption = () => {
  return {
    title: {
      show: false,
    },
    tooltip: {
      triggerOn: 'mousemove',
      trigger: 'item',
    },
    grid: {
      top: '3%',
      left: '3%',
      right: '4%',
      bottom: '3%',
      containLabel: true,
    },
    series: [
      // 饼状图
      {
        type: 'pie',
        radius: '50%',
        data: orderData.value,

        label: {
          show: true,
          formatter: '{b} : {c} ({d}%)',
        },

        labelLine: {
          show: false,
        },
      },
    ],
  };
};

const fetchData = async () => {
  const res = await channelCollectionOrderPriceSum();
  orderData.value = res.data;
};
fetchData();
</script>
<style scoped>
.chart {
  height: 10vh;
}
</style>
