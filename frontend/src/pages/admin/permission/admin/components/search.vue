<template>
  <t-form layout="inline" label-width="auto">
    <t-form-item label="用户名" name="username">
      <t-input v-model="params.username" clearable placeholder="请输入用户名">
        <template #suffix-icon>
          <search-icon />
        </template>
      </t-input>
    </t-form-item>
    <!-- 联系方式 -->
    <t-form-item label="昵称" name="nickname">
      <t-input v-model="params.nickname" clearable placeholder="请输入昵称">
        <template #suffix-icon>
          <search-icon />
        </template>
      </t-input>
    </t-form-item>
    <!-- 订单号码 -->
    <t-form-item label="ID" name="id">
      <t-input v-model="params.id" clearable placeholder="请输入ID">
        <template #suffix-icon>
          <search-icon />
        </template>
      </t-input>
    </t-form-item>
    <t-form-item label="状态" name="status">
      <t-select v-model="params.status" :clear="fetchData" placeholder="全部状态" type="search" clearable :options="statusOptions" />
    </t-form-item>

    <t-button theme="default" variant="outline" @click="fetchData">查询</t-button>
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

const params = reactive<any>({});

const emit = defineEmits(['success']);
const fetchData = () => {
  emit('success', params);
};
const statusOptions = ref([
  { label: '正常', value: 1 },
  { label: '禁用', value: 0 },
]);
</script>
