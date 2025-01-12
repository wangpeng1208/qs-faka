<template>
  <t-card title="结算配置" class="basic-container" :bordered="false">
    <t-form ref="formRef" label-align="left" :data="formData" :rules="FORM_RULES" :label-width="180">
      <!-- <t-form-item label="商户结算方式" name="settlement_type" tips="T0订单暂不支持投诉！">
        <t-radio-group v-model="formData.settlement_type" :options="settlementType" />
      </t-form-item> -->
      <t-form-item v-if="formData.settlement_type === 1" label="资金冻结时长" name="settlement_frezze_endtime" tips="建议开启后者，避免每日晚上的投诉订单处理时间不足（如果有投诉，解冻时间会是 投诉时间+24小时）">
        <t-radio-group v-model="formData.settlement_frezze_endtime" :options="settlementFreezeEndtimeOptions" />
      </t-form-item>
      <!-- 提现开关 -->
      <t-form-item label="提现开关" name="cash_status" tips="开启后，商户可以提现">
        <t-radio-group v-model="formData.cash_status" :options="statusOptions" />
      </t-form-item>
      <!-- 自动提现开关 -->
      <t-form-item label="自动提现开关" name="auto_cash" tips="开启后，每天对达到条件的用户自动提现">
        <t-radio-group v-model="formData.auto_cash" :options="statusOptions" />
      </t-form-item>
      <!-- 自动提现触发时间 -->
      <t-form-item label="自动提现触发时间" name="auto_cash_time" tips="达到时间之后，再执行任务计划则会触发自动提现">
        <t-select v-model="formData.auto_cash_time" :options="hours" />
      </t-form-item>
      <!-- 开启提现方式 -->
      <t-form-item label="开启提现方式" name="cash_type" tips="开启后，商户可以提现">
        <t-checkbox-group v-model="formData.cash_type" :options="cashTypeOptions" />
      </t-form-item>
      <!-- 最低自动提现金额 -->
      <t-form-item label="最低自动提现金额" name="auto_cash_money" tips="最低提现金额">
        <t-input-number v-model="formData.auto_cash_money" :min="0" :max="99999999" />
      </t-form-item>
      <!-- 提现关闭提示 -->
      <t-form-item label="提现关闭提示" name="cash_close_tips" tips="满50每天12点自动结算，无须手动结算。">
        <t-input v-model="formData.cash_close_tips" />
      </t-form-item>
      <!-- 允许提现时间 -->
      <t-form-item label="允许提现时间" tips="达到时间之后，再执行任务计划则会触发自动提现">
        <t-select v-model="formData.cash_limit_time_start" :options="hours" />
        <t-select v-model="formData.cash_limit_time_end" :options="hours" />
      </t-form-item>
      <!-- 最低提现金额 -->
      <t-form-item label="最低提现金额" name="cash_min_money" tips="最低提现金额">
        <t-input-number v-model="formData.cash_min_money" :min="0" :max="99999999" />
      </t-form-item>
      <!-- 手动提现手续费类型 -->
      <t-form-item label="手动提现手续费类型" name="cash_fee_type" tips="提现手续费">
        <t-radio-group v-model="formData.cash_fee_type" :options="cashFeeTypeOptions" />
      </t-form-item>
      <!-- 手动提现手续费 -->
      <t-form-item label="手动提现手续费" name="cash_fee" tips="提现手续费">
        <t-input-number v-model="formData.cash_fee" :min="0" :max="5000" />
      </t-form-item>
      <!-- 自动提现手续费类型 -->

      <t-form-item label="自动提现手续费类型" name="auto_cash_fee_type" tips="提现手续费">
        <t-radio-group v-model="formData.auto_cash_fee_type" :options="cashFeeTypeOptions" />
      </t-form-item>
      <!-- 自动提现手续费 -->
      <t-form-item label="自动提现手续费" name="auto_cash_fee" tips="提现手续费">
        <t-input-number v-model="formData.auto_cash_fee" :min="0" :max="5000" />
      </t-form-item>
      <!-- 提现次数限制 -->
      <t-form-item label="提现次数限制" name="cash_limit_num" tips="已达到今日最多提现次数！">
        <t-input-number v-model="formData.cash_limit_num" :min="0" :max="5000" />
      </t-form-item>
      <!-- 超过限制提示 -->
      <t-form-item label="超过限制提示" name="cash_limit_num_tips" tips="已达到今日最多提现次数！">
        <t-input v-model="formData.cash_limit_num_tips" />
      </t-form-item>
      <t-form-item>
        <t-space size="small">
          <t-button theme="primary" @click="submit">提交</t-button>
          <t-button theme="default" variant="base" type="reset">重置</t-button>
        </t-space>
      </t-form-item>
    </t-form>
  </t-card>
</template>

<script lang="ts">
export default {
  name: 'WebInfo',
};
</script>

<script setup lang="ts">
import { FormRule, MessagePlugin } from 'tdesign-vue-next';
import { reactive, ref } from 'vue';

import { editConfig, getConfig } from '@/api/admin/config/config';

import { cashFeeTypeOptions, cashTypeOptions, hours, settlementFreezeEndtimeOptions, statusOptions } from './constant';

const formData = reactive({
  settlement_type: 1,
  settlement_frezze_endtime: 1,
  cash_status: 1,
  auto_cash: 1,
  auto_cash_time: 0,
  cash_type: [],
  auto_cash_money: 50,
  cash_close_tips: '满50每天12点自动结算，无须手动结算。',
  cash_limit_time_start: 0,
  cash_limit_time_end: 0,
  cash_min_money: 100,
  cash_fee_type: 1,
  cash_fee: 18,
  auto_cash_fee_type: 1,
  auto_cash_fee: 15,
  cash_limit_num: 1,
  cash_limit_num_tips: '已达到今日最多提现次数！',
});

// 获取配置
const fetchConfig = async () => {
  const { data } = await getConfig({
    field: Object.keys(formData),
  });
  for (const key in data) {
    // @ts-ignore
    if (key === 'cash_type') {
      formData.cash_type = [...data[key]];
    } else {
      // @ts-ignore
      formData[key] = data[key];
    }
  }
};
fetchConfig();

const FORM_RULES: Record<string, FormRule[]> = {};
const formRef = ref();
const submit = async () => {
  const result = await formRef.value.validate();
  if (typeof result !== 'object' && result) {
    const res = await editConfig({
      data: formData,
    });
    if (res.code === 1) {
      MessagePlugin.success('操作成功');
    } else {
      MessagePlugin.error(res.msg);
    }
  }
};
</script>
