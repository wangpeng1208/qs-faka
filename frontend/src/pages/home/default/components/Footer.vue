<template>
  <div id="bottom" class="footer">
    <div class="container">
      <div class="row">
        <div class="tiaoz_box col-lg-7 d-none d-lg-block">
          <div>
            <span>买家服务</span>
            <span>
              <a @click="goPage(`/order`)">订单查询</a>
            </span>
            <span>
              <a @click="goPage('/order', { ts: 1 })"> 投诉订单 </a>
            </span>
            <span><a @click="goPage(`/order`, { tscx: 1 })">投诉查询</a> </span>
          </div>
          <div>
            <span>卖家服务</span>
            <span>
              <a @click="goNoticePage('news_cate', 'notice')"> 公告通知 </a>
            </span>
            <span><a @click="goPage(`/login`)">登录注册</a></span>
            <span><a @click="goPage(`/userBase`)">商户中心</a></span>
          </div>
          <div>
            <span>法律条款</span>
            <!-- <span><a @click="goArticlePage('article', siteConfig.privacy_policy_id)">隐私政策</a></span>
            <span><a @click="goArticlePage('article', siteConfig.register_agreement_id)">注册协议</a> </span>
            <span><a @click="goArticlePage('article', siteConfig.goods_release_id)">商品发布条例</a></span> -->
            <span><a target="_blank" :href="siteConfig.privacy_policy_id">隐私政策</a></span>
            <span><a target="_blank" :href="siteConfig.register_agreement_id">注册协议</a> </span>
            <span><a target="_blank" :href="siteConfig.goods_release_id">商品发布条例</a></span>
          </div>
          <div>
            <span>关于我们</span>
            <span> <a @click="goPage(`/about`)">联系我们</a> </span>
            <!-- <span><a @click="goArticlePage('article', siteConfig.prohibited_catalog_id)">禁售目录</a></span>
            <span><a @click="goArticlePage('article', siteConfig.infringement_report_id)">侵权举报</a></span> -->
            <span><a target="_blank" :href="siteConfig.prohibited_catalog_id">禁售目录</a></span>
            <span><a target="_blank" :href="siteConfig.infringement_report_id">侵权举报</a></span>
          </div>
        </div>
        <div class="lxwb_text col-lg-5">
          <div class="col-lg-12">
            <span>平台客服</span>
            <span>Q Q：{{ siteConfig.site_info_qq }}</span>
            <span>邮箱：{{ siteConfig.site_info_email }}</span>
            <span>时间：{{ siteConfig.site_info_qq_desc }}</span>
          </div>

          <!-- <div class="qrcode_box col-lg-6">
            <div class="qrimg">
              <div>
                <img src="https://www.soufk.com/static/img/qrimg.jpg" />
                <span>扫码关注公众号</span>
              </div>
            </div>
          </div> -->
        </div>
      </div>
      <div class="beoan_box">
        <span>
          <a style="color: #333" href="https://beian.miit.gov.cn" target="_blank">{{ siteConfig.site_info_icp }}</a>
        </span>
        <span>
          <!-- <a href="https://dxzhgl.miit.gov.cn/dxxzsp/xkz/xkzgl/resource/qiyesearch.jsp?num=%25E5%25B7%259DB2-20220497&amp;type=xuke">中华人民共和国电信增值业务许可证：川B2-20220497 </a> -->
        </span>
        <span> {{ siteConfig.site_info_copyright }} </span>
        <!-- <a href="/index/plugin/risk.html" title="风控公示" class="aqlm">
          <img style="width: 134px; height: 48px; margin-left: 0px" src="../css/img/icon_foot_safe.png" alt="" />
        </a>
        <a target="cyxyv" href="https://xinyong.yunaq.com/certificate?domain=www.soufk.com" class="aqlm2">
          <img src="https://aqyzmedia.yunaq.com/labels/label_sm_90020.png" />
        </a> -->
      </div>
    </div>
  </div>
</template>
<script lang="ts">
export default {
  name: 'CFooter',
};
</script>
<script setup lang="ts">
import { computed } from 'vue';
// import { ref } from 'vue';
import { useRouter } from 'vue-router';

import { useSiteStore } from '@/store';

const router = useRouter();
const siteStore = useSiteStore();
const goPage = (path: string, query = {}) => {
  router.push({ path, query });
};
const goArticlePage = (name: string, id: any) => {
  router.push({
    name,
    params: {
      id,
    },
  });
};
const goNoticePage = (name: string, val: any) => {
  router.push({
    name,
    params: {
      alias: val,
    },
  });
};

// 获取site状态中的 site_info_email
const siteConfig = computed(() => siteStore.config);
</script>
<style lang="less" scoped>
@import url('../css/style.less');

#bottom {
  padding-top: 50px;
  font-size: 14px;
  bottom: 64px;
  margin: 0 auto;
  color: var(--td-text-color-secondary);

  .container {
    .lxwb_text {
      display: flex;

      span {
        color: #545454;
        display: block;

        &:first-child {
          font-size: 16px;
          font-weight: 700;
          padding-top: 0;
        }

        padding-top: 26px;
      }

      .icon_box {
        padding-top: 12px;

        img {
          width: 27px;
          margin-right: 9px;
          cursor: pointer;
        }
      }
    }

    .qrcode_box {
      .qrimg {
        div {
          margin-right: 45px;
          display: inline-block;

          img {
            width: 76px;
          }

          span {
            display: block;
            font-size: 12px;
            color: #545454;
            font-weight: 400;
            text-align: center;
            margin-top: 15px;
          }
        }
      }
    }

    .tiaoz_box {
      float: right;
      border-right: 1px solid #e6e6e6;
      a {
        color: #545454;

        &:hover {
          color: #2e62f0;
        }
      }

      div {
        &:first-child {
          margin-left: 0px;
        }

        display: inline-block;
        margin-left: 72px;
        vertical-align: top;

        span {
          &:last-child {
            margin-bottom: 0;
          }
          display: block;
          margin-bottom: 26px;
          color: #545454;
          font-size: 14px;
          cursor: pointer;
          -webkit-transition: color 0.5s;
          transition: color 0.5s;

          &:first-child {
            font-weight: 700;
          }

          &:hover {
            color: #2e62f0;
          }
        }
      }
    }

    .beoan_box {
      width: 100%;
      margin-top: 56px;
      position: relative;

      .b_left {
        width: 40%;
        margin-top: 56px;
        position: relative;
      }

      .b_right {
        width: 60%;
        margin-top: 56px;
        position: relative;
      }

      span {
        text-align: center;
        font-size: 12px;
        font-weight: 400;
        color: #545454;
        display: block;
        opacity: 0.5;
        margin: 15px;

        a {
          color: #545454;
        }
      }

      .aqlm {
        position: absolute;
        left: 45px;
        top: 0;
        cursor: pointer;
      }

      .aqlm2 {
        position: absolute;
        left: 185px;
        top: 0;
        cursor: pointer;
      }
    }
  }
}
</style>
