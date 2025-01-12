<template>
  <t-card title="店铺设置" :bordered="false">
    <t-form ref="form" :data="formData" :rules="FORM_RULES" label-align="left" :label-width="160" :status-icon="true" @submit="onSubmit">
      <div class="form-basic-item">
        <t-form-item label="店铺名称" name="shop_name" help="请输入2-10位中文、字母、数字、下划线">
          <t-input v-model="formData.shop_name" placeholder="请输入店铺名称" class="input-xl" show-limit-number :minlength="2" :maxlength="10" />
        </t-form-item>
        <!-- 店铺logo -->
        <t-form-item label="店铺logo" name="shop_logo" help="建议尺寸：100*100">
          <wp-upload theme="image" :initial="formData" name="shop_logo" app="merchant" :data="{ type: 'image' }" @update="handleUpdateImage" />
        </t-form-item>
        <t-form-item label="营业状态" name="shop_close" help="休息状态下无法下单">
          <wp-check-tag
            v-model="formData.shop_close"
            :items="[
              { label: '营业', value: 0 },
              { label: '休息', value: 1 },
            ]"
          />
        </t-form-item>

        <t-form-item v-if="formData.shop_close" label="休息提示" name="shop_close_notice" help="休息状态提示文字">
          <t-input v-model="formData.shop_close_notice" placeholder="休息状态提示文字" class="input-xl" />
        </t-form-item>

        <t-form-item label="公告开关" name="shop_notice_show" help="打开公告开关，店铺则显示公告">
          <wp-check-tag
            v-model="formData.shop_notice_show"
            :items="[
              { label: '开启', value: 1 },
              { label: '关闭', value: 0 },
            ]"
          />
        </t-form-item>
        <t-form-item v-if="formData.shop_notice_show === 1" label="店铺公告" name="shop_notice">
          <t-textarea v-model="formData.shop_notice" placeholder="店铺公告将在店铺页面展示" class="input-xl" />
        </t-form-item>
        <!-- 显示联系方式 -->
        <t-form-item label="联系方式" name="show_contact" help="开启后，店铺页面将显示联系方式">
          <wp-check-tag
            v-model="formData.show_contact"
            :items="[
              { label: '开启', value: 1 },
              { label: '关闭', value: 0 },
            ]"
            @actions="initCollapse"
          />
        </t-form-item>

        <t-collapse v-model="contactItem" :show-arrow="false" :expand-icon="false" :borderless="true" style="padding: 0">
          <t-collapse-panel value="show_contact">
            <template #default>
              <div>
                <t-form-item label="手机号码" name="mobile" help="非必填: 买家会透过联系方式与您联系，请准确填写">
                  <t-input v-model="formData.shop_contact.mobile" placeholder="请输入手机号码" class="input-xl" />
                </t-form-item>
                <t-form-item label="QQ号" name="qq" help="非必填: 买家会透过联系方式与您联系，请准确填写">
                  <t-input v-model="formData.shop_contact.qq" placeholder="请输入QQ号" class="input-xl" />
                </t-form-item>
                <t-form-item label="微信号" name="wechat" help="非必填: 买家会透过联系方式与您联系，请准确填写">
                  <t-input v-model="formData.shop_contact.wechat" placeholder="请输入微信号" class="input-xl" />
                </t-form-item>
              </div>
            </template>
          </t-collapse-panel>
        </t-collapse>

        <t-form-item label="库存展示" name="stock_display" :help="stockDisplayHelp">
          <wp-check-tag v-model="formData.stock_display" :items="state.stockDisplay" @actions="initStockDisplayHelp" />
        </t-form-item>
        <t-form-item label="费率承担方" name="rate_burden" help="系统收取的费率，系统默认为商户承担；一般都是商户承担">
          <wp-check-tag v-model="formData.fee_payer" :items="state.fee_payer" />
        </t-form-item>
        <t-form-item>
          <t-button theme="primary" class="form-submit-confirm" type="submit"> 提交 </t-button>
        </t-form-item>
      </div>
    </t-form>
  </t-card>
</template>

<script lang="ts">
export default {
  name: 'ShopSet',
};
</script>

<script setup lang="ts">
import { FormRule, MessagePlugin } from 'tdesign-vue-next';
import { reactive, ref } from 'vue';

import { index, saveConfig } from '@/api/merchant/shop/config';

const state = reactive({
  stockDisplay: [
    { label: '不显示库存数量', value: 0, tips: '不显示库存数量' },
    { label: '显示库存数量', value: 1, tips: '显示库存数量' },
    { label: '范围数量范围显示', value: 2, tips: '范围数量范围显示：非常多(>100)；库存很多(30-100);库存一般(10-30);少量(<10)' },
  ],
  fee_payer: [
    { label: '系统默认', value: 0 },
    { label: '商户承担', value: 1 },
    { label: '买家承担', value: 2 },
  ],
});

const formData = reactive({
  shop_name: '',
  shop_logo: '',
  show_contact: 0,
  shop_contact: {
    qq: '',
    mobile: '',
    wechat: '',
  },
  shop_notice: '',
  shop_notice_show: 0,
  merchant_end_time: 0,
  merchant_time: 0,
  stock_display: 1,
  fee_payer: 0,
  shop_close: 0,
  shop_close_notice: '',
});
const handleUpdateImage = ({ name, url }: any) => {
  // @ts-ignore
  formData[name] = url;
};
// 按formData.stock_display初始值 提前显示stockDisplayHelp的值

const stockDisplayHelp = ref('');
const initStockDisplayHelp = (value: number) => {
  stockDisplayHelp.value = state.stockDisplay.find((item) => item.value === value)?.tips;
};

const loading = ref(true);
const initUserSetting = async () => {
  try {
    const { data } = await index();
    // 将数据赋值给formData
    Object.keys(formData).forEach((key) => {
      if (data[key]) {
        (formData as any)[key] = data[key];
      }
      initCollapse(formData.show_contact);
    });
  } catch (e) {
    console.log(e);
  }
  loading.value = false;
};

const form = ref(null);
const FORM_RULES: Record<string, FormRule[]> = {
  shop_name: [
    {
      required: true,
      message: '请输入店铺名称',
    },
    {
      pattern: /^[\u4e00-\u9fa5_a-zA-Z0-9]{2,10}$/,
      message: '请输入2-10位中文、字母、数字、下划线',
    },
  ],
};
const onSubmit = async () => {
  // 校验表单
  const result = await form.value.validate();
  if (typeof result !== 'object' && result) {
    try {
      const data = await saveConfig(formData);
      if (data.code === 1) {
        // 提交成功
        MessagePlugin.success(data.msg);
        // 刷新页面
        initUserSetting();
      } else {
        MessagePlugin.error(data.msg);
      }
    } catch (e) {
      MessagePlugin.error(e);
    }
  } else {
    MessagePlugin.error('请完善必填项');
  }
};

const contactItem = ref([]);
const initCollapse = (val: any) => {
  if (val === 1) {
    contactItem.value = ['show_contact'];
  } else {
    contactItem.value = [];
  }
};
initUserSetting();
</script>

<style lang="less" scoped>
:deep(.t-collapse-panel__header),
:deep(.t-collapse-panel__content) {
  padding: 0 !important;
  display: inherit;
}
.input-xl {
  width: 415px;
}
:deep(.t-input__help) {
  padding: 10px 0;
}
</style>
