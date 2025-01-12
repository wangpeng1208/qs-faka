<template>
  <t-dialog v-model:visible="visible" :destroy-on-close="true" :close-on-overlay-click="true" width="500" :footer="false" :close-btn="false">
    <template #header>
      <div class="dialog-header">
        <div class="dialog-title">{{ title }}</div>
      </div>
    </template>
    <template #body>
      <t-form ref="form" :data="formData" :rules="FORM_RULES" class="set-form" label-width="80px" label-align="left" @submit="onSubmit">
        <t-form-item label="邮箱账号" name="email">
          <t-input v-model:value="formData.email" placeholder="请输入邮箱账号" size="large" />
        </t-form-item>
        <t-form-item label="验证码" name="code" class="email">
          <t-input v-model:value="formData.code" placeholder="请输入验证码" size="large" />
          <t-button variant="outline" :disabled="countDown > 0" type="button" @click="getEmailCode">
            {{ countDown == 0 ? '获取验证码' : `${countDown}秒后可重发` }}
          </t-button>
        </t-form-item>
        <t-form-item class="button" label-width="0">
          <t-button class="form-submit-cancel" theme="default" size="large" variant="base" @click="closeCard"> 取消 </t-button>
          <t-button theme="primary" size="large" class="form-submit-confirm" type="submit"> 提交 </t-button>
        </t-form-item>
      </t-form>
    </template>
  </t-dialog>
</template>
<script lang="ts">
export default {
  name: 'EmailDialog',
};
</script>
<script setup lang="ts">
import { FormRule, MessagePlugin } from 'tdesign-vue-next';
import { reactive, ref } from 'vue';

import { bindEmail, sendEmailCode } from '@/api/merchant/user/user';
import { useCounter } from '@/hooks';

const emit = defineEmits(['success', 'close']);
const closeCard = () => {
  visible.value = false;
};

const [countDown, handleCounter] = useCounter();

const formData = reactive({
  email: '',
  code: '',
});

// 发送邮箱验证码
const getEmailCode = async () => {
  try {
    const data = await sendEmailCode({ email: formData.email });
    if (data.code === 1) {
      MessagePlugin.success(data.msg);
      handleCounter();
    } else {
      MessagePlugin.error(data.msg);
    }
  } catch (error) {
    MessagePlugin.error('发送失败。接口错误');
  }
};

const FORM_RULES: Record<string, FormRule[]> = {
  email: [
    { required: true, message: '请输入邮箱', type: 'error' },
    { pattern: /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/, message: '请输入正确的邮箱', type: 'error' },
  ],
  code: [
    { required: true, message: '请输入验证码', type: 'error' },
    { pattern: /^[0-9]{6}$/, message: '请输入正确的验证码', type: 'error' },
  ],
};
const form = ref(null);
const onSubmit = async () => {
  const result = await form.value.validate();
  if (typeof result !== 'object' && result) {
    const data = await bindEmail(formData);
    if (data.code === 1) {
      MessagePlugin.success(data.msg);
      emit('success');
    } else {
      MessagePlugin.error(data.msg);
    }
  }
};
const visible = ref(false);
const title = ref('绑定邮箱');
const open = (email: string) => {
  visible.value = true;
  formData.email = email;
  if (email) {
    title.value = '修改邮箱';
  }
};

defineExpose({
  open,
});
</script>

<style lang="less" scoped>
.dialog-header {
  padding: 10px 0;
  width: 100%;
  text-align: center;

  .dialog-title {
    font-size: 18px;
    font-weight: 600;
    color: var(--td-font-gray-3);
  }
}

.email {
  :deep(.t-form__controls-content) {
    display: flex;
    justify-content: space-between;
  }

  :deep(.t-form__controls) {
    button {
      flex-shrink: 0;
      width: 100px;
      height: 40px;
      margin-left: 11px;
    }
  }
}

.button {
  :deep(.t-form__controls-content) {
    display: flex;
    justify-content: space-between;

    .form-submit-confirm {
      width: 160px;
      height: 45px;
    }

    .form-submit-cancel {
      width: 160px;
      height: 45px;
    }
  }
}
</style>
