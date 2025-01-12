<template>
  <t-card style="padding-top: 20px" class="basic-container" :bordered="false">
    <t-form ref="formRef" label-align="left" :data="formData" :rules="FORM_RULES" :label-width="150" style="width: 500px">
      <t-form-item label="站点开关" name="site_status">
        <t-radio-group
          v-model="formData.site_status"
          :options="[
            { label: '开启', value: 1 },
            { label: '关闭', value: -1 },
          ]"
        />
      </t-form-item>
      <!-- site_close_tips -->
      <t-form-item v-if="formData.site_status === -1" label="网站关闭提示" name="site_close_tips" tips="网站关闭时显示的提示信息">
        <t-input v-model="formData.site_close_tips" clearable placeholder="请填写网站关闭提示" />
      </t-form-item>
      <t-form-item label="网站名称" name="site_name" tips="网站名称，显示在浏览器标签上">
        <t-input v-model="formData.site_name" clearable placeholder="请填写网站名称" />
      </t-form-item>
      <t-form-item label="网站副标题" name="site_subtitle" tips="网站副标题，显示在浏览器标签上">
        <t-input v-model="formData.site_subtitle" clearable placeholder="请填写网站副标题" />
      </t-form-item>
      <t-form-item label="网站关键字" name="site_keywords" tips="一般不超过100个字符，关键词用英文逗号隔开">
        <t-input v-model="formData.site_keywords" clearable placeholder="请填写网站关键字" />
      </t-form-item>
      <t-form-item label="网站描述" name="site_desc">
        <t-input v-model="formData.site_desc" clearable placeholder="请填写网站描述" />
      </t-form-item>
      <t-form-item label="前台网站logo" name="site_logo" tips="推荐180*50px">
        <wp-upload theme="image" :initial="formData" name="site_logo" app="admin" :data="{ type: 'image' }" @update="handleUpdateImage" />
      </t-form-item>
      <t-form-item label="商户中心大logo" name="merchant_logo" tips="推荐120*30px">
        <wp-upload theme="image" :initial="formData" name="merchant_logo" app="admin" :data="{ type: 'image' }" @update="handleUpdateImage" />
      </t-form-item>
      <t-form-item label="商户中心小logo" name="merchant_logo_sm" tips="推荐64*64px">
        <wp-upload theme="image" :initial="formData" name="merchant_logo_sm" app="admin" :data="{ type: 'image' }" @update="handleUpdateImage" />
      </t-form-item>
      <t-form-item label="联系地址" name="site_info_address" tips="">
        <t-input v-model="formData.site_info_address" clearable placeholder="请填写联系地址" />
      </t-form-item>
      <t-form-item label="客服邮箱" name="site_info_email" tips="">
        <t-input v-model="formData.site_info_email" clearable placeholder="请填写客服邮箱" />
      </t-form-item>
      <t-form-item label="版权信息" name="site_info_copyright" tips="商户后台和前台底部通用">
        <t-input v-model="formData.site_info_copyright" clearable placeholder="请填写版权信息" />
      </t-form-item>
      <t-form-item label="售卡页版权信息" name="site_shop_copyright" tips="售卡页版权信息底部版权信息(支持html标签)">
        <t-input v-model="formData.site_shop_copyright" clearable placeholder="请填写售卡页版权信息" />
      </t-form-item>
      <t-form-item label="备案号码" name="site_info_icp">
        <t-input v-model="formData.site_info_icp" clearable placeholder="请填写备案号码" />
      </t-form-item>
      <t-form-item label="客服电话" name="site_info_tel">
        <t-input v-model="formData.site_info_tel" clearable placeholder="请填写客服电话" />
      </t-form-item>
      <t-form-item label="客服电话描述" name="site_info_tel_desc">
        <t-input v-model="formData.site_info_tel_desc" clearable placeholder="请填写客服电话描述" />
      </t-form-item>
      <t-form-item label="客服QQ" name="site_info_qq">
        <t-input v-model="formData.site_info_qq" clearable placeholder="请填写客服QQ" />
      </t-form-item>
      <t-form-item label="服务时间描述" name="site_info_qq_desc">
        <t-input v-model="formData.site_info_qq_desc" clearable placeholder="请填写服务时间描述" />
      </t-form-item>
    </t-form>

    <template #footer>
      <div>
        <t-space size="small">
          <t-button theme="primary" @click="submit">提交</t-button>
          <t-button theme="default" variant="base" type="reset">重置</t-button>
        </t-space>
      </div>
    </template>
  </t-card>
</template>

<script lang="ts">
export default {
  name: 'WebInfo',
};
</script>

<script setup lang="ts">
import { FormRule, MessagePlugin } from 'tdesign-vue-next';
import { reactive, ref } from 'vue';

import { editConfig, getConfig } from '@/api/admin/config/config';
import WpUpload from '@/components/upload/index.vue';

const formData = reactive({
  site_status: 1,
  site_close_tips: '',
  site_name: '',
  site_subtitle: '',
  site_keywords: '',
  site_desc: '',
  site_logo: '',
  merchant_logo: '',
  merchant_logo_sm: '',
  site_info_address: '',
  site_info_email: '',
  site_info_copyright: '',
  site_shop_copyright: '',
  site_info_icp: '',
  site_info_tel: '',
  site_info_tel_desc: '',
  site_info_qq: '',
  site_info_qq_desc: '',
});
const handleUpdateImage = ({ name, url }: any) => {
  // @ts-ignore
  formData[name] = url;
};
// 获取配置
const fetchConfig = async () => {
  const { data } = await getConfig({
    field: Object.keys(formData),
  });
  for (const key in data) {
    // @ts-ignore
    formData[key] = data[key];
  }
};
fetchConfig();

const FORM_RULES: Record<string, FormRule[]> = {
  site_status: [{ required: true, message: '请选择站点开关' }],
  site_name: [{ required: true, message: '请填写网站名称' }],
  site_subtitle: [{ required: true, message: '请填写网站副标题' }],
  site_info_address: [{ required: true, message: '请填写联系地址' }],
  site_info_email: [{ required: true, message: '请填写客服邮箱' }],
};
const formRef = ref();
const submit = async () => {
  const result = await formRef.value.validate();
  if (typeof result !== 'object' && result) {
    const res = await editConfig({
      data: formData,
    });
    if (res.code === 1) {
      MessagePlugin.success('操作成功');
    } else {
      MessagePlugin.error(res.msg);
    }
  }
};
</script>
<style lang="less" scoped>
:deep(.t-card__footer) {
  position: fixed;
  bottom: 0;
  background-color: var(--td-bg-color-container);
  width: 100%;
  margin: var(--td-comp-paddingTB-l) -var(--td-comp-paddingLR-xl);
  margin: -16px -59px 0px;
  padding-left: 200px;
  z-index: 50;
  border: solid 0.5px var(--td-component-stroke);
}
</style>
