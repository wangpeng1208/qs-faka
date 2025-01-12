<template>
  <t-row
    :gutter="[
      { xs: 8, sm: 16, md: 24, lg: 32, xl: 32, xxl: 40 },
      { xs: 8, sm: 16, md: 24, lg: 32, xl: 32, xxl: 40 },
    ]"
  >
    <t-col :span="12">
      <!-- 收款统计 -->
      <t-card title=" " hover-shadow>
        <v-charts class="chart" :option="orderDayOption()" autoresize />

        <v-charts class="chart" :option="orderMonthOption()" autoresize />
      </t-card>
    </t-col>
  </t-row>
</template>
<script setup lang="ts">
import { ref } from 'vue';
import vCharts from 'vue-echarts';

import { orderStatisData } from '@/api/admin/workbench';

const orderDaysData = ref([]);
const orderMonthData = ref([]);

const chartOption = (titleText: string, data: any, type: 'bar' | 'line', isAreaChart: boolean = false) => {
  return {
    title: {
      show: true,
      text: titleText,
      left: 'center',
    },
    tooltip: {
      trigger: 'axis',
      axisPointer: {
        type: 'shadow',
      },
    },
    grid: {
      left: '5px',
      right: '5px',
      containLabel: true,
    },
    xAxis: [
      {
        type: 'category',
        data: data.xAxis,
        axisTick: {
          alignWithLabel: true,
        },
        axisLabel: { interval: 0, rotate: 30 },
      },
    ],
    yAxis: [
      {
        type: 'value',
        axisTick: {
          alignWithLabel: true,
        },
        axisLabel: {
          formatter: (value: string) => `${value} 元`,
        },
      },
    ],
    series: [
      {
        type,
        barWidth: '60%',
        data: data.series,
        // showBackground: true,
        backgroundStyle: {
          color: 'rgba(180, 180, 180, 0.2)',
        },
        areaStyle: isAreaChart ? {} : undefined,
        smooth: isAreaChart, // 如果是面积图，设置 smooth 为 true
      },
    ],
    dataZoom: isAreaChart
      ? undefined
      : [
          {
            type: 'slider',
            xAxisIndex: 0,
            start: 80,
            end: 100,
          },
        ], // 如果不是面积图，添加 dataZoom 属性
  };
};

const orderDayOption = () => chartOption('近30天收款统计', orderDaysData.value, 'bar', false);
const orderMonthOption = () => chartOption('年度收款统计', orderMonthData.value, 'line', true);
const fetchData = async (period: number, unit: 'day' | 'month') => {
  const res = await orderStatisData({ period, unit });
  return res.data;
};

const fetchDayData = async () => {
  orderDaysData.value = await fetchData(30, 'day');
};
fetchDayData();

const fetchMonthData = async () => {
  orderMonthData.value = await fetchData(12, 'month');
};
fetchMonthData();
</script>
<style scoped>
.chart {
  height: 30em;
}
</style>
