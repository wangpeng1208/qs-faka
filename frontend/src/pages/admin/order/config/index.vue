<template>
  <t-card title="订单配置" class="basic-container" :bordered="false">
    <template #actions>
      <t-button theme="primary" @click="submit">提交</t-button>
    </template>
    <t-form ref="formRef" label-align="left" :data="formData" :rules="FORM_RULES" :label-width="150" style="width: 800px">
      <t-form-item label="订单生成方式" name="order_trade_no_type" help="">
        <!-- radio  -->
        <t-radio-group v-model="formData.order_trade_no_type" :options="tradeNoOptions" />
      </t-form-item>
      <t-form-item v-if="formData.order_trade_no_type == '0'" label="订单号前缀" name="order_trade_no_profix" help="">
        <t-input v-model="formData.order_trade_no_profix" clearable placeholder="请输入订单号前缀" />
      </t-form-item>
      <t-form-item label="订单标题" name="order_title_type" help="">
        <t-radio-group v-model="formData.order_title_type" :options="titleTypeOptions" />
      </t-form-item>
      <t-form-item v-if="formData.order_title_type == '2'" label="标题前缀" name="order_title_profix">
        <t-input v-model="formData.order_title_profix" clearable placeholder="" />
      </t-form-item>
      <t-form-item v-if="formData.order_title_type == '3'" label="自定义标题" name="order_title_str">
        <t-input v-model="formData.order_title_str" clearable placeholder="" />
      </t-form-item>

      <t-form-item label="禁用简单联系方式" name="order_query_blackcontact">
        <t-textarea
          v-model="formData.order_query_blackcontact"
          clearable
          placeholder="请输入要禁用的简单联系方式"
          tips="防止出现简单联系方式，使用“|”分隔"
          :autosize="{
            minRows: 5,
            maxRows: 10,
          }"
        />
      </t-form-item>
      <t-divider />
      <t-form-item label="投诉退款自动退款" name="complaint_refund" tips="投诉退款,买家胜诉时是否自动通过购买渠道退款">
        <t-radio-group
          v-model="formData.complaint_refund"
          :options="[
            { label: '开启', value: 1 },
            { label: '关闭', value: 0 },
          ]"
        />
      </t-form-item>
      <t-divider />
      <!-- 手续费承担方 -->
      <t-form-item label="手续费承担方" name="transaction_min_fee" tips="手续费承担方">
        <t-radio-group v-model="formData.fee_payer" :options="feePayerOptions" />
      </t-form-item>
      <!-- 最低交易手续费 -->
      <t-form-item label="最低交易手续费" name="transaction_min_fee" tips="最低交易手续费">
        <t-input-number v-model="formData.transaction_min_fee" theme="normal" :min="0" clearable placeholder="请输入最低交易手续费" />
      </t-form-item>
      <t-divider />
      <t-form-item label="购卡协议链接" name="purchase_agreement" help="">
        <t-input v-model="formData.purchase_agreement" clearable placeholder="请输入购卡协议链接" />
      </t-form-item>
      <t-form-item>
        <t-space size="small">
          <t-button theme="primary" @click="submit">提交</t-button>
        </t-space>
      </t-form-item>
    </t-form>
  </t-card>
</template>

<script setup lang="ts">
import { FormRule, MessagePlugin } from 'tdesign-vue-next';
import { reactive, ref } from 'vue';

import { editConfig, getConfig } from '@/api/admin/config/config';

const tradeNoOptions = [
  { label: '系统默认', value: 0 },
  { label: '用户ID+时间+顺序号机', value: 1 },
];
const titleTypeOptions = [
  { label: '商品名称', value: 0 },
  { label: '订单编号', value: 1 },
  { label: '前缀+订单编号', value: 2 },
  { label: '自定义', value: 3 },
];
const feePayerOptions = [
  { label: '卖家', value: 1 },
  { label: '买家', value: 2 },
  // { label: '平台', value: 3 },
];
const formData = reactive({
  order_trade_no_type: '',
  order_trade_no_profix: '',
  order_title_type: '',
  order_title_profix: '',
  order_title_str: '',
  order_auto_close_time: '',
  order_query_blackcontact: '',
  complaint_refund: '',
  transaction_min_fee: '',
  fee_payer: '',
  purchase_agreement: '',
});
// 获取配置
const fetchConfig = async () => {
  const { data } = await getConfig({
    field: Object.keys(formData),
  });
  for (const key in data) {
    // @ts-ignore
    formData[key] = data[key];
  }
};
fetchConfig();

const FORM_RULES: Record<string, FormRule[]> = {
  order_auto_close_time: [{ required: true, message: '请输入订单超时时间' }],
};
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
