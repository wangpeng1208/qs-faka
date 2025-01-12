<template>
  <nav class="navbar navbar-expand-md navbar-dark">
    <div class="container">
      <a class="navbar-brand" style="width: 166px" @click="goPage('index', {})">
        <img :src="siteLogo" alt="" />
      </a>
      <div class="justify-content-end">
        <ul class="navbar-nav">
          <li v-for="(item, index) in navData" :key="index" class="nav-item" @click="goPage(item.name, item.params.alias)">
            <span class="nav-link hand-cursor">
              <span :class="currentTab == item.name ? 'active' : ''">{{ item.title }}</span>
            </span>
          </li>
          <li class="list-enter">
            <a v-if="!accessToken" id="red_reward" class="btn btn-enter register" @click="goPage('login', {})">商家登录</a>
            <a v-else id="red_reward" class="btn btn-enter" @click="goPath('/merchant/workbench')">商户中心</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>
<script lang="ts">
export default {
  name: 'CHeader',
};
</script>

<script setup lang="ts">
import { ref } from 'vue';
import { useRouter } from 'vue-router';

import { useSiteStore, useUserStore } from '@/store';

const router = useRouter();
const siteRouter = useSiteStore();
const siteLogo = siteRouter.getSiteLogo;
const userStore = useUserStore();
const { accessToken } = userStore;
const navData = [
  {
    title: '网站首页',
    name: 'index',
    params: {},
  },
  {
    title: '关于我们',
    name: 'about',
    params: {},
  },
  {
    title: '帮助中心',
    name: 'news_cate',
    params: {
      alias: 'faq',
    },
  },
  {
    title: '订单查询',
    name: 'order',
    params: {},
  },
];
// 当前页面的路由
const currentTab = ref('index');

const goPage = (name: string, value: any) => {
  currentTab.value = name;
  router.push({
    name,
    params: {
      alias: value,
    },
  });
};
const goPath = (path: string) => {
  router.push(path);
};
</script>
<style lang="less" scoped>
@import url('../css/style.less');
</style>
