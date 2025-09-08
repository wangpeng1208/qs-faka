<template>
  <t-card title="提现设置" class="basic-container" :bordered="false">
    <t-form label-align="left" :label-width="20">
      <t-form-item name="cash_type" :help="cashTypeHelp">
        <t-radio-group v-model="config.user.cash_type" :options="cashTypeOptions" @change="submitUserCashType" />
      </t-form-item>
    </t-form>
  </t-card>
  <t-card class="basic-container" :bordered="false">
    <template #title>
      <div class="title">收款信息</div>
      <div class="tips">
        <span v-if="!disabled"> [请务必检查正确]</span>
        <span v-else> [修改收款方式请联系客服]</span>
      </div>
    </template>
    <t-form ref="form" :data="formData" :rules="FORM_RULES" label-align="left" :label-width="150" :disabled="disabled" @submit="onSubmit">
      <!-- 通过type列表 -->
      <t-form-item label="收款方式" name="type">
        <t-radio-group v-model="formData.type" :options="cashTypesOptions" :disabled="disabled" />
      </t-form-item>
      <t-form-item v-if="formData.type == 3" label="开户银行" name="bank">
        <t-select v-model="formData.bankname" :options="bankList" />
      </t-form-item>
      <t-form-item :label="labelAccount" name="account">
        <t-input v-model="formData.account" placeholder="请输入收款账号" />
      </t-form-item>
      <t-form-item label="收款人姓名" name="realname">
        <t-input v-model="formData.realname" placeholder="请输入收款人姓名" />
      </t-form-item>
      <t-form-item label="身份证号" name="idcard_number">
        <t-input v-model="formData.idcard_number" placeholder="请输入身份证号" />
      </t-form-item>
      <t-form-item label="收款二维码" name="collect_img">
        <wp-upload theme="image" :initial="formData" app="merchant" name="collect_img" :data="{ type: 'image' }" @update="handleUpdateImage" />
      </t-form-item>
      <!-- 表单内容 -->
      <t-form-item v-if="!disabled">
        <t-button theme="primary" class="form-submit-confirm" type="submit">
          <template #icon> <t-icon name="edit" /></template>
          保存
        </t-button>
      </t-form-item>
    </t-form>
  </t-card>
</template>
<script lang="ts">
export default {
  name: 'FinanceCollect',
};
</script>

<script setup lang="ts">
import { FormRule, MessagePlugin } from 'tdesign-vue-next';
import { computed, reactive, ref } from 'vue';

import { applyConfig, getCollect, setCollect, setUserCashType } from '@/api/merchant/finance/cash';
import { bankList, cashTypeOptions } from '@/constant/user/collect/constant';

const formData = reactive({
  type: 1,
  account: '',
  realname: '',
  idcard_number: '',
  collect_img: '',
  allow_update: 1,
  bankname: '',
});

const config = reactive({
  user: {
    money: 0,
    freeze_money: 0,
    cash_type: 1,
  },
  limit_num: 0,
  cash_fee_type: 0,
  cash_fee: 0,
  auto_cash_fee: 0,
  cash_limit_time: '',
  cash_min_money: 0,
  auto_cash_money: 0,
});

const fetchCashConfig = async () => {
  const { data } = await applyConfig();
  // data合并到config
  Object.assign(config, data);
};
fetchCashConfig();
const cashTypeHelp = computed(() => {
  if (config.user.cash_type === 1) {
    return `自动提现：每日自动结算，最低提现${config.auto_cash_money}元，手续费${config.auto_cash_fee}`;
  }
  if (config.user.cash_type === 2) {
    return `手动提现：允许提现时间次日${config.cash_limit_time}，最低提现${config.cash_min_money}元，手续费${config.cash_fee}`;
  }
  return '';
});
// getChangeCashType
const submitUserCashType = async () => {
  const res = await setUserCashType({
    cash_type: config.user.cash_type,
  });
  MessagePlugin.success(res.msg);
};

const labelAccount = () => {
  if (formData.type === 1) {
    return '支付宝账号';
  }
  if (formData.type === 2) {
    return '微信账号';
  }
  if (formData.type === 3) {
    return '银行卡账号';
  }
  return '支付宝账号';
};

// 禁用 allow_update=0 且 account 不为空
const disabled = computed(() => {
  if (formData.allow_update === 0) {
    return true;
  }
  return false;
});

const loading = ref(true);
const cashTypesOptions = ref([]);
const initUserChannel = async () => {
  const { data } = await getCollect();
  // 系统开启的收款方式
  cashTypesOptions.value = data.cashTypesOptions;
  if (data.info) {
    formData.account = data.info.info.account;
    formData.realname = data.info.info.realname;
    formData.idcard_number = data.info.info.idcard_number;
    formData.collect_img = data.info.collect_img;
    formData.type = data.info.type;
    formData.allow_update = data.info.allow_update;
  }
  loading.value = false;
};
initUserChannel();

const FORM_RULES: Record<string, FormRule[]> = {
  cash_type: [{ required: true, message: '请选择收款方式' }],
  account: [{ required: true, message: '请输入收款账号' }],
  realname: [{ required: true, message: '请输入收款人姓名' }],
  // 需要验证是否是身份证号
  idcard_number: [
    { required: true, message: '请输入身份证号' },
    { pattern: /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/, message: '请输入正确的身份证号' },
  ],
  // collect_img: [{ required: true, message: '请上传收款二维码' }],
};
const form = ref(null);
const onSubmit = async () => {
  // 校验表单
  const valid = await form.value.validate();
  if (typeof valid !== 'object' && valid) {
    // 如果收款账户是1或者2 则不需要填写银行卡信息bankname
    if (formData.type === 1 || formData.type === 2) {
      // 去掉银行卡信息
      delete formData.bankname;
    }
    const res = await setCollect(formData);
    if (res.code === 1) {
      MessagePlugin.success(res.msg);
    } else {
      MessagePlugin.error(res.msg);
    }
  }
};

const handleUpdateImage = ({ name, url }: any) => {
  // @ts-ignore
  formData[name] = url;
};
</script>

<style lang="less" scoped>
.title {
  font-size: 16px;
  font-weight: 600;
}
.tips {
  font-size: 14px;
  color: #999;
}
</style>
