<template>
  <div class="container">
    <header>
      <t-head-menu theme="light" style="background-color: transparent">
        <template #logo>
          <img v-if="shopInfo.shop_logo" :src="shopInfo.shop_logo" style="width: 60px; margin-left: 0" />
          <img v-else height="28" src="./static/shop_img.png" alt="logo" style="margin-left: 0" />
          <div style="color: antiquewhite">
            {{ shopInfo.shop_name }}
          </div>
        </template>
        <template #operations>
          <t-space>
            <t-button theme="warning" shape="round" variant="base" @click="goPage(`/order`)">
              <template #icon>
                <search-icon class="icon" />
              </template>
              订单查询
            </t-button>
            <t-button theme="danger" shape="round" variant="base" @click="goPage(`/order`, { ts: 1 })">
              <template #icon>
                <shield-error-icon class="icon" />
              </template>
              投诉订单
            </t-button>
          </t-space>
        </template>
      </t-head-menu>
    </header>
    <div v-if="shopInfo.shop_notice_show == 1 && shopInfo.shop_notice != ''" class="notice">
      <span class="title">
        <notification-icon class="icon" />
        店铺公告
      </span>
      <span v-html="shopInfo.shop_notice"></span>
    </div>
    <div v-if="shopInfo.show_contact == 1" class="contact">
      <div v-if="shopInfo.shop_contact.mobile">
        <span class="title"><mobile-icon class="icon" />手机号：</span><span>{{ shopInfo.shop_contact.mobile }}</span>
      </div>
      <div v-if="shopInfo.shop_contact.qq">
        <span class="title"><logo-qq-icon class="icon" />QQ：</span><span>{{ shopInfo.shop_contact.qq }}</span>
      </div>
      <div v-if="shopInfo.shop_contact.wechat">
        <span class="title"><logo-wechat-stroke-icon class="icon" />微信号：</span><span>{{ shopInfo.shop_contact.wechat }}</span>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts" name="Header">
import { LogoQqIcon, LogoWechatStrokeIcon, MobileIcon, NotificationIcon, SearchIcon, ShieldErrorIcon } from 'tdesign-icons-vue-next';
import { toRefs } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();

const props = defineProps<{
  shopInfo: any;
}>();
const { shopInfo } = toRefs(props);

const goPage = (path: string, query = {}) => {
  router.push({ path, query });
};
</script>
<style lang="less" scoped>
header {
  padding: 10px 0;
}
.icon {
  font-size: 14px;
  margin-right: 5px;
}
.notice,
.contact {
  padding-top: var(--td-comp-paddingTB-s);
  color: var(--td-warning-color-light);
  .icon {
    font-size: 22px;
    margin-right: 10px;
    color: #fff;
    padding: 5px;
    background: linear-gradient(-45deg, transparent, #f5d08c);
    border-radius: 10px;
  }
}
.container,
.container-fluid,
.container-sm,
.container-md,
.container-lg,
.container-xl {
  width: 100%;
  padding-right: 15px;
  padding-left: 15px;
  margin-right: auto;
  margin-left: auto;
}

@media (min-width: 576px) {
  .container,
  .container-sm {
    max-width: 540px;
  }
}

@media (min-width: 768px) {
  .container,
  .container-sm,
  .container-md {
    max-width: 720px;
  }
}

@media (min-width: 992px) {
  .container,
  .container-sm,
  .container-md,
  .container-lg {
    max-width: 960px;
  }
}

@media (min-width: 1200px) {
  .container,
  .container-sm,
  .container-md,
  .container-lg,
  .container-xl {
    max-width: 1140px;
  }
}
</style>
