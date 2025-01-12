<template>
  <t-row :gutter="{ xs: 8, sm: 16, md: 24, lg: 32, xl: 32, xxl: 40 }">
    <t-col :span="3">
      <t-card title="销售额" header-bordered hover-shadow>
        <template #actions>
          <t-tag theme="primary" variant="light">今日</t-tag>
        </template>
        <t-space align="center">
          <t-statistic :value="price?.today" unit="元">
            <template #extra>
              <t-space direction="vertical" :size="0">
                <t-space align="center" :size="7">
                  <div style="width: 100px">昨日销售额</div>
                  <div>{{ price.yesterday }}元</div>
                  <t-icon v-if="price.today > price.yesterday" name="arrow-triangle-up-filled" style="color: #d54941; font-size: var(--td-font-size-body-large)" />
                  <t-icon v-else name="arrow-triangle-down-filled" style="color: #2ba471; font-size: var(--td-font-size-body-large)" />
                </t-space>
                <t-space align="center" :size="7">
                  <div style="width: 100px">平台总销售额</div>
                  <div>{{ price.total }}元</div>
                </t-space>
              </t-space>
            </template>
          </t-statistic>
        </t-space>
      </t-card>
    </t-col>
    <t-col :span="3">
      <t-card title="订单数" header-bordered hover-shadow>
        <template #actions>
          <t-tag theme="primary" variant="light">今日</t-tag>
        </template>
        <t-space align="center">
          <t-statistic :value="order?.today" unit="笔">
            <template #extra>
              <t-space direction="vertical" :size="0">
                <t-space align="center" :size="7">
                  <div style="width: 120px">昨日订单</div>
                  <div>
                    {{ order.yesterday }} 笔
                    <t-icon v-if="order.today > order.yesterday" name="arrow-triangle-up-filled" style="color: #d54941; font-size: var(--td-font-size-body-large)" />
                    <t-icon v-else name="arrow-triangle-down-filled" style="color: #2ba471; font-size: var(--td-font-size-body-large)" />
                  </div>
                </t-space>
                <t-space align="center" :size="7">
                  <div style="width: 120px">总订单数</div>
                  <div>{{ order.total }}笔</div>
                </t-space>
              </t-space>
            </template>
          </t-statistic>
        </t-space>
      </t-card>
    </t-col>
    <t-col :span="3">
      <t-card title="注册用户" header-bordered hover-shadow>
        <template #actions>
          <t-tag theme="primary" variant="light">今日</t-tag>
        </template>
        <t-space align="center">
          <t-statistic :value="user?.today" unit="">
            <template #extra>
              <t-space direction="vertical" :size="0">
                <t-space align="center" :size="20">
                  <div style="width: 60px">昨日注册量</div>
                  <div>{{ user.yesterday }}</div>
                  <div style="width: 60px">待审核用户</div>
                  <div>{{ user.audit }}</div>
                </t-space>
                <t-space align="center" :size="20">
                  <div style="width: 60px">总注册用户</div>
                  <div>{{ user.total }}</div>
                  <div style="width: 60px">总冻结用户</div>
                  <div>{{ user.frozen }}</div>
                </t-space>
              </t-space>
            </template>
          </t-statistic>
        </t-space>
      </t-card>
    </t-col>
    <t-col :span="3">
      <t-card title="结算统计" header-bordered hover-shadow>
        <template #actions>
          <t-tag theme="primary" variant="light">今日</t-tag>
        </template>
        <t-space align="center">
          <t-statistic :value="cash?.today" unit="笔">
            <template #extra>
              <t-space direction="vertical" :size="0">
                <t-space align="center" :size="7">
                  <div style="width: 120px">昨日结算</div>
                  <div>
                    {{ cash.yesterday }} 笔
                    <t-icon v-if="cash.today > cash.yesterday" name="arrow-triangle-up-filled" style="color: #d54941; font-size: var(--td-font-size-body-large)" />
                    <t-icon v-else name="arrow-triangle-down-filled" style="color: #2ba471; font-size: var(--td-font-size-body-large)" />
                  </div>
                </t-space>
                <t-space align="center" :size="7">
                  <div style="width: 120px">总结算数</div>
                  <div>{{ cash.total }}笔</div>
                </t-space>
              </t-space>
            </template>
          </t-statistic>
        </t-space>
      </t-card>
    </t-col>
  </t-row>
</template>

<script setup lang="ts">
// import { Divider } from 'tdesign-vue-next';
import { ref } from 'vue';

import { basic } from '@/api/admin/workbench';

// const separator = () => h(Divider, { layout: 'vertical', style: 'height:100%' });

const price = ref({
  today: 0,
  yesterday: 0,
  total: 0,
  ratio: 0,
});
const order = ref({
  today: 0,
  yesterday: 0,
  total: 0,
});
const user = ref({
  today: 0,
  yesterday: 0,
  // 冻结用户数
  frozen: 0,
  // 待审核用户数
  audit: 0,
  total: 0,
});
const cash = ref({
  today: 0,
  yesterday: 0,
  total: 0,
});
const fetchData = async () => {
  const res = await basic();
  const { data } = res;
  price.value = data.price;
  order.value = data.order;
  user.value = data.user;
  user.value.audit = data.notpass_user;
  user.value.frozen = data.frozen_user;
};
fetchData();
</script>
<style scoped>
:deep(.t-card__body) {
  padding-top: var(--td-comp-paddingTB-l) !important;
}
.icon {
  font-size: 60px;
  color: var(--td-brand-color);
  background: var(--td-brand-color-light);
  border-radius: var(--td-radius-medium);
  padding: 12px;
}
</style>
