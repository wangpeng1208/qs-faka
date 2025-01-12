<template>
  <t-dialog v-model:visible="visible" :close-on-overlay-click="false" :destroy-on-close="true" :header="title" :on-confirm="onSubmit">
    <t-form ref="formRef" label-align="left" :data="formData" :rules="FORM_RULES" :label-width="80">
      <t-form-item label="接口名称" name="title">
        <t-input v-model="formData.title" clearable placeholder="请输入接口名称" />
      </t-form-item>
      <t-form-item label="充值费率" name="lowrate" tips="单位：千分之">
        <t-input v-model="formData.lowrate" theme="normal" type="number" clearable placeholder="请输入充值费率" suffix="‰" />
      </t-form-item>
      <t-form-item label="代码接口" name="code" tips="请输入接口名称(英文标识)，必须是home/collection里的文件名">
        <t-input v-model="formData.code" clearable placeholder="请输入接口名称(英文标识)" />
      </t-form-item>
      <t-form-item label="显示名称" name="show_name" tips="用于店铺售卡页支付方式名显示">
        <t-input v-model="formData.show_name" clearable placeholder="显示名称" />
      </t-form-item>
      <t-form-item label="账户字段" name="account_fields" tips="含证书字符的将自动识别为证书上传框">
        <t-textarea v-model="formData.account_fields" clearable placeholder="用户添加渠道账户所需的字段，用“|”分割字段,用:分隔名称，如：应用号:appid|应用秘钥:appsecret" />
      </t-form-item>
      <t-form-item label="申请地址" name="applyurl">
        <t-input v-model="formData.applyurl" clearable placeholder="请输入账户申请地址" />
      </t-form-item>
      <!-- 分类 -->
      <t-form-item label="分类" name="paytype">
        <t-select v-model="formData.paytype" clearable placeholder="请选择分类">
          <t-option v-for="item in payTypeOptions" :key="item.value" :value="item.value" :label="item.label">
            <div class="tdesign-demo__user-option">
              <img :src="item.ico" style="width: 16px" />
              <div class="tdesign-demo__user-option-info">
                <div>{{ item.label }}</div>
              </div>
            </div>
          </t-option>
        </t-select>
      </t-form-item>
      <t-form-item label="状态" name="status">
        <t-radio-group v-model="formData.status" :options="options" />
      </t-form-item>
      <!-- 适用终端 手机 1 电脑2 通用0 -->
      <t-form-item label="适用终端" name="is_available">
        <t-radio-group v-model="formData.is_available" :options="optionsType" />
      </t-form-item>
      <!-- 排序 -->
      <t-form-item label="排序" name="sort" tips="排序(越大越靠前)">
        <t-input-number v-model="formData.sort" theme="normal" :min="0" clearable placeholder="请输入排序" />
      </t-form-item>
    </t-form>
  </t-dialog>
</template>

<script lang="ts">
export default {
  name: 'AdminMenuEditPopup',
};
</script>

<script setup lang="ts">
import { FormRule, MessagePlugin } from 'tdesign-vue-next';
import { reactive, ref, watchEffect } from 'vue';

import { add, detail, edit } from '@/api/admin/channel/collection';

const options = [
  { label: '启用', value: 1 },
  { label: '禁用', value: 0 },
];
const optionsType = [
  { label: '手机', value: 1 },
  { label: '电脑', value: 2 },
  { label: '通用', value: 0 },
];
const DATA = {
  id: 0,
  title: '',
  code: '',
  show_name: '',
  account_fields: '',
  applyurl: '',
  status: 1,
  is_available: 1,
  sort: 0,
  lowrate: 0,
  type: 1,
  paytype: '',
  is_custom: 0,
};
const formData = reactive({ ...DATA });

const props = defineProps<{
  payTypeOptions: any;
}>();
const payTypeOptions = ref(props.payTypeOptions);
watchEffect(() => {
  payTypeOptions.value = props.payTypeOptions;
});
const formRef = ref();
const visible = ref(false);
const title = ref('添加收款渠道');
const init = (id: number) => {
  if (id) {
    title.value = '编辑收款渠道';
    getDetail(id);
  } else {
    title.value = '添加收款渠道';
    for (const key in DATA) {
      // @ts-ignore
      formData[key] = DATA[key];
    }
  }
  // initPayTypeOptions();

  visible.value = true;
};

const getDetail = async (id: number) => {
  const { data } = await detail({ id });
  for (const key in formData) {
    if (data[key] != null && data[key] !== undefined) {
      // @ts-ignore
      formData[key] = data[key];
    }
  }
};

defineExpose({
  init,
});

const FORM_RULES: Record<string, FormRule[]> = {
  title: [{ required: true, message: '必填', type: 'error' }],
  code: [{ required: true, message: '接口代码必选', type: 'error' }],
  paytype: [{ required: true, message: '分类必选，此处图标会显示在购卡页面', type: 'error' }],
};
const emit = defineEmits(['success']);
const onSubmit = async () => {
  const result = await formRef.value.validate();
  if (typeof result !== 'object' && result) {
    try {
      let res;
      if (formData.id > 0) {
        res = await edit(formData);
      } else {
        res = await add(formData);
      }
      if (res.code === 1) {
        MessagePlugin.success('操作成功');
        visible.value = false;
        emit('success');
      } else {
        MessagePlugin.error(res.msg);
      }
    } catch (e) {
      MessagePlugin.error(e.msg);
    }
  }
};
</script>

<style scoped>
.tdesign-demo__user-option {
  display: flex;
}

.tdesign-demo__user-option > img {
  max-width: 16px;
  max-height: 16px;
  border-radius: 50%;
}

.tdesign-demo__user-option-info {
  margin-left: 16px;
}
</style>
