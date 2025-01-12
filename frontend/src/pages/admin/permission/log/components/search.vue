<template>
  <t-form layout="inline" label-width="auto">
    <t-form-item label="用户名" name="username">
      <t-input v-model="params.username" clearable placeholder="请输入用户名">
        <template #suffix-icon>
          <search-icon />
        </template>
      </t-input>
    </t-form-item>
    <!-- 订单号码 -->
    <t-form-item label="访问链接" name="action">
      <t-input v-model="params.action" clearable placeholder="请输入访问链接">
        <template #suffix-icon>
          <search-icon />
        </template>
      </t-input>
    </t-form-item>
    <t-form-item label="来源IP" name="ip">
      <t-input v-model="params.ip" clearable placeholder="请输入来源IP">
        <template #suffix-icon>
          <search-icon />
        </template>
      </t-input>
    </t-form-item>
    <t-form-item label="日志时间" name="create_at">
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
import { reactive } from 'vue';

const params = reactive<any>({
  date_range: [],
});

const emit = defineEmits(['success']);
const fetchData = () => {
  emit('success', params);
};
</script>
