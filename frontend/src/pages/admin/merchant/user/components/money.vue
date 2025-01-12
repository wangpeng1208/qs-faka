<template>
  <t-dialog v-model:visible="visible" :close-on-overlay-click="false" :destroy-on-close="true" :header="title" :on-confirm="onSubmit">
    <t-descriptions title="">
      {{ fetchData }}
      <t-descriptions-item label="可用余额：">{{ fetchData.money }}元</t-descriptions-item>
      <t-descriptions-item label="冻结余额：">{{ fetchData.freeze_money }}元</t-descriptions-item>
      <t-descriptions-item label="预存：">{{ fetchData.fee_money }}元</t-descriptions-item>
      <t-descriptions-item label="保证金：">{{ fetchData.deposit_money }}元</t-descriptions-item>
    </t-descriptions>
    <t-divider>资金操作</t-divider>
    <t-form ref="formRef" label-align="left" :data="formData" :rules="FORM_RULES" :label-width="80">
      <t-form-item label="操作类型" name="action">
        <t-select v-model="formData.action" :options="actionTypeOption" />
      </t-form-item>
      <t-form-item label="操作金额" name="money">
        <t-input-number v-model="formData.money" clearable placeholder="请输入操作金额" theme="column" suffix="元" min="0" style="width: 600px" />
      </t-form-item>
      <t-form-item label="操作备注" name="mark">
        <t-input v-model="formData.mark" clearable placeholder="请输入操作备注" />
      </t-form-item>
    </t-form>
  </t-dialog>
</template>

<script lang="ts">
export default {
  name: 'MoneyPopup',
};
</script>

<script setup lang="ts">
import { FormRule, MessagePlugin } from 'tdesign-vue-next';
import { reactive, ref } from 'vue';

import { detail, money } from '@/api/admin/merchant/user';

const actionTypeOption = [
  { label: '加钱', value: 'inc' },
  { label: '扣钱', value: 'dec' },
  { label: '解冻', value: 'unfreeze' },
  { label: '冻结', value: 'freeze' },
  { label: '加预存', value: 'customchannelfeeadd' },
  { label: '扣预存', value: 'customchannelfeedec' },
  { label: '加保证金', value: 'customchanneldepositadd' },
  { label: '扣保证金', value: 'customchanneldepositdec' },
];
const DATA = {
  user_id: 0,
  action: 'inc',
  money: '',
  mark: '',
};
const formData = reactive({ ...DATA });
const fetchData = reactive({
  money: 0,
  freeze_money: 0,
  fee_money: 0,
  deposit_money: 0,
});
const formRef = ref();
const visible = ref(false);
const title = ref('资金管理');
const init = (id: number) => {
  getDetail(id);
  visible.value = true;
};

const getDetail = async (id: number) => {
  formData.user_id = id;
  const { data } = await detail({ id });
  for (const key in fetchData) {
    // @ts-ignore
    fetchData[key] = data[key];
  }
};

defineExpose({
  init,
});

const FORM_RULES: Record<string, FormRule[]> = {
  money: [{ required: true, message: '必填', type: 'error' }],
};
const emit = defineEmits(['success']);
const onSubmit = async () => {
  const result = await formRef.value.validate();
  if (typeof result !== 'object' && result) {
    try {
      const res = await money(formData);
      if (res.code === 1) {
        MessagePlugin.success('操作成功');
        visible.value = false;
        emit('success');
      } else {
        MessagePlugin.error(res.msg);
      }
    } catch (e) {
      MessagePlugin.error(e.msg);
    }
  }
};
</script>
