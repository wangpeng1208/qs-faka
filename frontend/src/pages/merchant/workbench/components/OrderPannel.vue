<template>
  <t-row :gutter="[16, 16]">
    <t-col :xs="12" :xl="12">
      <t-card :bordered="false" title="交易统计" :class="{ 'dashboard-overview-card': true, 'overview-panel': true }">
        <template #actions>
          <t-radio-group v-model="amountType" variant="default-filled" @change="renderStokeChart">
            <t-radio-button value="week">最近7天</t-radio-button>
            <t-radio-button value="month">月度统计</t-radio-button>
          </t-radio-group>
        </template>
        <v-charts class="chart" :option="orderOption()" autoresize />
      </t-card>
    </t-col>
  </t-row>
</template>

<script lang="ts">
export default {
  name: 'DashboardBase',
};
</script>

<script setup lang="ts">
import { ref } from 'vue';
import vCharts from 'vue-echarts';

import { getAnalysis } from '@/api/merchant/workbench';

const renderStokeChart = async () => {
  initData();
};
// stokeCharts
const amountType = ref('month');
const orderOption = () => {
  return {
    legend: {
      icon: 'rect',
      itemWidth: 12,
      itemHeight: 4,
      itemGap: 48,
      textStyle: {
        fontSize: 12,
      },
      left: 'center',
      bottom: '0',
      orient: 'horizontal',
      data: ['交易额', '结算额'],
    },
    tooltip: {
      trigger: 'item',
    },
    grid: {
      left: '5px',
      right: '5px',
      containLabel: true,
      bottom: '60px',
    },
    xAxis: [
      {
        type: 'category',
        data: chartData.value.xAxis,
        axisTick: {
          alignWithLabel: true,
        },
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
        type: 'bar',
        name: '交易额',
        data: chartData.value.series,
      },
      {
        type: 'bar',
        name: '结算额',
        data: chartData.value.finallyAmount,
      },
    ],
  };
};
const chartData = ref({ xAxis: [], series: [], finallyAmount: [] });
const analysisData = ref();
// 原始数据
const fetchData = async () => {
  const { data } = await getAnalysis();
  analysisData.value = data;
  await initData();
};
fetchData();
// 初始化数据
const initData = async () => {
  chartData.value.xAxis = [];
  chartData.value.series = [];
  chartData.value.finallyAmount = [];
  if (amountType.value === 'week') {
    for (let i = 0; i < analysisData.value.res_week.length; i++) {
      chartData.value.xAxis.push(analysisData.value.res_week[i].week);
      chartData.value.series.push(analysisData.value.res_week[i].day_amount);
      chartData.value.finallyAmount.push(analysisData.value.res_week[i].finally_amount);
    }
  } else {
    for (let i = 0; i < analysisData.value.res_month.length; i++) {
      chartData.value.xAxis.push(analysisData.value.res_month[i].month);
      chartData.value.series.push(analysisData.value.res_month[i].month_amount);
      chartData.value.finallyAmount.push(analysisData.value.res_month[i].month_finally_amount);
    }
  }
};
</script>

<style lang="less" scoped>
.dashboard-overview-card.export-panel,
.dashboard-overview-card.overview-panel {
  padding: 20px;
  margin: 20px 0;
}

:deep(.t-card__body) {
  padding: var(--td-comp-paddingTB-xxl) var(--td-comp-paddingLR-xxl);
}

.dashboard-overview-card {
  :deep(.t-card__header) {
    padding: 0;
  }

  :deep(.t-card__body) {
    padding: 0;
  }

  &.overview-panel {
    border-right: none;
  }
}
.chart {
  height: 25em;
}
</style>
