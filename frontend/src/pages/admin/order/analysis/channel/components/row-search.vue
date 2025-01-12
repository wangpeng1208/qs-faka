<template>
  <t-form layout="inline" label-width="auto">
    <t-form-item label="商户账号" name="username">
      <t-input v-model="params.username" clearable placeholder="请输入商户账号">
        <template #suffix-icon>
          <search-icon />
        </template>
      </t-input>
    </t-form-item>
    <!-- 支付通道 -->
    <t-form-item label="收款通道" name="channel_id">
      <t-select v-model="params.channel_id" :clear="fetchData" placeholder="请选择收款通道" type="search" clearable :options="payChannelOptions" />
    </t-form-item>
    <!-- 支付方式 -->
    <t-form-item label="支付方式" name="paytype">
      <t-select v-model="params.paytype" clearable placeholder="请选择支付方式">
        <t-option v-for="item in payTypeOptions" :key="item.value" :value="item.value" :label="item.label">
          <div class="tdesign-demo__user-option">
            <img :src="item.ico" style="width: 16px" />
            <div class="tdesign-demo__user-option-info">
              <div>{{ item.label }}</div>
              <div class="tdesign-demo__user-option-desc">{{ item.description }}</div>
            </div>
          </div>
        </t-option>
      </t-select>
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

import { listSimple } from '@/api/admin/channel/collection';
import { payTypeSimple } from '@/api/admin/channel/pay_type';
import { baseUrl } from '@/api/base';

const params = reactive<any>({
  date_range: [],
});

const emit = defineEmits(['success']);
const fetchData = () => {
  params.action = '';
  emit('success', params);
};

const payTypeOptions = ref();
// 加载支付分类
const initPayTypeOptions = async () => {
  const { data } = await payTypeSimple();
  data.forEach((item: any, key: any) => {
    data[key].ico = baseUrl + item.ico;
  });
  payTypeOptions.value = data;
};
initPayTypeOptions();

const payChannelOptions = ref();
// 加载支付通道
const initPayChannelOptions = async () => {
  const { data } = await listSimple();
  payChannelOptions.value = data;
};
initPayChannelOptions();
</script>

<style scoped>
.tdesign-demo__user-option {
  display: flex;
}

.tdesign-demo__user-option > img {
  max-width: 16px;
  max-height: 16px;
  border-radius: 50%;
}

.tdesign-demo__user-option-desc {
  font-size: 14px;
  color: var(--td-text-color-secondary);
}

.tdesign-demo__user-option-info {
  margin-left: 16px;
}
</style>
