<template>
  <t-card :bordered="false">
    <template #title>
      我的钱包
      <span class="sub-title">数据更新于：{{ time }}</span>
    </template>
    <template #actions> </template>
    <t-row :gutter="16">
      <t-col v-for="(item, index) in initData.PANE_LIST" :key="index" :span="2">
        <t-card :title="item.title" class="walletData">
          <div class="walletDataItem">
            {{ item.number }}
          </div>
        </t-card>
      </t-col>
    </t-row>
  </t-card>
</template>

<script lang="ts">
export default {
  name: 'WorkbenchBase',
};
</script>

<script setup lang="ts">
import { BarChart, LineChart } from 'echarts/charts';
import * as echarts from 'echarts/core';
import { CanvasRenderer } from 'echarts/renderers';
import _ from 'lodash';
import { reactive, ref } from 'vue';

import { getDashboard } from '@/api/merchant/workbench';

import { PANE_LIST } from '../constant/index';

echarts.use([LineChart, BarChart, CanvasRenderer]);

const initData = reactive({
  PANE_LIST,
});

const user = reactive({
  username: '',
  mobile: '',
  money: '0.000',
  freeze_money: '0.000',
});
const showWallet = ref(false);
const time = ref('');
const initDashboard = async () => {
  const { data } = await getDashboard();
  time.value = data.time;
  // 格式话data.today.transaction_money的3位小数
  const properties = [
    { key: 'user.money', index: 0 },
    { key: 'user.freeze_money', index: 1 },
    { key: 'today.transaction_money', index: 2, toFixed: true },
    { key: 'today.profit', index: 3, toFixed: true },
    { key: 'yesterday.transaction_money', index: 4, toFixed: true },
    { key: 'yesterday.profit', index: 5, toFixed: true },
  ];

  properties.forEach((property) => {
    let value = _.get(data, property.key);
    if (property.toFixed) {
      if (value !== undefined) {
        value = Number(value).toFixed(3);
      } else {
        value = '0.000';
      }
    }

    initData.PANE_LIST[property.index].number = `${value}`;
  });
  // 组合 data.user 到 user
  Object.assign(user, data.user);
  showWallet.value = true;
};

initDashboard();
</script>

<style lang="less" scoped>
.walletData {
  padding: 0 30px 0 0;
  align-items: center;

  .walletDataItem {
    padding: 10px 0;
    font-size: 20px;
    font-weight: 500;
    color: #333;
    padding-left: 20px;
    // 第一个.walletDataItem 无左边距
    &:first-child {
      padding-left: 0;
    }

    // 最后一个.walletDataItemNum 无字体加粗
    &:last-child {
      .walletDataItemNum {
        font-weight: 400;
      }
    }
  }
}
:deep(.t-card__title) {
  margin-right: 0;
}
.t-card__footer {
  margin-top: 15px;
  background-image: -webkit-gradient(linear, left top, right top, from(#fff5f3), to(rgba(255, 245, 243, 0.3)));
  background-image: linear-gradient(90deg, #fff5f3, rgba(255, 245, 243, 0.3));
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-pack: start;
  -ms-flex-pack: start;
  justify-content: flex-start;
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  color: #555;
  font-size: 11px;
  padding-left: 20px;

  .rzBtn {
    font-size: 12px;
    color: #ee4828;
    padding-left: 10px;
  }
}
.sub-title {
  padding-left: 15px;
  font-size: 12px;
  font-weight: normal;
  color: #999;
  margin-bottom: 10px;
}
</style>
