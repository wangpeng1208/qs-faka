<template>
  <div class="login-wrapper">
    <div class="h-full">
      <div class="login-container">
        <div class="title-container"><h1 class="title margin-no">管理员登录</h1></div>
        <t-form ref="form" :class="['item-container', `login-${type}`]" :data="formData" :rules="FORM_RULES" label-width="0" @submit="onSubmit">
          <template v-if="type == 'password'">
            <t-form-item name="username">
              <t-input v-model="formData.username" size="large" placeholder="请输入账号/手机号/邮箱">
                <template #prefix-icon>
                  <t-icon name="user" />
                </template>
              </t-input>
            </t-form-item>

            <t-form-item name="password">
              <t-input v-model="formData.password" size="large" :type="showPsw ? 'text' : 'password'" clearable placeholder="请输入登录密码">
                <template #prefix-icon>
                  <t-icon name="lock-on" />
                </template>
                <template #suffix-icon>
                  <t-icon :name="showPsw ? 'browse' : 'browse-off'" @click="showPsw = !showPsw" />
                </template>
              </t-input>
            </t-form-item>
          </template>

          <t-form-item class="btn-container">
            <t-button block type="submit" size="large" :disabled="disabled"> {{ opt }} </t-button>
          </t-form-item>
        </t-form>
      </div>
    </div>
    <footer class="copyright">{{ siteInfoCopyright }}</footer>
  </div>
</template>

<script setup lang="ts">
import { FormInstanceFunctions, FormRule, MessagePlugin, SubmitContext } from 'tdesign-vue-next';
import { computed, ref } from 'vue';
import { useRouter } from 'vue-router';

import { useAdminUserStore, useSiteStore } from '@/store';

const router = useRouter();

const userStore = useAdminUserStore();
const init = () => {
  if (userStore.accessToken) {
    MessagePlugin.success('已登录, 正在跳转到工作台...');
    router.push({
      path: '/admin/workbench',
    });
  }
};
init();
const INITIAL_DATA = {
  username: '',
  password: '',
};

const FORM_RULES: Record<string, FormRule[]> = {
  username: [{ required: true, message: '用户名必填', type: 'error' }],
  password: [{ required: true, message: '密码必填', type: 'error' }],
};

const type = ref('password');

const form = ref<FormInstanceFunctions>();
const formData = ref({ ...INITIAL_DATA });
const showPsw = ref(false);

const opt = ref('登录');
const disabled = ref(false);
const onSubmit = async (ctx: SubmitContext) => {
  if (ctx.validateResult === true) {
    opt.value = '登录中...';
    disabled.value = true;
    try {
      await userStore.login(formData.value);
      MessagePlugin.success('登陆成功');
      router.push({
        path: '/admin/workbench',
      });
      disabled.value = false;
    } catch (e) {
      opt.value = '登录';
      disabled.value = false;
      MessagePlugin.error(e.msg);
    }
  }
};

const siteStore = useSiteStore();
const siteInfoCopyright = computed(() => siteStore.config.site_info_copyright);
</script>

<style lang="less" scoped>
@import url('./static/index.less');
</style>
