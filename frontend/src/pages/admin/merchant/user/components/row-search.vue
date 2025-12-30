<template>
  <t-form layout="inline" label-width="auto">
    <t-form-item label="" name="username">
      <t-input v-model="params.username" clearable placeholder="请输入商户账号"> </t-input>
    </t-form-item>
    <t-form-item label="" name="mobile">
      <t-input v-model="params.mobile" clearable placeholder="请输入手机号码"> </t-input>
    </t-form-item>
    <t-form-item label="" name="date_range">
      <t-date-range-picker v-model="params.date_range" allow-input clearable cancel-range-select-limit />
    </t-form-item>
    <t-form-item>
      <t-button theme="primary" @click="fetchData">查询</t-button>
    </t-form-item>
  </t-form>
</template>

<script lang="ts">
export default {
  name: 'RowSearch',
};
</script>

<script setup lang="ts">
import { reactive } from 'vue';

const params = reactive<any>({
  date_range: [],
});

const emit = defineEmits(['success']);
const fetchData = () => {
  emit('success', params);
};
</script>
