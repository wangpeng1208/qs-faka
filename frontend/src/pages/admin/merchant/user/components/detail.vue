<template>
  <t-drawer v-model:visible="visible" size="100%" :close-on-overlay-click="false" :destroy-on-close="true" header="详情" :on-confirm="onSubmit">
    <div v-if="visible" title="账户资料">
      <t-space align="center" break-line>
        <span> <t-avatar :src="formData?.avatar" size="large" style="margin-right: 10px" /> 账号：{{ formData?.username }}</span>
        <span>手机号：{{ formData?.mobile }}</span>
        <span>邮箱：{{ formData?.email }}</span>
        <span>状态：{{ formData?.status === 1 ? '启用' : '禁用' }}</span>
        <span>是否冻结：{{ formData?.is_freeze === 1 ? '是' : '否' }}</span>
        <span>注册时间：{{ formatTime(formData?.create_at) }}</span>
        <span>最后登录IP：{{ formData?.ip }}</span>
        <span>下级商户数：{{ formData?.sub_user_count }}</span>
        <span>店铺名：{{ formData?.shop_name }}</span>
        <template #separator>
          <t-divider layout="vertical" />
        </template>
      </t-space>
      <t-space style="padding-left: 60px">
        <span>余额：{{ formData?.money }}</span>
        <span>冻结金额：{{ formData?.freeze_money }}</span>
        <span>佣金：{{ formData?.rebate }}</span>
        <template #separator>
          <t-divider layout="vertical" />
        </template>
      </t-space>
    </div>
  </t-drawer>
</template>

<script lang="ts">
export default {
  name: 'EditPopup',
};
</script>

<script setup lang="ts">
import { ref } from 'vue';

import { formatTime } from '@/utils/date';

const formData = ref({}) as any;

const visible = ref(false);
const init = (row: Object) => {
  formData.value = { ...row };

  visible.value = true;
};

defineExpose({
  init,
});

const onSubmit = async () => {
  visible.value = false;
};
</script>
