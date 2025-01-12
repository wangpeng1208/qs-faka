<template>
  <t-dialog v-model:visible="visible" width="500" :close-on-overlay-click="false" :close-btn="false" :confirm-btn="confirmBtn" :cancel-btn="cancelBtn" :on-cancel="oncancel" :on-confirm="goPay">
    <t-card :bordered="false">
      <template #title>
        <div class="flex-container">
          <t-button shape="circle" theme="primary" size="large">
            <template #icon><creditcard-icon /></template>
          </t-button>
          <t-space class="middle-item" direction="vertical" size="small">
            <span class="order-title">
              <label>订单号:</label>
              {{ orderInfo.trade_no }}
            </span>
            <div class="remark">请牢记订单号，订单查询与订单投诉时使用</div>
          </t-space>
        </div>
      </template>
      <template #actions>
        <span class="order-copy">
          <t-button variant="outline" theme="primary" size="small" shape="round" @click="copyText(orderInfo.trade_no)"> 复制订单号 </t-button>
        </span>
      </template>
      <t-row>
        <t-col flex="auto">
          <t-tag> {{ orderInfo.goods_name }}</t-tag>
        </t-col>
        <t-col flex="none"> 订单金额：￥{{ orderInfo?.total_price }}</t-col>
      </t-row>

      <t-button block variant="outline" class="orderButtonToggle" @click="toggle">
        <template v-if="show" #icon><order-ascending-icon /></template>
        <template v-else #icon><order-descending-icon /></template>
        账单明细, 下单时间 {{ formatTime(orderInfo.create_time) }}
      </t-button>

      <div v-if="show" class="content">
        <div v-if="orderInfo.goods_price_old != orderInfo.goods_price" class="order-item flex-row">
          <span>商品原价</span>
          <span>￥{{ orderInfo.goods_price_old }}</span>
        </div>
        <div class="order-item flex-row">
          <span
            >商品单价

            <span v-if="orderInfo.goods_price_old != orderInfo.goods_price"> （批发优惠单价）</span>
          </span>
          <span>￥{{ orderInfo.goods_price }}</span>
        </div>
        <div class="order-item flex-row">
          <span>购买数量</span>
          <span>* {{ orderInfo.quantity }}</span>
        </div>

        <div class="order-item flex-row">
          <span>支付方式</span>
          <span>{{ orderInfo.paytype.title }}</span>
        </div>
        <div v-if="orderInfo.coupon_price" class="order-item flex-row">
          <span>优惠金额</span>
          <span>- ￥{{ orderInfo.coupon_price }}</span>
        </div>
        <div v-if="orderInfo.sms_price" class="order-item flex-row">
          <span>短信费用</span>
          <span>+ ￥{{ orderInfo.sms_price }}</span>
        </div>
        <div v-if="orderInfo.fee_player == 2" class="order-item flex-row">
          <span>交易手续费(买家承担)</span>
          <span>+ ￥{{ orderInfo.fee }}</span>
        </div>
        <div class="order-item flex-row">
          <span>订单原价</span>
          <span>+ ￥{{ orderInfo?.total_product_price }}</span>
        </div>
      </div>
      <t-checkbox v-model="checkboxEd" style="float: right">
        我已阅读并同意
        <t-link theme="primary" size="small" target="_blank" :href="orderInfo.purchase_agreement">购卡协议</t-link>
      </t-checkbox>
    </t-card>
    <t-alert style="margin-top: 20px">
      请在{{ orderInfo.order_auto_close_time / 60 }}分钟内完成订单
      <br />
      {{ countDown }}
    </t-alert>
  </t-dialog>
</template>

<script lang="ts">
export default {
  name: 'OrderDialog',
};
</script>

<script setup lang="ts">
import { CreditcardIcon, OrderAscendingIcon, OrderDescendingIcon } from 'tdesign-icons-vue-next';
import { MessagePlugin } from 'tdesign-vue-next';
import { ref, watch } from 'vue';

import { goPayment } from '@/api/shop/shop';
import { expireTime } from '@/hooks';
import { copyText } from '@/utils/common';
import { formatTime } from '@/utils/date';

const [countDown, handleCounter, clearTimer] = expireTime();

const show = ref(true);
// 显示隐藏账单明细
const toggle = () => {
  show.value = !show.value;
};
// 购卡协议
const checkboxEd = ref(false);
const visible = ref(false);
const orderInfo = ref<any>({
  trade_no: '',
  goods_name: '',
  create_time: '',
  goods_price_old: '',
  goods_price: '',
  quantity: '',
  paytype: {
    title: '',
  },
  coupon_price: '',
  sms_price: '',
  total_price: '',
  fee_player: '',
  total_product_price: '',
  fee: '',
  order_auto_close_time: '',
  purchase_agreement: '',
});
const init = (info: any) => {
  orderInfo.value = info;
  visible.value = true;
  // 当前时间加上订单自动关闭时间
  const endTieme = new Date().getTime() + info.order_auto_close_time * 1000;
  handleCounter(endTieme);
  confirmBtn.value = {
    content: '立即支付',
    theme: 'primary',
    loading: false,
  };
};
defineExpose({
  init,
});
const confirmBtn = ref({
  content: '去支付',
  theme: 'primary',
  loading: false,
});
const loading = ref(false);
const goPay = () => {
  if (!checkboxEd.value) {
    MessagePlugin.error('请先阅读并同意购卡协议');
    return;
  }
  const params = {
    trade_no: orderInfo.value?.trade_no,
  };
  loading.value = true;
  confirmBtn.value = {
    content: '支付中..',
    theme: 'primary',
    loading: true,
  };
  // 新窗口跳转 window.location.href = goPayment(params);
  window.open(goPayment(params));
};

const cancelBtn = ref({
  content: '取消',
  theme: 'default',
});

const oncancel = () => {
  // 清除计时
  clearTimer();
};

// watch countDown 变成已结束的时候 不显示 支付按钮
watch(countDown, (val) => {
  if (val === '已结束') {
    confirmBtn.value = null;
    countDown.value = `如果已经支付完成，请复制订单号及时取货，订单号为：${orderInfo.value?.trade_no}`;
  }
});
</script>

<style scoped lang="less">
:deep(.t-alert) {
  padding: var(--td-comp-paddingTB-s) var(--td-comp-paddingLR-xl);
}
:deep(.t-card) {
  box-shadow: none;
  background-color: var(--td-error-color-10);
  background-image: none;
}
:deep(.t-dialog__header .t-dialog__header-content) {
  display: block;
}
:deep(.t-dialog__header .t-icon) {
  margin-right: 0;
}
:deep(.t-dialog--default) {
  padding: 0 var(--td-comp-paddingTB-xxl) var(--td-comp-paddingLR-xxl) var(--td-comp-paddingLR-xxl);
}
:deep(.t-dialog__body) {
  padding: 0;
}

.flex-row {
  display: flex;
  justify-content: space-between;
}

.order-copy {
  margin-left: 35px;
  font-weight: 500;
  font-size: 12px;
  text-align: center;
  right: 0;
  top: 0;
}

.remark {
  font-size: 12px;
  color: #999;
}
.flex-container {
  display: flex;
  justify-content: flex-start;
  width: 100%;
}

.middle-item {
  margin-left: 20px;
}

.order-copy {
  margin-left: auto;
}
:deep(.t-card__body) {
  padding: var(--td-comp-paddingTB-l) var(--td-comp-paddingLR-l);
}
:deep(.t-card__header) {
  padding: 0 0 var(--td-comp-paddingTB-l) 0;
}
.content {
  padding: 0 0 var(--td-comp-paddingTB-l) 0;
}
.orderButtonToggle {
  margin: var(--td-comp-paddingTB-l) 0;
}
.content .order-item {
  margin-bottom: var(--td-comp-paddingTB-s);
  width: 100%;
  // 第一项
  &:first-child {
    margin-top: 0;
  }
  // 最后一项
  &:last-child {
    margin-bottom: 0;
  }
}
</style>
