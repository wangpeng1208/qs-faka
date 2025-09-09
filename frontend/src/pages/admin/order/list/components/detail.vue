<template>
  <t-drawer v-model:visible="visible" :close-on-overlay-click="false" size="60%" :destroy-on-close="true" :header="title" :on-confirm="onSubmit">
    <div class="order-detail-container">
      <!-- 订单基本信息 -->
      <t-card title="订单基本信息" class="detail-card">
        <div class="info-grid">
          <div class="info-item">
            <div class="label">订单号</div>
            <div class="value primary">{{ fetchData.trade_no }}</div>
          </div>
          <div class="info-item">
            <div class="label">流水号</div>
            <div class="value">{{ fetchData?.transaction_id || '-' }}</div>
          </div>
          <div class="info-item">
            <div class="label">订单状态</div>
            <div class="value">
              <t-tag v-for="status in filteredStatusOptions" :key="status.value" :theme="status.theme" variant="light">
                {{ status.label }}
              </t-tag>
            </div>
          </div>
          <div class="info-item">
            <div class="label">取卡状态</div>
            <div class="value">
              <t-tag :theme="getCardStatusTheme()" variant="light">
                {{ getCardStatusText() }}
              </t-tag>
            </div>
          </div>
        </div>
      </t-card>

      <!-- 商户信息 -->
      <t-card title="商户信息" class="detail-card">
        <div class="info-grid">
          <div class="info-item">
            <div class="label">店铺名称</div>
            <div class="value">{{ fetchData?.shop?.shop_name }}</div>
          </div>
          <div class="info-item">
            <div class="label">商户账号</div>
            <div class="value">{{ fetchData?.user?.username }}</div>
          </div>
        </div>
      </t-card>

      <!-- 商品信息 -->
      <t-card title="商品信息" class="detail-card">
        <div class="info-grid">
          <div class="info-item">
            <div class="label">商品名称</div>
            <div class="value">{{ fetchData.goods_name }}</div>
          </div>
          <div class="info-item">
            <div class="label">商品数量</div>
            <div class="value">{{ fetchData.quantity }}件</div>
          </div>
          <div class="info-item">
            <div class="label">商品单价</div>
            <div class="value price">¥{{ fetchData.goods_price }}</div>
          </div>
          <div class="info-item">
            <div class="label">商品成本价</div>
            <div class="value">¥{{ fetchData.goods_cost_price }}</div>
          </div>
          <div class="info-item">
            <div class="label">优惠券</div>
            <div class="value">
              <span v-if="fetchData.coupon_type" class="coupon">优惠¥{{ fetchData.coupon_price }}</span>
              <span v-else class="text-gray">未使用</span>
            </div>
          </div>
          <div class="info-item">
            <div class="label">订单总价</div>
            <div class="value price-total">¥{{ fetchData.total_price }}</div>
          </div>
        </div>
      </t-card>

      <!-- 支付信息 -->
      <t-card title="支付信息" class="detail-card">
        <div class="info-grid">
          <div class="info-item">
            <div class="label">支付类型</div>
            <div class="value">
              <div class="pay-type">
                <img v-if="getPayTypeIcon()" :src="getPayTypeIcon()" class="pay-icon" />
                {{ paytype }}
              </div>
            </div>
          </div>
          <div class="info-item">
            <div class="label">交易通道</div>
            <div class="value">{{ fetchData?.channel?.title }}</div>
          </div>
          <div class="info-item">
            <div class="label">手续费率</div>
            <div class="value">{{ (fetchData.rate * 1000).toFixed(2) }}‰</div>
          </div>
          <div class="info-item">
            <div class="label">手续费</div>
            <div class="value">¥{{ fetchData.fee }}</div>
          </div>
        </div>
      </t-card>

      <!-- 买家信息 -->
      <t-card title="买家信息" class="detail-card">
        <div class="info-grid">
          <div class="info-item">
            <div class="label">联系方式</div>
            <div class="value">{{ fetchData.contact }}</div>
          </div>
          <div class="info-item">
            <div class="label">邮件通知</div>
            <div class="value">{{ fetchData.email_notify === 1 ? fetchData.email : '未设置' }}</div>
          </div>
          <div class="info-item">
            <div class="label">短信通知</div>
            <div class="value">{{ fetchData.sms_notify === 1 ? fetchData.contact : '未设置' }}</div>
          </div>
          <div class="info-item">
            <div class="label">取卡密码</div>
            <div class="value">{{ fetchData.take_card_type === 2 ? fetchData.take_card_password : '未设置' }}</div>
          </div>
        </div>
      </t-card>

      <!-- 时间信息 -->
      <t-card title="时间信息" class="detail-card">
        <div class="info-grid">
          <div class="info-item">
            <div class="label">提交时间</div>
            <div class="value">{{ formatTime(fetchData.create_at) }}</div>
          </div>
          <div class="info-item">
            <div class="label">提交IP</div>
            <div class="value">{{ fetchData.create_ip }}</div>
          </div>
          <div class="info-item">
            <div class="label">完成时间</div>
            <div class="value">{{ fetchData.success_at > 0 ? formatTime(fetchData.success_at) : '未完成' }}</div>
          </div>
          <div class="info-item">
            <div class="label">总成本价</div>
            <div class="value">¥{{ fetchData.total_cost_price }}</div>
          </div>
        </div>
      </t-card>
    </div>
  </t-drawer>
</template>
<script lang="ts">
export default {
  name: 'RowDetail',
};
</script>
<script setup lang="ts">
import { computed, reactive, ref, toRefs } from 'vue';

import { formatTime } from '@/utils/date';

import { statusOptions } from './constant';

// props payTypeOptions

const props = defineProps({
  payTypeOptions: {
    type: Array as () => { value: string | number; label: string; ico: string }[],
    default: () => [],
  },
});
const { payTypeOptions } = toRefs(props);
const paytype = computed(() => {
  return payTypeOptions.value.find((item) => item.value === fetchData.paytype)?.label;
});

const getPayTypeIcon = () => {
  return payTypeOptions.value.find((item) => item.value === fetchData.paytype)?.ico;
};

const filteredStatusOptions = computed(() => {
  return statusOptions.filter((status) => status.value === fetchData.status);
});

const getCardStatusTheme = () => {
  if (fetchData.cards_count === 0) return 'warning';
  if (fetchData.cards_count >= fetchData.quantity) return 'success';
  return 'primary';
};

const getCardStatusText = () => {
  if (fetchData.cards_count === 0) return '未取卡';
  if (fetchData.cards_count >= fetchData.quantity) return '已取卡';
  return `已取部分 (${fetchData.cards_count}/${fetchData.quantity})`;
};
const title = ref('订单详情');
const visible = ref(false);
const fetchData = reactive<any>({});
const init = (row: any) => {
  visible.value = true;
  Object.assign(fetchData, row);
};
const onSubmit = () => {
  visible.value = false;
};
defineExpose({
  init,
});
</script>

<style scoped>
.order-detail-container {
  padding: 0;
}

.detail-card {
  margin-bottom: 16px;
  border: 1px solid #e7e7e7;
}

.detail-card:last-child {
  margin-bottom: 0;
}

.info-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 16px 24px;
}

.info-item {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.label {
  font-size: 12px;
  color: #666;
  font-weight: 500;
}

.value {
  font-size: 14px;
  color: #333;
  word-break: break-all;
}

.value.primary {
  color: #0052d9;
  font-weight: 600;
  font-size: 16px;
}

.value.price {
  color: #e37318;
  font-weight: 500;
}

.value.price-total {
  color: #e37318;
  font-weight: 600;
  font-size: 16px;
}

.coupon {
  color: #00a870;
  font-weight: 500;
}

.text-gray {
  color: #999;
}

.pay-type {
  display: flex;
  align-items: center;
  gap: 8px;
}

.pay-icon {
  width: 20px;
  height: 20px;
  object-fit: contain;
}

@media (max-width: 768px) {
  .info-grid {
    grid-template-columns: 1fr;
    gap: 12px;
  }
}
</style>
