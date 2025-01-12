<template>
  <div class="result-success">
    <t-icon class="result-success-icon" :name="result.ico" />
    <div class="result-success-title">{{ result.title }}</div>
    <div v-if="result.loading" class="result-success-describe">订单号：{{ orderid }}</div>
    <div v-if="result.loading">正在为您跳转</div>
  </div>
</template>
<script lang="ts">
export default {
  name: 'PayResult',
};
</script>
<script setup lang="ts">
import { ref } from 'vue';
import { useRouter } from 'vue-router';

import { getGoodsOrderStatus } from '@/api/home/order';

const router = useRouter();
// 支付宝回调参数
const query = window.location.search.slice(1);
const params = new URLSearchParams(query);
const orderid = params.get('out_trade_no');
// 查询订单状态
const getOrderStatus = async () => {
  const res = await getGoodsOrderStatus({
    trade_no: orderid,
  });
  return res;
};

const result = ref({
  ico: 'loading',
  loading: false,
  title: '请稍等。。。',
});

// 计时器 每隔2s查询一次订单状态
const timer = setInterval(async () => {
  if (!orderid) {
    clearInterval(timer);
    return;
  }
  const res = await getOrderStatus();
  if (res.code === 0) {
    result.value.ico = 'close-circle';
    result.value.loading = false;
    result.value.title = res.msg;
    clearInterval(timer);

    return;
  }
  if (res.code === 1) {
    result.value = {
      ico: 'check-circle',
      loading: false,
      title: '支付成功',
    };
    clearInterval(timer);
    setTimeout(() => {
      goOrderPage(res.data.path, { orderId: orderid });
    }, 2000);
  }
}, 2000);

const goOrderPage = (path: string, query = {}) => {
  router.push({ path, query });
};
</script>
<style lang="less" scoped>
.result-success {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  height: 75vh;

  &-icon {
    font-size: var(--td-comp-size-xxxxl);
    color: var(--td-success-color);
  }

  &-title {
    margin-top: var(--td-comp-margin-xxl);
    font: var(--td-font-title-large);
    color: var(--td-text-color-primary);
    text-align: center;
  }

  &-describe {
    margin: var(--td-comp-margin-s) 0 var(--td-comp-margin-xxxl);
    font: var(--td-font-body-medium);
    color: var(--td-text-color-secondary);
  }
}
</style>
