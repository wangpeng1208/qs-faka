<template>
  <t-space align="center">
    <t-form-item label="搜索字段" name="field">
      <t-select v-model="params.field" :clear="fetchData" placeholder="请选择搜索字段" type="search" clearable :options="fieldOptions">
        <template #suffix-icon>
          <search-icon />
        </template>
      </t-select>
    </t-form-item>
    <t-form-item label="商户ID" name="keyword">
      <t-input v-model="params.keyword" clearable placeholder="请输入关键词">
        <template #suffix-icon>
          <search-icon />
        </template>
      </t-input>
    </t-form-item>
    <t-form-item label="IP" name="ip">
      <t-input v-model="params.ip" clearable placeholder="请输入IP">
        <template #suffix-icon>
          <search-icon />
        </template>
      </t-input>
    </t-form-item>
    <t-form-item label="登录时间" name="date_range">
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

const params = reactive<any>({
  date_range: [],
});

const emit = defineEmits(['success']);
const fetchData = () => {
  emit('success', params);
};

const fieldOptions = [
  { label: '商户ID', value: 'id' },
  { label: '账号', value: 'username' },
  { label: '手机号码', value: 'mobile' },
  { label: 'QQ', value: 'qq' },
];
</script>
