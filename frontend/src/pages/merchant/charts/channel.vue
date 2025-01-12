<template>
  <t-card title="渠道分析" class="basic-container" :bordered="false">
    <div class="category-header c-flex">
      <t-row>
        <t-col :span="8">
          <t-col :flex="1" :span="3">
            <t-date-range-picker v-model="formData.range" theme="primary" mode="date" :default-value="LAST_7_DAYS" separator="至" :presets="presets" @change="fetchData" />
          </t-col>
        </t-col>
        <t-col :span="4"> </t-col>
      </t-row>
    </div>

    <t-base-table :data="list" :columns="COLUMNS" :stripe="true" row-key="title" :hover="true" :loading="dataLoading" :header-affixed-top="headerAffixedTop">
      <template #sum_money="{ row }">
        <span>{{ formatMoney(row.sum_money) }}</span>
      </template>
      <template #sum_actual_money="{ row }">
        <span>{{ formatMoney(row.sum_actual_money) }}</span>
      </template>
    </t-base-table>
  </t-card>
</template>

<script lang="ts">
export default {
  name: 'ChartChartlist',
};
</script>

<script setup lang="ts">
import dayjs from 'dayjs';
import type { PresetRange } from 'tdesign-vue-next/es/date-picker/type';
import { computed, onMounted, Ref, ref } from 'vue';

import { getChartsChannel } from '@/api/merchant/charts/charts';
import { prefix } from '@/config/global';
import { COLUMNS } from '@/constant/charts/channel/constant';
import { useSettingStore } from '@/store';
import { formatMoney } from '@/utils/common';
import { LAST_7_DAYS } from '@/utils/date';

const store = useSettingStore();

const presets: Ref<PresetRange> = ref({
  '60天前-120天前': [dayjs().subtract(119, 'day').toDate(), dayjs().subtract(59, 'day').toDate()],
  '30天前-60天前': [dayjs().subtract(59, 'day').toDate(), dayjs().subtract(29, 'day').toDate()],
  '1天前-30天前': [dayjs().subtract(29, 'day').toDate(), dayjs().subtract(1, 'day').toDate()],
  '今天-300天前': [dayjs().subtract(299, 'day').toDate(), dayjs().toDate()],
});

const formData = ref({
  range: [dayjs().subtract(120, 'day').format('YYYY-MM-DD'), dayjs().format('YYYY-MM-DD')],
  action: '',
});
// 列表数据
const list = ref([]);
const dataLoading = ref(false);
const fetchData = async () => {
  dataLoading.value = true;
  const params = {
    start_time: formData.value.range[0],
    end_time: formData.value.range[1],
    action: formData.value.action,
  };
  try {
    const { data } = await getChartsChannel(params);
    //  data.list json转数组
    list.value = data.list;
  } catch (e) {
    console.log(e);
  } finally {
    dataLoading.value = false;
  }
};
//
onMounted(() => {
  fetchData();
});

const headerAffixedTop = computed(() => ({
  offsetTop: store.isUseTabsRouter ? 48 : 0,
  container: `.${prefix}-layout`,
}));
</script>
