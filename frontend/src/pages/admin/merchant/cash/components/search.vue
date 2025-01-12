<template>
  <t-space align="center">
    <t-form-item label="商户账号" name="username">
      <t-input v-model="params.username" clearable placeholder="请输入商户账号">
        <template #suffix-icon>
          <search-icon />
        </template>
      </t-input>
    </t-form-item>
    <t-form-item label="收款类型" name="type">
      <t-select v-model="params.type" :clear="fetchData" placeholder="审核状态" type="search" clearable :options="typeOptions" />
    </t-form-item>
    <t-form-item label="审核状态" name="status">
      <t-select v-model="params.status" :clear="fetchData" placeholder="审核状态" type="search" clearable :options="statusOptions" />
    </t-form-item>
    <t-form-item label="记录时间" name="date_range">
      <t-date-range-picker v-model="params.date_range" allow-input clearable cancel-range-select-limit />
    </t-form-item>

    <t-button theme="default" variant="outline" @click="fetchData">查询</t-button>
  </t-space>
</template>

<script lang="ts">
export default {
  name: 'RowSearch',
};
</script>

<script setup lang="ts">
import { SearchIcon } from 'tdesign-icons-vue-next';
import { reactive } from 'vue';

import { statusOptions, typeOptions } from './constant';

const params = reactive<any>({
  date_range: [],
});

const emit = defineEmits(['success']);
const fetchData = () => {
  emit('success', params);
};
</script>
