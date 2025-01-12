<template>
  <div id="index" class="index-wrapper">
    <c-header />
    <div class="about-banner">
      <div class="container">
        <div class="row">
          <div class="col-6 col-lg-7">
            <div class="txt">
              <h1>关于我们</h1>
              <p class="d-none d-lg-block">我们打破了传统软件注册码交易网站几年来一成不变的局面，建立了新一代软件注册码 电子商务交易平台的行业方向，我们将引领软件注册码交易过程的个性化、自动化、工具 化等。作为业内最善于创新的网站，力争成为行业的佼佼者。 企业官方网站：{{ siteConfig.site_domain }}</p>
            </div>
          </div>
          <div class="col-6 col-lg-5">
            <div class="img"><img src="../css/img/bg_about1.png" alt="" /></div>
          </div>
        </div>
        <div class="characteristic d-none d-lg-block">
          <div class="characteristic-box">
            <div class="row">
              <div class="col-lg-3">
                <img src="../css/img/icon_about1.png" alt="" />
                <dl>
                  <dt>极速发货</dt>
                  <dd>1秒急速响应,自动发货功能让您省心省力,收费更低,利润更高</dd>
                </dl>
              </div>
              <div class="col-lg-3">
                <img src="../css/img/icon_about2.png" alt="" />
                <dl>
                  <dt>准时结算</dt>
                  <dd>销售过程中对每笔订单都认真对待,不丢单不黑单,每天准时清算</dd>
                </dl>
              </div>
              <div class="col-lg-3">
                <img src="../css/img/icon_about3.png" alt="" />
                <dl>
                  <dt>信息推送</dt>
                  <dd>微信、邮件、短信多种方式实时发送,确保第一时间收到最新动态</dd>
                </dl>
              </div>
              <div class="col-lg-3">
                <img src="../css/img/icon_about4.png" alt="" />
                <dl>
                  <dt>安全保障</dt>
                  <dd>实时监视系统状态,确保资金安全和发货效率,集群部署,安全无忧</dd>
                </dl>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="customer">
      <div class="container">
        <div class="row">
          <div class="col-lg-7">
            <div class="customer-item">
              <div class="img"><img src="../css/img/icon_about5.png" alt="" /></div>
              <dl>
                <dt>客服帮助</dt>
                <dd>
                  <p>客服 QQ：{{ siteConfig.site_info_qq }}</p>
                  <p>服务时间：{{ siteConfig.site_info_qq_desc }}</p>
                </dd>
              </dl>
            </div>
          </div>
          <div class="col-lg-5">
            <div class="customer-item">
              <div class="img"><img src="../css/img/icon_about6.png" alt="" /></div>
              <dl>
                <dt>侵权投诉</dt>
                <dd>
                  <p>举报邮箱：{{ siteConfig.site_info_email }}</p>
                  <p>服务时间：{{ siteConfig.site_info_qq_desc }}</p>
                </dd>
              </dl>
            </div>
          </div>
        </div>
      </div>
    </div>
    <c-footer />
  </div>
</template>
<script lang="ts">
export default {
  name: 'DefaultAbout',
};
</script>
<script setup lang="ts">
import { computed } from 'vue';

// import { UserIcon } from 'tdesign-icons-vue-next';
// import { useRouter } from 'vue-router';
import { useSiteStore } from '@/store';

import CFooter from '../components/Footer.vue';
import CHeader from '../components/Header.vue';

const siteStore = useSiteStore();
const siteConfig = computed(() => siteStore.config);
</script>

<style lang="less" scoped>
@import url('../css/style.less');
@import url('../css/bootstrap.min.css');
</style>
