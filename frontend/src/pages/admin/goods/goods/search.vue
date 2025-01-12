<template>
  <t-form layout="inline" label-width="auto">
    <t-form-item label="商户ID" name="user_id">
      <t-input v-model="params.user_id" clearable placeholder="请输入商户ID">
        <template #suffix-icon>
          <search-icon />
        </template>
      </t-input>
    </t-form-item>
    <t-form-item label="商户账号" name="username">
      <t-input v-model="params.username" clearable placeholder="请输入商户账号">
        <template #suffix-icon>
          <search-icon />
        </template>
      </t-input>
    </t-form-item>
    <!-- 联系方式 -->
    <t-form-item label="商品名称" name="name">
      <t-input v-model="params.name" clearable placeholder="请输入商品名称">
        <template #suffix-icon>
          <search-icon />
        </template>
      </t-input>
    </t-form-item>
    <t-form-item label="商品状态" name="status">
      <t-select v-model="params.status" placeholder="全部状态" type="search" clearable :options="statusOptions" />
    </t-form-item>
    <t-form-item label="冻结状态" name="is_freeze">
      <t-select v-model="params.is_freeze" placeholder="全部状态" type="search" clearable :options="freezeStatusOptions" />
    </t-form-item>

    <t-form-item label="时间范围" name="create_at">
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

const params = reactive<any>({
  date_range: [],
});

const emit = defineEmits(['success']);
const fetchData = () => {
  emit('success', params);
};
const statusOptions = ref([
  { label: '全部', value: '' },
  { label: '已上架', value: 1 },
  { label: '已下架', value: 0 },
]);
const freezeStatusOptions = ref([
  { label: '全部', value: '' },
  { label: '未冻结', value: 1 },
  { label: '已冻结', value: 0 },
]);
</script>
