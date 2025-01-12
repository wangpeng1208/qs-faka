<template>
  <div>
    <div v-if="registerConfig.site_register_status">
      <t-form ref="form" :loading="loading" class="item-container" :data="formData" :rules="FORM_RULES" label-width="0" @submit="onSubmit">
        <t-form-item v-if="registerConfig.site_register_need_username" name="username">
          <t-input v-model="formData.username" type="text" size="large" placeholder="请输入用户名">
            <template #prefix-icon>
              <t-icon name="user" />
            </template>
          </t-input>
        </t-form-item>
        <t-form-item v-if="registerConfig.site_register_need_email" name="email">
          <t-input v-model="formData.email" type="text" size="large" placeholder="请输入邮箱">
            <template #prefix-icon>
              <t-icon name="mail" />
            </template>
          </t-input>
        </t-form-item>
        <!-- 邮箱验证码 -->
        <t-form-item v-if="registerConfig.site_register_need_email_check && registerConfig.site_register_need_email" name="email_code" class="code">
          <t-input v-model="formData.email_code" size="large" placeholder="请输入邮箱验证码">
            <template #prefix-icon>
              <t-icon name="mail" />
            </template>
          </t-input>
          <t-button v-if="registerConfig.site_register_need_email_check && registerConfig.site_register_need_email" variant="outline" :disabled="countDown > 0" @click="sendEmailCode">
            {{ countDown == 0 ? '获取验证码' : `${countDown}秒后可重发` }}
          </t-button>
        </t-form-item>
        <t-form-item v-if="registerConfig.site_register_need_mobile" name="mobile">
          <t-input v-model="formData.mobile" size="large" placeholder="请输入您的手机号">
            <template #prefix-icon>
              <t-icon name="mobile" />
            </template>
          </t-input>
        </t-form-item>
        <!-- 手机验证码 -->
        <t-form-item v-if="registerConfig.site_register_need_mobile_check && registerConfig.site_register_need_mobile" name="mobile_code" class="code">
          <t-input v-model="formData.mobile_code" size="large" placeholder="请输入手机验证码">
            <template #prefix-icon>
              <t-icon name="mobile" />
            </template>
          </t-input>
          <t-button v-if="registerConfig.site_register_need_mobile_check && registerConfig.site_register_need_mobile" variant="outline" :disabled="countDown > 0" @click="sendSmsCodePre">
            {{ countDown == 0 ? '获取验证码' : `${countDown}秒后可重发` }}
          </t-button>
        </t-form-item>
        <t-form-item name="password">
          <t-input v-model="formData.password" size="large" :type="showPsw ? 'text' : 'password'" clearable placeholder="请输入登录密码" autocomplete=" ">
            <template #prefix-icon>
              <t-icon name="lock-on" />
            </template>
            <template #suffix-icon>
              <t-icon :name="showPsw ? 'browse' : 'browse-off'" @click="showPsw = !showPsw" />
            </template>
          </t-input>
        </t-form-item>
        <t-form-item class="check-container" name="checkboxEd" @click="initAgreement">
          <t-checkbox v-model="formData.checkboxEd">我已阅读并同意 </t-checkbox>
          <span>服务协议</span> 和 <span> 隐私声明</span>
        </t-form-item>
        <agreement-page ref="agreementRef" @success="acceptAgreement" />
        <t-button block size="large" type="submit"> 注册 </t-button>
      </t-form>
    </div>
    <div v-else>
      <div class="register-close">
        <div class="item-container">
          <t-icon name="close" />
          系统已关闭注册
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { FormRule, MessagePlugin, SubmitContext } from 'tdesign-vue-next';
import { nextTick, ref } from 'vue';

import { getRegisterConfig, register, sendEmail, sendSms } from '@/api/merchant/user/account';
import { useCounter } from '@/hooks';

import AgreementPage from './Agreement.vue';

const CONFIG_DATA = {
  site_register_status: true,
  site_register_smscode_status: true,
  site_register_code_type: 'sms',
  site_register_need_username: false,
  site_register_need_mobile: true,
  site_register_need_mobile_check: true,
  site_register_need_email: false,
  site_register_need_email_check: false,
};
const registerConfig = ref({ ...CONFIG_DATA });

const [countDown, handleCounter] = useCounter();

const token = ref('');

const sendSmsCodePre = () => {
  // 如果手机号为空
  if (!formData.value.mobile) {
    MessagePlugin.error('请输入手机号');
    return;
  }
  sendSmsCode();
};

const sendSmsCode = async (data = {}) => {
  const params = {
    screen: 'register',
    mobile: formData.value.mobile,
    ...data,
  };
  const res = await sendSms(params);
  if (res.code === 1) {
    MessagePlugin.success(res.msg);
    handleCounter();
  } else {
    MessagePlugin.error(res.msg);
  }
};

const sendEmailCode = async () => {
  const params = {
    token: token.value,
    screen: 'verify_code',
    email: formData.value.email,
  };
  const res = await sendEmail(params);
  if (res.code === 1) {
    MessagePlugin.success(res.msg);
    handleCounter();
  } else {
    MessagePlugin.error(res.msg);
  }
};

// 表单开始
const INITIAL_DATA = {
  username: '',
  email: '',
  mobile: '',
  password: '',
  checkboxEd: false,
  email_code: '',
  mobile_code: '',
  invite_code: '',
};
const formData = ref({ ...INITIAL_DATA });

const FORM_RULES: Record<string, FormRule[]> = {};
// 向 FORM_RULES 添加表单验证规则
const addFormRules = () => {
  if (registerConfig.value.site_register_need_username) {
    FORM_RULES.username = [{ required: true, message: '用户名必填', type: 'error' }];
  }
  if (registerConfig.value.site_register_need_email) {
    FORM_RULES.email = [{ required: true, message: '邮箱必填', type: 'error' }];
    FORM_RULES.email.push({ email: true, message: '请输入正确的邮箱', type: 'warning' });
  }
  if (registerConfig.value.site_register_need_mobile) {
    FORM_RULES.mobile = [{ required: true, message: '手机号必填', type: 'error' }];
  }
  if (registerConfig.value.site_register_need_mobile && registerConfig.value.site_register_need_mobile_check) {
    FORM_RULES.mobile_code = [{ required: true, message: '手机验证码必填', type: 'error' }];
  }
  if (registerConfig.value.site_register_need_email && registerConfig.value.site_register_need_email_check) {
    FORM_RULES.email_code = [{ required: true, message: '邮箱验证码必填', type: 'error' }];
  }
  FORM_RULES.password = [{ required: true, message: '密码必填', type: 'error' }];
};

const form = ref();

const showPsw = ref(false);
const emit = defineEmits(['registerSuccess']);
const onSubmit = (ctx: SubmitContext) => {
  if (ctx.validateResult === true) {
    if (!formData.value.checkboxEd) {
      MessagePlugin.error('请同意注册协议 和 隐私政策');
      return;
    }
    register({ reginfo: formData.value })
      .then((res) => {
        if (res.code === 1) {
          MessagePlugin.success('注册成功');
          emit('registerSuccess');
        } else {
          MessagePlugin.error(res.msg);
        }
      })
      .catch(() => {
        MessagePlugin.error('注册失败');
      });
  }
};
const loading = ref(true);

const getConfig = async () => {
  const res = await getRegisterConfig();
  const { code, data } = res;
  if (code === 1) {
    registerConfig.value = { ...CONFIG_DATA, ...data };
    addFormRules();
    loading.value = false;
  }
};
getConfig();

const acceptAgreement = () => {
  formData.value.checkboxEd = true;
};
const agreementRef = ref();
const initAgreement = async () => {
  await nextTick();
  agreementRef.value.init(formData.value.checkboxEd);
};
initAgreement();
</script>

<style lang="less" scoped>
@import url('../index.less');
</style>
