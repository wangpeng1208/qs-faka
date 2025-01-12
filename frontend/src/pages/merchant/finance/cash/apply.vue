<template>
  <t-card title="提现申请" class="basic-container" :bordered="false">
    <t-loading attach=".basic-container" size="small" :loading="dataLoading"></t-loading>
    <div class="info-item">
      <h1>可提现次数</h1>
      <span>{{ config.limit_num }} 次</span>
      <div class="help">您今日可提现的次数</div>
    </div>
    <div class="info-item">
      <h1>可提现金额</h1>
      <span>{{ config.user.money }}元</span>
      <div class="help">冻结金额： {{ config.user.freeze_money }} 元</div>
    </div>
    <div class="info-item">
      <h1>手续费</h1>
      <span> {{ config.cash_fee }} </span>
      <div class="help">
        允许提现时间次日{{ config.cash_limit_time }}，最低提现<b>{{ config.cash_min_money }}</b
        >元
      </div>
    </div>
    <div class="info-item">
      <h1>提现金额</h1>
      <span><t-input-number v-model="form.money" :min="config.cash_min_money" :max="config.user.money" :step="1" :precision="2" theme="normal" /></span>
      <div class="help">当前可提现金额：{{ config.user.money }}元</div>
    </div>
    <div class="info-item">
      <t-button theme="primary" :loading="dataLoading" @click="handleApplyCash">提交</t-button>
    </div>
  </t-card>
</template>

<script lang="ts">
export default {
  name: 'UserLink',
};
</script>

<script setup lang="ts">
import { MessagePlugin } from 'tdesign-vue-next';
import { onMounted, reactive, ref } from 'vue';
import { useRouter } from 'vue-router';

import { applyCash, applyConfig } from '@/api/merchant/finance/cash';

const router = useRouter();
const dataLoading = ref(false);
const config = reactive({
  settlement_type: 0,
  user: {
    money: 0,
    freeze_money: 0,
  },
  limit_num: 0,
  cash_fee_type: 0,
  cash_fee: 0,
  auto_cash_fee: 0,
  cash_limit_time: '',
  cash_min_money: 0,
  auto_cash_money: 0,
});
const fetchData = async () => {
  dataLoading.value = true;
  const { data } = await applyConfig();
  // data合并到config
  Object.assign(config, data);
  dataLoading.value = false;
};

const form = reactive({
  money: config.cash_min_money,
});

const handleApplyCash = async () => {
  if (form.money < config.cash_min_money) {
    MessagePlugin.error(`最低提现金额为${config.cash_min_money}元`);
    return;
  }
  if (form.money > config.user.money) {
    MessagePlugin.error('提现金额不能大于可提现金额');
    return;
  }
  const res = await applyCash(form);
  if (res.code) {
    MessagePlugin.success('提交成功');
    router.push('/merchant/finance/cash/index');
    fetchData();
  } else {
    MessagePlugin.error(res.msg);
  }
};

onMounted(() => {
  fetchData();
});
</script>

<style lang="less" scoped>
.info-item {
  padding: var(--td-comp-paddingTB-m) 0;
  // display: flex;
  color: var(--td-text-color-primary);

  h1 {
    width: 100px;
    font-weight: normal;
    font: var(--td-font-body-medium);
    color: var(--td-text-color-secondary);
    text-align: left;
    line-height: 22px;
    float: left;

    @media (max-width: @screen-sm-max) {
      width: 100px;
    }

    @media (min-width: @screen-md-min) and (max-width: @screen-md-max) {
      width: 120px;
    }
  }

  span {
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    margin-left: 24px;
  }

  .help {
    color: var(--td-text-color-secondary);
    font-size: 12px;
    margin: 10px 0 0 124px;
  }

  img {
    width: 200px;
    height: 200px;
    margin-left: 24px;
  }

  i {
    display: inline-block;
    width: 8px;
    height: 8px;
    border-radius: var(--td-radius-circle);
    background: var(--td-success-color-5);
  }
}

.tag {
  cursor: pointer;
}
</style>
