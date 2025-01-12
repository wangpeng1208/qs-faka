<template>
  <div class="login-wrapper">
    <!-- <login-header /> -->
    <div class="h-full">
      <div class="login-container">
        <div class="title-container">
          <h1 class="title margin-no">{{ pageTitle }}</h1>
          <div class="sub-title">
            <p class="tip">{{ type == 'register' ? '已有账号?' : '没有账号吗?' }}</p>
            <p class="tip" @click="switchType(type == 'register' ? 'login' : 'register')">
              {{ type == 'register' ? '商户登录' : '注册新账号' }}
            </p>
          </div>
        </div>

        <login v-if="type === 'login'" />
        <register v-else @register-success="switchType('login')" />
        <!-- <tdesign-setting /> -->
      </div>
    </div>
    <footer class="copyright">{{ siteInfoCopyright }}</footer>
  </div>
</template>
<script lang="ts">
export default {
  name: 'DefaultLogin',
};
</script>
<script setup lang="ts">
import { computed, ref } from 'vue';

// import TdesignSetting from '@/layouts/setting.vue';
import { useSiteStore } from '@/store';

// import LoginHeader from './components/Header.vue';
// import { DialogPlugin } from 'tdesign-vue-next';
import Login from './components/Login.vue';
import Register from './components/Register.vue';

const pageTitle = ref('商户登录');
const type = ref('login');
const switchType = (val: string) => {
  type.value = val;
  pageTitle.value = val === 'login' ? '商户登录' : '商户注册';
};

const siteStore = useSiteStore();
const siteInfoCopyright = computed(() => siteStore.config.site_info_copyright);
</script>

<style lang="less" scoped>
@import './index.less';
</style>
