<template>
  <t-form layout="inline" label-width="auto">
    <t-form-item label="商户账号" name="username">
      <t-input v-model="params.username" clearable placeholder="请输入商户账号">
        <template #suffix-icon>
          <search-icon />
        </template>
      </t-input>
    </t-form-item>
    <t-form-item label="商户ID" name="user_id">
      <t-input v-model="params.user_id" clearable placeholder="请输入商户ID">
        <template #suffix-icon>
          <search-icon />
        </template>
      </t-input>
    </t-form-item>
    <t-form-item label="业务类型" name="business_type">
      <t-select v-model="params.business_type" :clear="fetchData" placeholder="业务类型" type="search" clearable :options="businessTypesOptions" />
    </t-form-item>
    <t-form-item label="记录时间" name="date_range">
      <t-date-range-picker v-model="params.date_range" allow-input clearable cancel-range-select-limit />
    </t-form-item>
    <t-form-item>
      <t-space>
        <t-button theme="default" variant="outline" @click="fetchData">查询</t-button>
      </t-space>
    </t-form-item>
  </t-form>
</template>

<script lang="ts">
export default {
  name: 'RowSearch',
};
</script>

<script setup lang="ts">
import { SearchIcon } from 'tdesign-icons-vue-next';
import { reactive, ref } from 'vue';

import { businessTypes } from '@/api/admin/merchant/money-log';

const params = reactive<any>({
  date_range: [],
});

const emit = defineEmits(['success']);
const fetchData = () => {
  emit('success', params);
};
const businessTypesOptions = ref();
const getBusinessTypes = async () => {
  const { data } = await businessTypes();
  businessTypesOptions.value = Object.keys(data).map((key) => {
    return {
      label: data[key],
      value: key,
    };
  });
};
getBusinessTypes();
</script>
