<template>
  <t-dialog v-model:visible="visible" :close-on-overlay-click="false" :destroy-on-close="true" header="收款信息" :on-confirm="onSubmit">
    <t-form ref="formRef" v-perms="['adminapi/merchant/user/collectEdit']" label-align="left" :data="formData" :rules="FORM_RULES" :label-width="80">
      <t-form-item label="收款类型" name="type">
        <t-radio-group v-model="formData.type" name="type" :options="typeOptions"></t-radio-group>
      </t-form-item>
      <div v-if="formData.type === 1 || formData.type === 2" class="type">
        <t-form-item label="收款账号" name="account">
          <t-input v-model="formData.info.account" clearable placeholder="请输入收款账号" />
        </t-form-item>
        <t-form-item label="姓名" name="realname">
          <t-input v-model="formData.info.realname" clearable placeholder="请输入邮箱" />
        </t-form-item>
      </div>
      <div v-if="formData.type === 3" class="type">
        <t-form-item label="银行" name="bank_name">
          <t-input v-model="formData.info.bank_name" clearable placeholder="请输入银行" />
        </t-form-item>
        <t-form-item label="开户行" name="bank_branch">
          <t-input v-model="formData.info.bank_branch" clearable placeholder="请输入开户行" />
        </t-form-item>
        <t-form-item label="银行卡号" name="bank_card">
          <t-input v-model="formData.info.bank_card" clearable placeholder="请输入银行卡号" />
        </t-form-item>
        <t-form-item label="姓名" name="realname">
          <t-input v-model="formData.info.realname" clearable placeholder="请输入姓名" />
        </t-form-item>
      </div>
      <t-form-item label="身份证号码" name="idcard_number">
        <t-input v-model="formData.info.idcard_number" clearable placeholder="请输入身份证号码" />
      </t-form-item>
      <t-form-item v-if="formData.collect_img" label="收款图" name="collect_img">
        <t-image src="formData.collect_img" style="width: 200px" />
      </t-form-item>
      <t-form-item label="允许更新" name="allow_update">
        <t-radio-group v-model="formData.allow_update" :options="options" />
      </t-form-item>
    </t-form>
  </t-dialog>
</template>

<script lang="ts">
export default {
  name: 'CollectPopup',
};
</script>

<script setup lang="ts">
import { FormRule, MessagePlugin } from 'tdesign-vue-next';
import { ref } from 'vue';

import { collectDetail, collectEdit } from '@/api/admin/merchant/user';

const typeOptions = [
  { label: '支付宝', value: 1 },
  { label: '微信', value: 2 },
  { label: '银行卡', value: 3 },
];

const options = [
  { label: '是', value: 1 },
  { label: '否', value: 0 },
];

const DATA = {
  id: 0,
  user_id: 0,
  type: 1,
  info: {} as any,
  allow_update: 1,
  collect_img: '',
};

const formData = ref({ ...DATA });

const visible = ref(false);
const init = (id: number) => {
  getDetail(id);
  visible.value = true;
};

const getDetail = async (id: number) => {
  const { data } = await collectDetail({ id });
  for (const key in formData.value) {
    if (data[key] != null && data[key] !== undefined) {
      // @ts-ignore
      formData.value[key] = data[key];
    } else {
      // @ts-ignore
      formData.value[key] = DATA[key];
    }
  }
  formData.value.user_id = id;
};

defineExpose({
  init,
});


const FORM_RULES: Record<string, FormRule[]> = {};
const emit = defineEmits(['success']);
const formRef = ref();
const onSubmit = async () => {
  const result = await formRef.value.validate();
  if (typeof result !== 'object' && result) {
    const res = await collectEdit(formData.value);

    if (res.code === 1) {
      MessagePlugin.success(res.msg);
      visible.value = false;
      emit('success');
    } else {
      MessagePlugin.error(res.msg);
    }
  }
};
</script>

<style scoped lang="less">
.type {
  margin-bottom: var(--td-comp-margin-xxl);
}
</style>
